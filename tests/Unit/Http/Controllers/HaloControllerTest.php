<?php

namespace Tests\Unit\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Mockery;
use Mockery\Mock;
use Spinen\Halo\Api\Client as Halo;
use Spinen\Halo\Api\Token;
use Spinen\Halo\Http\Controllers\HaloController;
use Tests\TestCase;

class HaloControllerTest extends TestCase
{
    /**
     * @var Mock
     */
    protected $halo_mock;

    /**
     * @var HaloController
     */
    protected $controller;

    /**
     * @var Mock
     */
    protected $redirect_mock;

    /**
     * @var Mock
     */
    protected $redirector_mock;

    /**
     * @var Mock
     */
    protected $request_mock;

    /**
     * @var Mock
     */
    protected $session_mock;

    /**
     * @var Mock
     */
    protected $user_mock;

    protected function setUp(): void
    {
        $this->halo_mock = Mockery::mock(Halo::class);

        $this->redirect_mock = Mockery::mock(RedirectResponse::class);

        $this->redirector_mock = Mockery::mock(Redirector::class);

        $this->redirector_mock->shouldReceive('intended')
            ->withNoArgs()
            ->andReturn($this->redirect_mock);

        $this->user_mock = Mockery::mock(User::class);

        $this->session_mock = Mockery::mock(Session::class);

        $this->request_mock = Mockery::mock(Request::class);

        $this->request_mock->shouldReceive('session')
            ->withNoArgs()
            ->andReturn($this->session_mock);

        $this->request_mock->shouldReceive('user')
            ->withNoArgs()
            ->andReturn($this->user_mock);

        $this->controller = new HaloController();
    }

    /**
     * @test
     */
    public function it_can_be_constructed()
    {
        $this->assertInstanceOf(HaloController::class, $this->controller);
    }

    /**
     * @test
     */
    public function it_has_the_client_convert_code_to_token()
    {
        $this->request_mock->shouldReceive('get')
            ->once()
            ->with('code')
            ->andReturn($code = Str::random());

        $this->request_mock->shouldReceive('url')
            ->once()
            ->withNoArgs()
            ->andReturn($url = Str::random());

        $this->session_mock->shouldReceive('get')
            ->once()
            ->with('halo_code_verifier')
            ->andReturn($verifier = Str::random());

        $this->halo_mock->shouldReceive('oauthRequestTokenUsingAuthorizationCode')
            ->once()
            ->withArgs(
                [
                    $code,
                    $url,
                    $verifier,
                ]
            )
            ->andReturn(new Token);

        $this->user_mock->shouldIgnoreMissing();

        ($this->controller)(
            $this->halo_mock,
            $this->redirector_mock,
            $this->request_mock,
        );
    }

    /**
     * @test
     */
    public function it_saves_the_users_halo_token_to_the_oauth_token()
    {
        $this->request_mock->shouldReceive('get')
            ->once()
            ->with('code')
            ->andReturn(Str::random());

        $this->request_mock->shouldReceive('url')
            ->once()
            ->withNoArgs()
            ->andReturn(Str::random());

        $this->session_mock->shouldReceive('get')
            ->once()
            ->with('halo_code_verifier')
            ->andReturn(Str::random());

        $this->halo_mock->shouldReceive('oauthRequestTokenUsingAuthorizationCode')
            ->once()
            ->withAnyArgs()
            ->andReturn($token = new Token);

        $this->user_mock->shouldReceive('save')
            ->once()
            ->withNoArgs()
            ->andReturnTrue();

        $this->user_mock->shouldReceive('setAttribute')
            ->with('halo_token', $token)
            ->once()
            ->andReturn($this->user_mock);

        $this->user_mock->shouldReceive('getAttribute')
            ->with('halo_token')
            ->once()
            ->andReturn($token);

        ($this->controller)(
            $this->halo_mock,
            $this->redirector_mock,
            $this->request_mock,
        );

        $this->assertEquals($token, $this->user_mock->halo_token);
    }

    /**
     * @test
     */
    public function it_redirects_the_user_to_the_intended_route()
    {
        $this->session_mock->shouldReceive('get')
            ->once()
            ->with('halo_code_verifier')
            ->andReturn(Str::random());

        $this->request_mock->shouldReceive('url')
            ->once()
            ->withNoArgs()
            ->andReturn(Str::random());

        $this->request_mock->shouldIgnoreMissing();

        $this->halo_mock->shouldIgnoreMissing();

        $this->user_mock->shouldIgnoreMissing();

        $response = ($this->controller)(
            $this->halo_mock,
            $this->redirector_mock,
            $this->request_mock,
        );

        $this->assertEquals($this->redirect_mock, $response);
    }
}
