<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class WebhookEvent
 */
class WebhookEvent extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Some of the responses have the data under a property
     */
    protected ?string $responseKey = 'events';

    /**
     * Path to API endpoint.
     */
    protected string $path = '/webhookevent';
}
