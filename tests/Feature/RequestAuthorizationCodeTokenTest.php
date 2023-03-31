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
 * Class RequestAuthorizationCodeTokenTest
 */
class RequestAuthorizationCodeTokenTest extends TestCase
{
    /**
     * @test
     */
    public function it_will_get_a_valid_token_from_an_authorization_code()
    {
        Carbon::setTestNow(Carbon::now());

        $code = Str::random();
        $history = [];
        $redirect_uri = Str::random();
        $response = [
            'access_token' => Str::random(),
            'expires_in' => random_int(1000, 2000),
            'id_token' => Str::random(),
            'refresh_token' => Str::random(),
            'scope' => Str::random(),
            'token_type' => Str::random(),
        ];
        $verifier = Str::random();

        $this->configs['oauth']['authorization_code']['id'] = $client_id = Str::random();

        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(body: json_encode($response)),
        ]));
        $handlerStack->push(Middleware::history($history));

        $client = (new Client(
            configs: $this->configs,
            guzzle: new Guzzle(['handler' => $handlerStack])
        ));

        $token = $client->oauthRequestTokenUsingAuthorizationCode(
            code: $code,
            scope: $response['scope'],
            uri: $redirect_uri,
            verifier: $verifier,
        );

        $this->assertInstanceOf(Token::class, $token);
        $this->assertEquals('authorization_code', $token->grant_type, 'Token: grant_type');
        $this->assertEquals($response['expires_in'], $token->validFor(), 'Token: expires_in');

        Carbon::setTestNow();
        // Remove from loop
        unset($response['expires_in']);

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

        $this->count(6, $form_params, 'Expected number of form params');
        $this->assertEquals($client_id, $form_params['client_id'], 'Form Params: client_id');
        $this->assertEquals($code, $form_params['code'], 'Form Params: code');
        $this->assertEquals($verifier, $form_params['code_verifier'], 'Form Params: code_verifier');
        $this->assertEquals('authorization_code', $form_params['grant_type'], 'Form Params: grant_type');
        $this->assertEquals($redirect_uri, $form_params['redirect_uri'], 'Form Params: redirect_uri');
        $this->assertEquals($response['scope'], $form_params['scope'], 'Form Params: scope');
    }

    /**
     * @test
     */
    public function it_raises_exception_when_getting_authorization_token_without_verifier()
    {
        $this->expectException(ClientConfigurationException::class);

        // default, but make it clear that it is required
        $this->configs['oauth']['authorization_code']['pkce'] = true;

        (new Client(
            configs: $this->configs,
            guzzle: new Guzzle([
                'handler' => HandlerStack::create(new MockHandler([
                    new Response(body: '{}'),
                ])),
            ]),
        ))
            ->oauthRequestTokenUsingAuthorizationCode(
                code: Str::random(),
                scope: Str::random(),
                uri: Str::random(),
                verifier: null, // This would trigger the error
            );
    }

    /**
     * @test
     */
    public function it_raises_exception_when_getting_authorization_token_without_client_id()
    {
        $this->expectException(ClientConfigurationException::class);

        unset($this->configs['oauth']['authorization_code']['id']);

        (new Client(
            configs: $this->configs,
            guzzle: new Guzzle([
                'handler' => HandlerStack::create(new MockHandler([
                    new Response(),
                ])),
            ]),
        ))
            ->oauthRequestTokenUsingAuthorizationCode(
                code: Str::random(),
                scope: Str::random(),
                uri: Str::random(),
                verifier: Str::random(),
            );
    }
}
