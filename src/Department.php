<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Department
 *
 * @property array $managers
 * @property int $accounts_override_mailbox
 * @property int $id
 * @property int $organisation_id
 * @property int $type
 * @property string $guid
 * @property string $long_name
 * @property string $name
 * @property string $organisation_name
 */
class Department extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'accounts_override_mailbox' => 'int',
        'id' => 'int',
        'organisation_id' => 'int',
        'type' => 'int',
    ];

    /**
     * Is the model readonly?
     */
    protected bool $readonlyModel = true;
}
