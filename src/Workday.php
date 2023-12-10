<?php

namespace Spinen\Halo;

use Carbon\Carbon;
use Spinen\Halo\Support\Model;

/**
 * Class Workday
 *
 * @property array $access_control
 * @property array $holidays
 * @property array $timeslots
 * @property bool $alldayssame
 * @property bool $incfriday
 * @property bool $incmonday
 * @property bool $incsaturday
 * @property bool $incsunday
 * @property bool $incthursday
 * @property bool $inctuesday
 * @property bool $incwednesday
 * @property Carbon $end
 * @property Carbon $endfriday
 * @property Carbon $endmonday
 * @property Carbon $endsaturday
 * @property Carbon $endsunday
 * @property Carbon $endthursday
 * @property Carbon $endtuesday
 * @property Carbon $endwednesday
 * @property Carbon $start
 * @property Carbon $startfriday
 * @property Carbon $startmonday
 * @property Carbon $startsaturday
 * @property Carbon $startsunday
 * @property Carbon $startthursday
 * @property Carbon $starttuesday
 * @property Carbon $startwednesday
 * @property int $access_control_level
 * @property int $id
 * @property string $guid
 * @property string $name
 * @property string $summary
 * @property string $timezone
 */
class Workday extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'access_control_level' => 'int',
        'alldayssame' => 'bool',
        'end' => 'datetime',
        'endfriday' => 'datetime',
        'endmonday' => 'datetime',
        'endsaturday' => 'datetime',
        'endsunday' => 'datetime',
        'endthursday' => 'datetime',
        'endtuesday' => 'datetime',
        'endwednesday' => 'datetime',
        'id' => 'int',
        'incfriday' => 'bool',
        'incmonday' => 'bool',
        'incsaturday' => 'bool',
        'incsunday' => 'bool',
        'incthursday' => 'bool',
        'inctuesday' => 'bool',
        'incwednesday' => 'bool',
        'start' => 'datetime',
        'startfriday' => 'datetime',
        'startmonday' => 'datetime',
        'startsaturday' => 'datetime',
        'startsunday' => 'datetime',
        'startthursday' => 'datetime',
        'starttuesday' => 'datetime',
        'startwednesday' => 'datetime',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/workday';
}
