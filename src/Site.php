<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Site
 *
 * @property bool $inactive
 * @property bool $invoice_address_isdelivery
 * @property bool $isstocklocation
 * @property float $client_id
 * @property int $id
 * @property int $messagegroup_id
 * @property int $sla_id
 * @property string $client_name
 * @property string $clientsite_name
 * @property string $colour
 * @property string $itglue_id
 * @property string $name
 * @property string $phonenumber
 * @property string $timezone
 * @property string $use
 */
class Site extends Model
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
    protected string $path = '/site';
}
