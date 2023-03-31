<?php

namespace Tests\Unit\Http\Middleware;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Mockery;
use Mockery\Mock;
use Spinen\Halo\Api\Client as Halo;
use Spinen\Halo\Api\Token;
use Spinen\Halo\Http\Middleware\Filter;
use Tests\TestCase;

/**
 * Class FilterTest
 */
class FilterTest extends TestCase
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var Mock
     */
    protected $halo_mock;

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
    protected $response_mock;

    /**
     * @var Mock
     */
    protected $session_mock;

    /**
     * @var Mock
     */
    protected $url_generator_mock;

    /**
     * @var Mock
     */
    protected $user_mock;

    protected function setUp(): void
    {
        $this->halo_mock = Mockery::mock(Halo::class);
        $this->redirector_mock = Mockery::mock(Redirector::class);
        $this->request_mock = Mockery::mock(Request::class);
        $this->response_mock = Mockery::mock(RedirectResponse::class);
        $this->session_mock = Mockery::mock(Session::class);
        $this->url_generator_mock = Mockery::mock(UrlGenerator::class);
        $this->user_mock = Mockery::mock(User::class);

        $this->request_mock->shouldReceive('session')
            ->withNoArgs()
            ->andReturn($this->session_mock);

        $this->request_mock->shouldReceive('user')
            ->withNoArgs()
            ->andReturn($this->user_mock);

        $this->filter = new Filter($this->halo_mock, $this->redirector_mock, $this->url_generator_mock);
    }

    /**
     * @test
     */
    public function it_can_be_constructed()
    {
        $this->assertInstanceOf(Filter::class, $this->filter);
    }

    /**
     * @test
     */
    public function it_calls_next_middleware_if_user_has_a_halo_token()
    {
        $next_middleware = fn ($r) => $this->assertEquals($this->request_mock, $r);

        $this->mockUserAttributeMutators($token = new Token);
        $this->user_mock->halo_token = $token;

        $this->filter->handle($this->request_mock, $next_middleware);
    }

    /**
     * @test
     */
    public function it_does_not_call_next_middleware_if_user_does_not_have_a_halo_token()
    {
        $next_middleware = fn () => $this->fail('The next middleware should not have been called');

        $this->mockUserAttributeMutators();
        $this->user_mock->halo_token = null;

        $this->halo_mock->shouldIgnoreMissing();

        $this->redirector_mock->shouldIgnoreMissing();

        $this->request_mock->shouldIgnoreMissing();

        $this->session_mock->shouldIgnoreMissing();

        $this->url_generator_mock->shouldIgnoreMissing();

        $this->filter->handle($this->request_mock, $next_middleware);
    }

    /**
     * @test
     */
    public function it_sets_intended_url_when_user_does_not_have_a_halo_token()
    {
        $next_middleware = fn () => $this->fail('The next middleware should not have been called');

        $this->mockUserAttributeMutators();
        $this->user_mock->halo_token = null;

        $this->halo_mock->shouldIgnoreMissing();

        $this->url_generator_mock->shouldIgnoreMissing();

        $this->session_mock->shouldIgnoreMissing();

        $this->request_mock->shouldReceive('path')
            ->once()
            ->withNoArgs()
            ->andReturn($path = Str::random());

        $this->redirector_mock->shouldReceive('setIntendedUrl')
            ->once()
            ->with($path)
            ->andReturnNull();

        $this->redirector_mock->shouldIgnoreMissing();

        $this->filter->handle($this->request_mock, $next_middleware);
    }

    /**
     * @test
     */
    public function it_sets_verifier_in_the_session_at_halo_code_verifier()
    {
        $next_middleware = fn () => $this->fail('The next middleware should not have been called');

        $this->mockUserAttributeMutators();
        $this->user_mock->halo_token = null;

        $this->halo_mock->shouldReceive('generateProofKey')
            ->once()
            ->withNoArgs()
            ->andReturn([
                'verifier' => $verifier = Str::random(),
            ]);

        $this->halo_mock->shouldIgnoreMissing();

        $this->url_generator_mock->shouldIgnoreMissing();

        $this->session_mock->shouldReceive('flash')
            ->once()
            ->withArgs([
                'halo_code_verifier',
                $verifier,
            ])
            ->andReturn();

        $this->request_mock->shouldIgnoreMissing();

        $this->redirector_mock->shouldIgnoreMissing();

        $this->filter->handle($this->request_mock, $next_middleware);
    }

    /**
     * @test
     */
    public function it_redirects_user_to_correct_uri_if_it_does_not_have_a_halo_token()
    {
        $next_middleware = fn () => $this->fail('The next middleware should not have been called');

        $this->mockUserAttributeMutators();
        $this->user_mock->halo_token = null;

        $this->request_mock->shouldIgnoreMissing();

        $this->redirector_mock->shouldIgnoreMissing();

        $this->url_generator_mock->shouldReceive('route')
            ->once()
            ->with('halo.sso.redirect_uri')
            ->andReturn($route = Str::random());

        $this->session_mock->shouldIgnoreMissing();

        $this->halo_mock->shouldReceive('generateProofKey')
            ->once()
            ->withNoArgs()
            ->andReturn([
                'challenge' => $challenge = Str::random(),
            ]);

        $this->halo_mock->shouldReceive('oauthUri')
            ->once()
            ->withArgs([
                $route,
                $challenge,
            ])
            ->andReturn($uri = Str::random());

        $this->redirector_mock->shouldReceive('to')
            ->once()
            ->with($uri)
            ->andReturn($this->response_mock);

        $this->filter->handle($this->request_mock, $next_middleware);
    }

    /**
     * Mock out the models setAttribute and getAttribute mutators with the given token
     */
    protected function mockUserAttributeMutators($token = null): void
    {
        $this->user_mock->shouldReceive('setAttribute')
            ->with('halo_token', $token)
            ->once()
            ->andReturn($this->user_mock);

        $this->user_mock->shouldReceive('getAttribute')
            ->with('halo_token')
            ->once()
            ->andReturn($token);
    }
}
