<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Report
 *
 * @property bool $_canupdate
 * @property bool $canbeaccessedbyallusers
 * @property bool $restrictaccess
 * @property int $datasource_id
 * @property int $group_id
 * @property int $id
 * @property int $systemreportid
 * @property int $type
 * @property string $description
 * @property string $group_name
 * @property string $mainentity
 * @property string $name
 */
class Report extends Model
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
    protected string $path = '/report';
}
