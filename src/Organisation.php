<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Organisation
 *
 * @property array $address
 * @property array $allowed_tickettypes
 * @property array $customfields
 * @property array $departments
 * @property array $faqlists
 * @property bool $allowall_tickettypes
 * @property int $deliverysite
 * @property int $id
 * @property int $linked_client_id
 * @property int $messagegroup_id
 * @property string $email
 * @property string $fax
 * @property string $guid
 * @property string $logo
 * @property string $name
 * @property string $phone
 * @property string $portal_logo
 * @property string $portalbackgroundimageurl
 * @property string $portalcolour
 * @property string $portalurl
 * @property string $reply_address
 * @property string $website
 */
class Organisation extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'allowall_tickettypes' => 'bool',
        'deliverysite' => 'int',
        'id' => 'int',
        'linked_client_id' => 'int',
        'messagegroup_id' => 'int',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/organisation';
}
