<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Priority
 *
 * @property bool $enterslaexcuse
 * @property bool $fixendofday
 * @property bool $ishidden
 * @property bool $responseendofday
 * @property bool $responsestartofday
 * @property bool $setfixtostartdate
 * @property bool $setfixtotargetdate
 * @property bool $startofday
 * @property float $fixtime
 * @property float $responsetime
 * @property int $priorityid
 * @property int $slaid
 * @property int $workdaysoverride
 * @property string $colour
 * @property string $fixunits
 * @property string $id
 * @property string $name
 * @property string $responsestartofdaytime
 * @property string $responseunits
 * @property string $startofdaytime
 */
class Priority extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'enterslaexcuse' => 'bool',
        'fixendofday' => 'bool',
        'fixtime' => 'float',
        'ishidden' => 'bool',
        'priorityid' => 'int',
        'responseendofday' => 'bool',
        'responsestartofday' => 'bool',
        'responsetime' => 'float',
        'setfixtostartdate' => 'bool',
        'setfixtotargetdate' => 'bool',
        'slaid' => 'int',
        'startofday' => 'bool',
        'workdaysoverride' => 'int',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/priority';
}
