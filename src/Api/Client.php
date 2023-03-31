<?php

namespace Spinen\Halo\Api;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use RuntimeException;
use Spinen\Halo\Exceptions\ClientConfigurationException;
use Spinen\Halo\Exceptions\TokenException;

/**
 * Class Client
 */
class Client
{
    /**
     * Client constructor.
     */
    public function __construct(
        protected array $configs,
        protected Guzzle $guzzle = new Guzzle,
        protected Token $token = new Token,
        protected bool $debug = false,
    ) {
        $this->setConfigs($configs);
        $this->setToken($token);
    }

     /**
      * Shortcut to 'DELETE' request
      *
      * @throws GuzzleException
      * @throws TokenException
      */
     public function delete(string $path): ?array
     {
         return $this->request($path, [], 'DELETE');
     }

    /**
     * Generate keys need for PKCE
     */
    public function generateProofKey(int $length = 30): array
    {
        return $this->configs['oauth']['authorization_code']['pkce']
            ? [
                'verifier' => $verifier = base64_encode(Str::random($length)),
                // Convert "+" to "-" & "/" to "_" & remove trailing "="
                'challenge' => rtrim(
                    characters: '=',
                    string: strtr(
                        from: '+/',
                        string: base64_encode(hash(algo: 'sha256', data: $verifier, binary: true)),
                        to: '-_',
                    ),
                ),
            ]
            : []; // TODO: Should this be ['challenge' => null, 'verifier' => null]?
    }

    /**
     * Shortcut to 'GET' request
     *
     * @throws GuzzleException
     * @throws TokenException
     */
    public function get(string $path): ?array
    {
        return $this->request($path, [], 'GET');
    }

    /**
     * Get, return, or refresh the token
     *
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function getToken(): Token
    {
        return match (true) {
            $this->token->isValid() => $this->token,
            $this->token->needsRefreshing() => $this->token = $this->oauthRequestToken([
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->token->refresh_token,
            ]),
            default => $this->token = $this->oauthRequestTokenUsingClientCredentials(),
        };
    }

    /**
     * Request a token
     *
     * @throws ClientConfigurationException
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function oauthRequestToken(array $params): Token
    {
        // Use existing grant_type to not let a refresh type override
        $grant_type = $this->token->grant_type ?? $params['grant_type'];

        if (is_null($this->configs['oauth'][$grant_type]['id'] ?? null)) {
            throw new ClientConfigurationException('The "client_id" for "'.$grant_type.'" cannot be null');
        }

        try {
            $this->token = new Token(...['grant_type' => $grant_type] + json_decode(
                associative: true,
                json: $this->guzzle->request(
                    method: 'POST',
                    options: [
                        'debug' => $this->debug,
                        'form_params' => [
                            'client_id' => $this->configs['oauth'][$grant_type]['id'],
                            ...$params,
                        ],
                        'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded',
                        ],
                    ],
                    uri: $this->uri(
                        path: 'token?'.http_build_query(
                            $this->configs['tenant'] ? ['tenant' => $this->configs['tenant']] : [],
                        ),
                        url: $this->configs['oauth']['authorization_server']
                    ),
                )
                    ->getBody()
                    ->getContents(),
            ));

            return $this->token;
        } catch (GuzzleException $e) {
            // TODO: Figure out what to do with this error
            // TODO: Consider returning [] for 401's?

            throw $e;
        }
    }

    /**
     * Convert OAuth code to scoped token for user
     *
     * @throws ClientConfigurationException
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function oauthRequestTokenUsingAuthorizationCode(string $code, string $uri, ?string $verifier = null, ?string $scope = null): Token
    {
        if ($this->configs['oauth']['authorization_code']['pkce'] && is_null($verifier)) {
            throw new ClientConfigurationException('PKCE is enabled, but no code verifier was provided.');
        }

        return $this->oauthRequestToken([
            'code' => $code,
            ...$verifier ? ['code_verifier' => $verifier] : [],
            'grant_type' => 'authorization_code',
            'redirect_uri' => $uri,
            'scope' => $scope ?? $this->token->scope,
        ]);
    }

    /**
     * Request a scoped token via client credentials
     *
     * @throws ClientConfigurationException
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function oauthRequestTokenUsingClientCredentials(?string $scope = null): Token
    {
        if (is_null($this->configs['oauth']['client_credentials']['secret'] ?? null)) {
            throw new ClientConfigurationException('The "client_secret" for "client_credentials" cannot be null');
        }

        return tap($this->oauthRequestToken([
            'client_secret' => $this->configs['oauth']['client_credentials']['secret'],
            'grant_type' => 'client_credentials',
            'scope' => $scope ?? $this->token->scope,
            // You cannot refresh a client credential token, so null it out
        ]), fn (Token $t): ?Token => $t->refresh_token = null);
    }

    /**
     * Build the uri to redirect the user to start the OAuth process
     *
     * @throws ClientConfigurationException
     */
    public function oauthUri(string $uri, ?string $challenge = null, ?string $scope = null): string
    {
        if (is_null($this->configs['oauth']['authorization_code']['id'] ?? null)) {
            throw new ClientConfigurationException('The "client_id" for "authorization_code" cannot be null');
        }

        if ($this->configs['oauth']['authorization_code']['pkce'] && is_null($challenge)) {
            throw new ClientConfigurationException('PKCE is enabled, but no code challenge was provided.');
        }

        return $this->uri(
            path: 'authorize?'.http_build_query(
                [
                    'client_id' => $this->configs['oauth']['authorization_code']['id'],
                    ...$challenge
                        ? [
                            'code_challenge_method' => 'S256',
                            'code_challenge' => $challenge,
                        ]
                        : [],
                    'redirect_uri' => $uri,
                    'response_type' => 'code',
                    'scope' => $scope ?? $this->token->scope,
                    ...$this->configs['tenant'] ? ['tenant' => $this->configs['tenant']] : [],
                ]),
            url: $this->configs['oauth']['authorization_server']
        );
    }

