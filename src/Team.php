<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Team
 *
 * @property bool $foropps
 * @property bool $forprojects
 * @property bool $forrequests
 * @property bool $inactive
 * @property int $department_id
 * @property int $id
 * @property int $override_column_id
 * @property int $sequence
 * @property int $ticket_count
 * @property string $department_name
 * @property string $guid
 * @property string $name
 * @property string $teamphotopath
 * @property string $use
 */
class Team extends Model
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
    protected string $path = '/team';
}
