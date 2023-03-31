<?php

namespace Spinen\Halo\Concerns;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Crypt;
use Spinen\Halo\Api\Client as Halo;
use Spinen\Halo\Api\Token;
use Spinen\Halo\Exceptions\NoClientException;
use Spinen\Halo\Support\Builder;

/**
 * Trait HasHalo
 *
 * @property Halo $halo
 * @property string $halo_token
 */
trait HasHalo
{
    /**
     * Halo Builder instance
     */
    protected ?Builder $builder = null;

    /**
     * Return cached version of the Halo Builder for the user
     *
     * @throws BindingResolutionException
     */
    public function halo(): Builder
    {
        // TODO: Need to deal with null halo_token
        if (is_null($this->builder)) {
            $this->builder = Container::getInstance()
                ->make(Builder::class)
                ->setClient(
                    Container::getInstance()
                        ->make(Halo::class)
                        ->setToken($this->halo_token)
                );
        }

        return $this->builder;
    }

    /**
     * Accessor for Halo Client.
     *
     * @throws BindingResolutionException
     * @throws NoClientException
     */
    public function getHaloAttribute(): Halo
    {
        return $this->halo()
            ->getClient();
    }

    /**
     * Accessor/Mutator for haloToken.
     */
    public function haloToken(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes): ?Token => ! is_null($attributes['halo_token'])
              ? unserialize(Crypt::decryptString($attributes['halo_token']))
              : null,
            set: function ($value): ?string {
                // If setting the password & already have a client, then
                // empty the client to use new password in client
                if (! is_null($this->builder)) {
                    $this->builder = null;
                }

                return is_null($value)
                    ? null
                    : Crypt::encryptString(serialize($value));
            },
        );
    }

    /**
     * Make sure that the halo_token is fillable & protected
     */
    public function initializeHasHalo(): void
    {
        $this->fillable[] = 'halo_token';
        $this->hidden[] = 'halo';
        $this->hidden[] = 'halo_token';
    }
}
