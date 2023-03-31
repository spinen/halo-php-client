<?php

namespace Tests\Feature;

use Carbon\Carbon;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Str;
use Spinen\Halo\Api\Client;
use Spinen\Halo\Api\Token;
use Spinen\Halo\Exceptions\ClientConfigurationException;
use Tests\TestCase;

/**
 * Class RequestClientCredentialsTokenTest
 */
class RequestClientCredentialsTokenTest extends TestCase
{
    /**
     * @test
     */
    public function it_will_get_a_valid_token_using_client_credentials()
    {
        Carbon::setTestNow(Carbon::now());

        $history = [];
        $response = [
            'access_token' => Str::random(),
            'expires_in' => random_int(1000, 2000),
            'id_token' => Str::random(),
            'refresh_token' => Str::random(),
            'scope' => Str::random(),
            'token_type' => Str::random(),
        ];

        $this->configs['oauth']['client_credentials']['id'] = $client_id = Str::random();
        $this->configs['oauth']['client_credentials']['secret'] = $client_secret = Str::random();

        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(body: json_encode($response)),
        ]));
        $handlerStack->push(Middleware::history($history));

        $client = (new Client(
            configs: $this->configs,
            guzzle: new Guzzle(['handler' => $handlerStack])
        ));

        $token = $client->oauthRequestTokenUsingClientCredentials($response['scope']);

        $this->assertInstanceOf(Token::class, $token);
        $this->assertEquals('client_credentials', $token->grant_type, 'Token: grant_type');
        $this->assertEquals($response['expires_in'], $token->validFor(), 'Token: expires_in');

        Carbon::setTestNow();
        // Remove from loop
        unset($response['expires_in']);

        $this->assertNull($token->refresh_token, 'Token: refresh_token');
        // Remove from loop, since it is not saved with the token
        unset($response['refresh_token']);

        foreach ($response as $key => $value) {
            $this->assertEquals($value, $token->{$key}, 'Token: '.$key);
        }

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertFalse($history[0]['options']['debug'], 'Debug');
        $this->assertEquals($this->configs['oauth']['authorization_server'].'/token', (string) $request?->getUri(), 'URI');
        $this->assertEquals('POST', $request?->getMethod(), 'Verb');
        $this->assertEmpty($request?->getHeader('Authorization'), 'Authorization');
        $this->assertEquals('application/x-www-form-urlencoded', $request?->getHeader('Content-Type')[0], 'Content-Type');

        $form_params = [];
        parse_str($request?->getBody()?->getContents(), $form_params);

        $this->count(4, $form_params, 'Expected number of form params');
        $this->assertEquals($client_id, $form_params['client_id'], 'Form Params: client_id');
        $this->assertEquals($client_secret, $form_params['client_secret'], 'Form Params: client_secret');
        $this->assertEquals('client_credentials', $form_params['grant_type'], 'Form Params: grant_type');
        $this->assertEquals($response['scope'], $form_params['scope'], 'Form Params: scope');
    }

    /**
     * @test
     */
    public function it_raises_exception_when_getting_client_credential_token_without_client_id()
    {
        $this->expectException(ClientConfigurationException::class);

        unset($this->configs['oauth']['client_credentials']['id']);

        (new Client(
            configs: $this->configs,
            guzzle: new Guzzle([
                'handler' => HandlerStack::create(new MockHandler([
                    new Response(),
                ])),
            ]),
        ))
            ->oauthRequestTokenUsingClientCredentials(Str::random());
    }

    /**
     * @test
     */
    public function it_raises_exception_when_getting_client_credential_token_without_client_secret()
    {
        $this->expectException(ClientConfigurationException::class);

        $this->configs['oauth']['client_credentials']['id'] = Str::random();
        unset($this->configs['oauth']['client_credentials']['secret']);

        (new Client(
            configs: $this->configs,
            guzzle: new Guzzle([
                'handler' => HandlerStack::create(new MockHandler([
                    new Response(),
                ])),
            ]),
        ))
            ->oauthRequestTokenUsingClientCredentials(Str::random());
    }
}
