<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Sla
 *
 * @property array $access_control
 * @property array $priorities
 * @property bool $autoreleaseoption
 * @property bool $dontsendholdreminders
 * @property bool $hoursaretechslocaltime
 * @property bool $response_reset_approval
 * @property bool $responsereset
 * @property bool $trackslafixbytime
 * @property bool $trackslaresponsetime
 * @property int $access_control_level
 * @property int $autoreleaselimit
 * @property int $id
 * @property int $slstatusafterfirstwarning
 * @property int $slstatusaftersecondwarning
 * @property int $statusafterautorelease
 * @property int $workday_id
 * @property string $guid
 * @property string $name
 * @property string $statusafterautorelease_name
 * @property string $workday_name
 */
class Sla extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'access_control_level' => 'int',
        'autoreleaselimit' => 'int',
        'autoreleaseoption' => 'bool',
        'dontsendholdreminders' => 'bool',
        'hoursaretechslocaltime' => 'bool',
        'id' => 'int',
        'response_reset_approval' => 'bool',
        'responsereset' => 'bool',
        'slstatusafterfirstwarning' => 'int',
        'slstatusaftersecondwarning' => 'int',
        'statusafterautorelease' => 'int',
        'trackslafixbytime' => 'bool',
        'trackslaresponsetime' => 'bool',
        'workday_id' => 'int',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/sla';
}
