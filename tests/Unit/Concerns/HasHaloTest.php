<?php

namespace Tests\Unit\Concerns;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Crypt;
use Mockery;
use Mockery\Mock;
use ReflectionClass;
use Spinen\Halo\Api\Client as Halo;
use Spinen\Halo\Api\Token;
use Spinen\Halo\Concerns\HasHalo;
use Spinen\Halo\Support\Builder;
use Tests\TestCase;
use Tests\Unit\Concerns\Stubs\User;

class HasHaloTest extends TestCase
{
    /**
     * @var Mock
     */
    protected $builder_mock;

    /**
     * @var Mock
     */
    protected $client_mock;

    /**
     * @var Mock
     */
    protected $encrypter_mock;

    /**
     * @var User
     */
    protected $trait;

    protected function setUp(): void
    {
        $this->trait = new User();

        $this->client_mock = Mockery::mock(Halo::class);
        $this->client_mock->shouldReceive('setToken')
            ->withArgs(
                [
                    Mockery::any(),
                ]
            )
            ->andReturnSelf();

        $this->builder_mock = Mockery::mock(Builder::class);
        $this->builder_mock->shouldReceive('getClient')
            ->withNoArgs()
            ->andReturn($this->client_mock);
        $this->builder_mock->shouldReceive('setClient')
            ->withArgs(
                [
                    $this->client_mock,
                ]
            )
            ->andReturnSelf();

        Container::getInstance()
            ->instance(Builder::class, $this->builder_mock);

        Container::getInstance()
            ->instance(Halo::class, $this->client_mock);
    }

    /**
     * @test
     */
    public function it_can_be_used()
    {
        $this->assertArrayHasKey(HasHalo::class, (new ReflectionClass($this->trait))->getTraits());
    }

    /**
     * @test
     */
    public function it_returns_a_builder_for_HALO_method()
    {
        $this->assertInstanceOf(Builder::class, $this->trait->halo());
    }

    /**
     * @test
     */
    public function it_caches_the_builder()
    {
        $this->assertNull($this->trait->getBuilder(), 'baseline');

        $this->trait->halo();

        $this->assertInstanceOf(Builder::class, $this->trait->getBuilder());
    }

    /**
     * @test
     */
    public function it_initializes_the_trait_as_expected()
    {
        $this->assertEmpty($this->trait->fillable, 'Baseline fillable');
        $this->assertEmpty($this->trait->hidden, 'Baseline hidden');

        $this->trait->initializeHasHalo();

        $this->assertContains('halo_token', $this->trait->fillable, 'Fillable with halo_token');
        $this->assertContains('halo', $this->trait->hidden, 'Hide Halo');
        $this->assertContains('halo_token', $this->trait->hidden, 'Hide halo_token');
    }

    /**
     * @test
     */
    public function it_has_an_accessor_to_get_the_client()
    {
        $this->assertInstanceOf(Halo::class, $this->trait->getHaloAttribute());
    }

    /**
     * @test
     */
    public function it_has_an_accessor_to_decrypt_halo_token()
    {
        Crypt::shouldReceive('decryptString')
            ->once()
            ->with($this->trait->attributes['halo_token'])
            ->andReturn(serialize(new Token(access_token: 'decrypted')));

        ($this->trait->haloToken()->get)(value: null, attributes: ['halo_token' => $this->trait->attributes['halo_token']]);
    }

    /**
     * @test
     */
    public function it_does_not_try_to_decrypt_null_halo_token()
    {
        $this->trait->attributes['halo_token'] = null;

        Crypt::shouldReceive('decryptString')
            ->never()
            ->withAnyArgs();

        $this->assertNull(($this->trait->haloToken()->get)(value: null, attributes: ['halo_token' => $this->trait->attributes['halo_token']]));
    }

    /**
     * @test
     */
    public function it_has_mutator_to_encrypt_halo_token()
    {
        Crypt::shouldReceive('encryptString')
            ->once()
            ->with(serialize('unencrypted'))
            ->andReturn();

        ($this->trait->haloToken()->set)('unencrypted');

        $this->assertEquals('encrypted', $this->trait->attributes['halo_token']);
    }

    /**
     * @test
     */
    public function it_does_not_mutate_a_null_halo_token()
    {
        Crypt::shouldReceive('encryptString')
            ->never()
            ->withAnyArgs();

        $this->assertNull(($this->trait->haloToken()->set)(null));
    }

    /**
     * @test
     */
    public function it_invalidates_builder_cache_when_setting_halo_token()
    {
        Crypt::shouldReceive('encryptString')
            ->withAnyArgs();

        // Force cache
        $this->trait->halo();

        $this->assertNotNull($this->trait->getBuilder(), 'Baseline that cache exist');

        ($this->trait->haloToken()->set)('changed');

        $this->assertNull($this->trait->getBuilder(), 'Cache was invalidated');
    }
}
