<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Status
 *
 * @property bool $showonquickchange
 * @property int $id
 * @property int $sequence
 * @property int $type
 * @property string $colour
 * @property string $guid
 * @property string $name
 * @property string $shortname
 * @property string $slaaction
 */
class Status extends Model
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
    protected string $path = '/status';
}
