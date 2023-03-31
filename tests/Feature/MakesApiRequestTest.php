<?php

namespace Tests\Feature;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Str;
use Spinen\Halo\Api\Client;
use Spinen\Halo\Api\Token;
use Tests\TestCase;

/**
 * Class MakesApiRequestTest
 */
class MakesApiRequestTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider requestProvider
     */
    public function it_makes_expected_request_to_api($method, $verb, $response, $data = null)
    {
        $history = [];
        $path = Str::random();

        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(body: json_encode($response)),
        ]));
        $handlerStack->push(Middleware::history($history));

        $client = (new Client(
            configs: $this->configs,
            guzzle: new Guzzle(['handler' => $handlerStack])
        ))
            ->setToken(Str::random());

        $response = is_null($data)
            ? $client->{$method}($path)
            : $client->{$method}($path, $data);

        $this->assertEquals($response, $response, 'Response');

        $this->assertFalse($history[0]['options']['debug'], 'Debug');

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertEquals($this->configs['resource_server'].'/'.$path, (string) $request?->getUri(), 'URI');
        $this->assertEquals($verb, $request?->getMethod(), 'Verb');
        $this->assertEquals((string) $client->getToken(), $request?->getHeader('Authorization')[0], 'Authorization');
        $this->assertEquals('application/json', $request?->getHeader('Content-Type')[0], 'Content-Type');
        $this->assertEquals(empty($data) ? null : json_encode($data), $request?->getBody()?->getContents(), 'Body');
    }

    public static function requestProvider()
    {
        return [
            'raw request' => [
                'method' => 'request',
                'verb' => 'GET',
                'response' => [Str::random()],
            ],
            'delete' => [
                'method' => 'delete',
                'verb' => 'DELETE',
                'response' => [Str::random()],
            ],
            'get' => [
                'method' => 'get',
                'verb' => 'GET',
                'response' => [Str::random()],
            ],
            'post' => [
                'method' => 'post',
                'verb' => 'POST',
                'response' => [Str::random()],
                'data' => [Str::random(8) => Str::random()],
            ],
            'put' => [
                'method' => 'put',
                'verb' => 'PUT',
                'response' => [Str::random()],
                'data' => [Str::random(8) => Str::random()],
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider responseProvider
     */
    public function it_returns_expected_responses($json, $expected)
    {
        $client = (new Client(
            configs: $this->configs,
            guzzle: new Guzzle([
                'handler' => HandlerStack::create(new MockHandler([
                    new Response(body: $json),
                ])),
            ])
        ))
            ->setToken(Str::random());

        $this->assertEquals(
            $expected,
            $client->setToken(new Token(access_token: Str::random()))
                ->request(Str::random())
        );
    }

    public static function responseProvider()
    {
        return [
            'null' => [
                'json' => 'null',
                'expected' => null,
            ],
            'empty_object' => [
                'json' => '{}',
                'expected' => [],
            ],
            'empty_array' => [
                'json' => '[]',
                'expected' => [],
            ],
            'object' => [
                'json' => '{"some": "key"}',
                'expected' => [
                    'some' => 'key',
                ],
            ],
            'array' => [
                'json' => '[{"some": 1}, {"some": 2}]',
                'expected' => [
                    [
                        'some' => 1,
                    ],
                    [
                        'some' => 2,
                    ],
                ],
            ],
        ];
    }
}
