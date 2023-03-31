<?php

namespace Tests\Unit\Api;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Spinen\Halo\Api\Token;
use Tests\TestCase;

/**
 * Class TokenTest
 */
class TokenTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_constructed()
    {
        $this->assertInstanceOf(Token::class, new Token);
    }

    /**
     * @test
     */
    public function it_has_expected_defaults()
    {
        Carbon::setTestNow(Carbon::now());

        $token = new Token;

        $this->assertNull($token->access_token, 'access_token');
        $this->assertEquals(3600, $token->expires_at->diffInSeconds(), 'expires_in');
        $this->assertNull($token->id_token, 'id_token');
        $this->assertNull($token->refresh_token, 'refresh_token');
        $this->assertEquals('all', $token->scope, 'scope');
        $this->assertEquals('Bearer', $token->token_type, 'token_type');
        $this->assertNull($token->grant_type, 'grant_type');

        Carbon::setTestNow();
    }

    /**
     * @test
     */
    public function its_string_format_is_what_is_needed_for_authentication()
    {
        $token = new Token(
            access_token: $access_token = Str::random(),
            token_type: $token_type = Str::random(),
        );

        $this->assertEquals("{$token_type} {$access_token}", (string)$token);
    }

    /**
     * @test
     */
    public function it_knows_if_a_scope_is_allowed()
    {
        $scopes = [
            Str::random(),
            Str::random(),
            Str::random(),
            Str::random(),
            Str::random(),
        ];

        $token = new Token(scope: implode(" ", $scopes));

        foreach($scopes as $key => $scope) {
            $this->assertTrue($token->allowedScope($scope), "Token #{$key}");
        }

        $this->assertFalse($token->allowedScope(Str::random()));
    }

    /**
     * @test
     *
     * @dataProvider tokenExpireStates
     */
    public function it_uses_expires_in_to_control_several_states($token, $seconds, $expired, $valid, $refreshing, $for)
    {
        Carbon::setTestNow($now = Carbon::now());

        $token = new Token(...$token);

        Carbon::setTestNow($now->addSeconds($seconds));

        $this->assertEquals($expired, $token->isExpired(), 'isExpired');
        $this->assertEquals($valid, $token->isValid(), 'isValid');
        $this->assertEquals($refreshing, $token->needsRefreshing(), 'needsRefreshing');
        $this->assertEquals($for, $token->validFor(), 'validFor');
    }

    public static function tokenExpireStates()
    {
        return [
            'default' => [
                'token' => [],
                'seconds' => 0,
                'expired' => false,
                'valid' => false,
                'refreshing' => false,
                'for' => 0,
            ],
            'access_token' => [
                'token' => ['access_token' => Str::random()],
                'seconds' => 0,
                'expired' => false,
                'valid' => true,
                'refreshing' => false,
                'for' => 3600,
            ],
            'refresh_token' => [
                'token' => [
                    'access_token' => Str::random(),
                    'refresh_token' => Str::random(),
                ],
                'seconds' => 0,
                'expired' => false,
                'valid' => true,
                'refreshing' => false,
                'for' => 3600,
            ],
            'at expires' => [
                'token' => [
                    'access_token' => Str::random(),
                    'refresh_token' => Str::random(),
                ],
                'seconds' => 3600,
                'expired' => true,
                'valid' => false,
                'refreshing' => true,
                'for' => 0,
            ],
            'one second before expires' => [
                'token' => [
                    'access_token' => Str::random(),
                    'refresh_token' => Str::random(),
                ],
                'seconds' => 3599,
                'expired' => true,
                'valid' => false,
                'refreshing' => true,
                'for' => 1,
            ],
            'one second after expires' => [
                'token' => [
                    'access_token' => Str::random(),
                    'refresh_token' => Str::random(),
                ],
                'seconds' => 3601,
                'expired' => true,
                'valid' => false,
                'refreshing' => true,
                'for' => 0,
            ],
            'at buffer' => [
                'token' => [
                    'access_token' => Str::random(),
                    'refresh_token' => Str::random(),
                ],
                'seconds' => 3595,
                'expired' => true,
                'valid' => false,
                'refreshing' => true,
                'for' => 5,
            ],
            'one sec before buffer' => [
                'token' => [
                    'access_token' => Str::random(),
                    'refresh_token' => Str::random(),
                ],
                'seconds' => 3594,
                'expired' => false,
                'valid' => true,
                'refreshing' => false,
                'for' => 6,
            ],
        ];
    }
}
