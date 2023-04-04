<?php

namespace Tests\Unit\Api;

use Carbon\Carbon;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Str;
use Spinen\Halo\Api\Client;
use Spinen\Halo\Api\Token;
use Spinen\Halo\Exceptions\ClientConfigurationException;
use Tests\TestCase;
use TypeError;

/**
 * Class ClientTest
 */
class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_constructed()
    {
        $this->assertInstanceOf(Client::class, new Client($this->configs));
    }

    /**
     * @test
     */
    public function it_expects_the_configs_argument_to_be_an_array()
    {
        $this->expectException(TypeError::class);

        new Client(configs: '');
    }

    /**
     * @test
     */
    public function it_defaults_pkce_to_true_if_not_set()
    {
        $client = new Client($this->configs);

        $this->assertArrayHasKey('verifier', $client->generateProofKey(), 'Baseline');

        // Unset
        unset($this->configs['oauth']['authorization_code']['pkce']);

        $client = new Client($this->configs);

        $this->assertArrayHasKey('verifier', $client->generateProofKey(), 'Unset');

        // Null
        $this->configs['oauth']['authorization_code']['pkce'] = null;

        $client = new Client($this->configs);

        $this->assertArrayHasKey('verifier', $client->generateProofKey(), 'Null');

        // False
        $this->configs['oauth']['authorization_code']['pkce'] = false;

        $client = new Client($this->configs);

        $this->assertArrayNotHasKey('verifier', $client->generateProofKey(), 'False');
    }

    /**
     * @test
     */
    public function it_raises_exception_without_an_authorization_server()
    {
        $this->expectException(ClientConfigurationException::class);

        unset($this->configs['oauth']['authorization_server']);

        new Client($this->configs);
    }

    /**
     * @test
     */
    public function it_raises_exception_when_authorization_server_is_not_a_valid_url()
    {
        $this->expectException(ClientConfigurationException::class);

        $this->configs['oauth']['authorization_server'] = 'invalid';

        new Client($this->configs);
    }

    /**
     * @test
     */
    public function it_raises_exception_without_an_resource_server()
    {
        $this->expectException(ClientConfigurationException::class);

        unset($this->configs['resource_server']);

        new Client($this->configs);
    }

    /**
     * @test
     */
    public function it_raises_exception_when_resource_server_is_not_a_valid_url()
    {
        $this->expectException(ClientConfigurationException::class);

        $this->configs['resource_server'] = 'invalid';

        new Client($this->configs);
    }

    /**
     * @test
     */
    public function it_expects_the_guzzle_argument_to_be_a_guzzle_if_provided()
    {
        $this->expectException(TypeError::class);

        new Client(configs: $this->configs, guzzle: '');
    }

    /**
     * @test
     */
    public function it_expects_the_token_argument_to_be_a_token_if_provided()
    {
        $this->expectException(TypeError::class);

        new Client(configs: $this->configs, token: '');
    }

    /**
     * @test
     */
    public function it_allows_setting_the_token_as_a_token()
    {
        $token = new Token(access_token: $access_token = Str::random());

        $client = (new Client($this->configs))
            ->setToken($token);

        $this->assertEquals($access_token, $client->getToken()->access_token);
    }

    /**
     * @test
     */
    public function it_allows_setting_the_token_as_a_string()
    {
        $client = (new Client($this->configs))
            ->setToken($access_token = Str::random());

        $this->assertEquals($access_token, $client->getToken()->access_token);
    }

    /**
     * @test
     */
    public function it_builds_correct_uri()
    {
        $client = new Client($this->configs);

        $this->assertEquals($this->configs['resource_server'].'/', $client->uri(), 'slash on end of URL');
        $this->assertEquals($this->configs['resource_server'].'/resource', $client->uri('resource'), 'simple URI');
        $this->assertEquals($this->configs['resource_server'].'/resource', $client->uri('/resource'), 'no double slash');
        $this->assertEquals($this->configs['resource_server'].'/resource/', $client->uri('resource/'), 'leaves end slash');
        $this->assertEquals(
            $this->configs['resource_server'].'?parameter=value',
            $client->uri('?parameter=value'),
            'query string'
        );
        $this->assertEquals(
            'http://other/url/resource/',
            $client->uri('resource/', 'http://other/url/'),
            'url as second parameter'
        );
    }

    /**
     * @test
     */
    public function it_raises_exception_when_guzzle_error()
    {
        $this->expectException(GuzzleException::class);

        (new Client(
            configs: $this->configs,
            guzzle: new Guzzle([
                'handler' => HandlerStack::create(new MockHandler([
                    new RequestException(
                        'Bad request',
                        new Request('GET', $path = Str::random())
                    ),
                ])),
            ]),
        ))
            ->setToken(Str::random())
            ->request($path);
    }

    /**
     * @test
     */
    public function it_generates_valid_proof_key()
    {
        $pkce = (new Client($this->configs))->generateProofKey();

        $this->assertIsArray($pkce, 'Is Array');
        $this->assertArrayHasKey('challenge', $pkce, 'Key: challenge');
        $this->assertArrayHasKey('verifier', $pkce, 'Key: verifier');

        $this->assertStringNotContainsString('+', $pkce['challenge'], 'No "+" in challenge');
        $this->assertStringNotContainsString('/', $pkce['challenge'], 'No "/" in challenge');
        $this->assertStringNotContainsString('=', $pkce['challenge'], 'No "=" in challenge');

        $this->assertEquals(30, strlen(base64_decode($pkce['verifier'])), '30 characters');
        $this->assertEquals($pkce['verifier'], base64_encode(base64_decode($pkce['verifier'])), 'Encoded verifier');
    }

    /**
     * @test
     */
    public function it_generates_null_proof_key_when_pkce_is_false()
    {
        $this->configs['oauth']['authorization_code']['pkce'] = false;
        $pkce = (new Client($this->configs))->generateProofKey();

        $this->assertIsArray($pkce, 'Is Array');
        $this->assertArrayNotHasKey('challenge', $pkce, 'Key: challenge');
        $this->assertArrayNotHasKey('verifier', $pkce, 'Key: verifier');
    }

    /**
     * @test
     */
    public function it_builds_expected_oauth_uri_with_pkce()
    {
        $challenge = Str::random();

        $this->configs['oauth']['authorization_code']['id'] = $client_id = Str::random();

        $client = new Client($this->configs);

        $this->assertEquals(
            $this->configs['oauth']['authorization_server'].'/authorize?client_id='.$client_id.'&code_challenge_method=S256&code_challenge='.$challenge.'&redirect_uri=http%3A%2F%2Fhost%2Fredirect%2Furi&response_type=code&scope=all',
            $client->oauthUri('http://host/redirect/uri', $challenge)
        );
    }

    /**
     * @test
     */
    public function it_builds_expected_oauth_uri_without_pkce()
    {
        $this->configs['oauth']['authorization_code']['pkce'] = false;
        $this->configs['oauth']['authorization_code']['id'] = $client_id = Str::random();

        $client = new Client($this->configs);

        $this->assertEquals(
            $this->configs['oauth']['authorization_server'].'/authorize?client_id='.$client_id.'&redirect_uri=http%3A%2F%2Fhost%2Fredirect%2Furi&response_type=code&scope=all',
            $client->oauthUri('http://host/redirect/uri')
        );
    }

    /**
     * @test
     */
    public function it_raises_exception_when_building_uri_without_authorization_code_client_id()
    {
        $this->expectException(ClientConfigurationException::class);

        unset($this->configs['oauth']['authorization_code']['id']);

        $client = new Client($this->configs);

        $client->oauthUri(Str::random());
    }

    /**
     * @test
     */
    public function it_raises_exception_when_building_uri_without_challenge_when_pkce_is_true()
    {
        $this->expectException(ClientConfigurationException::class);

        $this->configs['oauth']['authorization_code']['pkce'] = true;
        $this->configs['oauth']['authorization_code']['id'] = Str::random();

        $client = new Client($this->configs);

        $client->oauthUri(uri: Str::random(), challenge: null);
    }

    /**
     * @test
     *
     * @dataProvider tokenProvider
     */
    public function it_knows_if_a_token_is_valid($valid, $token = null, $scope = null)
    {
        $client = new Client($this->configs);

        if (! is_null($token)) {
            $client->setToken(is_callable($token) ? $token() : $token);
        }

        $this->assertEquals($valid, $client->validToken($scope));
    }

    public static function tokenProvider()
    {
        return [
            'new client' => [
                'valid' => false,
                'token' => null,
            ],

            'new token' => [
                'valid' => true,
                'token' => new Token(access_token: Str::random()),
            ],

            'valid with matching scope' => [
                'valid' => true,
                'token' => new Token(access_token: Str::random(), scope: $scope = Str::random()),
                'scope' => $scope,
            ],

            'mismatching scope' => [
                'valid' => false,
                'token' => new Token(access_token: Str::random(), scope: $scope = Str::random()),
                'scope' => Str::random(),
            ],

            'expired' => [
                'valid' => false,
                'token' => function () {
                    Carbon::setTestNow($now = Carbon::now()->subSeconds(2));
                    $token = new Token(access_token: Str::random(), expires_in: 1);
                    Carbon::setTestNow();

                    return $token;
                },
            ],
        ];
    }

    /**
     * @test
     */
    public function it_gets_cached_token_if_existing_token_valid()
    {
        $client = (new Client($this->configs))
            ->setToken($token = new Token(access_token: 'cached'));

        $this->assertEquals($token, $client->getToken());
    }
}
