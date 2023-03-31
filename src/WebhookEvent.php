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

    // TODO: This is wrapped up under "events"
    // "record_count" => 5,
    // "events" => [  here  ]

    /**
     * Path to API endpoint.
     */
    protected string $path = '/webhookevent';
}
