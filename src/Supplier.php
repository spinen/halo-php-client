<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Supplier
 *
 * @property bool $inactive
 * @property int $emailtemplate_id
 * @property int $id
 * @property int $toplevel_id
 * @property string $contact_name
 * @property string $email_address
 * @property string $logo
 * @property string $name
 * @property string $phone_number
 * @property string $thirdpartynhdapiurl
 * @property string $toplevel_name
 * @property string $use
 */
class Supplier extends Model
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
    protected string $path = '/supplier';
}
