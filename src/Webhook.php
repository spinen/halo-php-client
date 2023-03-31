<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Webhook
 *
 * @property bool $custom_payload
 * @property Collection $events
 * @property Collection $mappings
 * @property int $active
 * @property int $algorithm
 * @property int $authentication_type
 * @property int $certificate_id
 * @property int $inbound_authentication_type
 * @property int $method //TODO: Enum 0 = POST & 1 = GET
 * @property int $runbook_start_type
 * @property int $type
 * @property string $content_type
 * @property string $id
 * @property string $name
 * @property string $systemuse
 * @property string $url
 */
class Webhook extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/webhook';
}