    /**
     * Shortcut to 'POST' request
     *
     * @throws GuzzleException
     * @throws TokenException
     */
    public function post(string $path, array $data): ?array
    {
        return $this->request($path, $data, 'POST');
    }

    /**
     * Shortcut to 'PUT' request
     *
     * @throws GuzzleException
     * @throws TokenException
     */
    public function put(string $path, array $data): ?array
    {
        return $this->request($path, $data, 'PUT');
    }

    /**
     * Make an API call to Halo
     *
     * @throws GuzzleException
     * @throws TokenException
     */
    public function request(?string $path, ?array $data = [], ?string $method = 'GET'): ?array
    {
        try {
            return json_decode(
                associative: true,
                json: $this->guzzle->request(
                    method: $method,
                    options: [
                        'debug' => $this->debug,
                        'headers' => [
                            'Authorization' => (string) $this->getToken(),
                            'Content-Type' => 'application/json',
                        ],
                        'body' => empty($data) ? null : json_encode($data),
                    ],
                    uri: $this->uri($path),
                )
                    ->getBody()
                    ->getContents(),
            );
        } catch (GuzzleException $e) {
            // TODO: Figure out what to do with this error
            // TODO: Consider returning [] for 401's?

            throw $e;
        }
    }

     /**
      * Validate & set the configs
      *
      * @throws ClientConfigurationException
      */
     protected function setConfigs(array $configs): self
     {
         // Replace empty strings with nulls in config values
         $this->configs = array_map(fn ($v) => $v === '' ? null : $v, $configs);

         // Default to true if not set
         $this->configs['oauth']['authorization_code']['pkce'] ??= true;

         if (is_null($this->configs['oauth']['authorization_server'] ?? null)) {
             throw new ClientConfigurationException('The "authorization_server" cannot be null');
         }

         if (! filter_var($this->configs['oauth']['authorization_server'], FILTER_VALIDATE_URL)) {
             throw new ClientConfigurationException(
                 sprintf('A valid url must be provided for "authorization_server" [%s]', $this->configs['oauth']['authorization_server'])
             );
         }

         if (is_null($this->configs['resource_server'] ?? null)) {
             throw new ClientConfigurationException('The "resource_server" cannot be null');
         }

         if (! filter_var($this->configs['resource_server'], FILTER_VALIDATE_URL)) {
             throw new ClientConfigurationException(
                 sprintf('A valid url must be provided for "resource_server" [%s]', $this->configs['resource_server'])
             );
         }

         return $this;
     }

    /**
     * Set debug
     */
    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * Set the token & refresh if needed
     */
    public function setToken(Token|string $token): self
    {
        $this->token = is_string($token)
            ? new Token(access_token: $token)
            : $token;

        return $this;
    }

    /**
     * URL to Halo
     *
     * If path is passed in, then append it to the end. By default, it will use the url
     * in the configs, but if a url is passed in as a second parameter then it is used.
     * If no url is found it will use the hard-coded v2 Halo API URL.
     */
    public function uri(?string $path = null, ?string $url = null): string
    {
        if ($path && Str::startsWith($path, 'http')) {
            return $path;
        }

        $path = ltrim($path ?? '/', '/');

        return rtrim($url ?? $this->configs['resource_server'], '/')
            .($path ? (Str::startsWith($path, '?') ? null : '/').$path : '/');
    }

    /**
     * Is the token valid & if provided a scope, is the token approved for the scope
     */
    public function validToken(?string $scope = null): bool
    {
        return $this->token->isValid($scope);
    }
}
