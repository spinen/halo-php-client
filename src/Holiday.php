<?php

namespace Spinen\Halo;

use Carbon\Carbon;
use Spinen\Halo\Support\Model;

/**
 * Class Holiday
 *
 * @property bool $allday
 * @property bool $isrecurring
 * @property Carbon $date
 * @property Carbon $end_date
 * @property float $duration
 * @property int $agent_id
 * @property int $entity
 * @property int $holid
 * @property int $holiday_type
 * @property int $workday_id
 * @property string $agent_name
 * @property string $id
 * @property string $name
 */
class Holiday extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'agent_id' => 'int',
        'agent_name' => 'string',
        'allday' => 'bool',
        'date' => 'datetime',
        'duration' => 'float',
        'end_date' => 'datetime',
        'entity' => 'int',
        'holid' => 'int',
        'holiday_type' => 'int',
        'id' => 'string',
        'isrecurring' => 'bool',
        'workday_id' => 'int',
    ];

    /**
     * Is the model readonly?
     */
    protected bool $readonlyModel = true;
}
