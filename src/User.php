<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class User
 *
 * @property bool $inactive
 * @property bool $isimportantcontact
 * @property bool $isimportantcontact2
 * @property bool $isserviceaccount
 * @property bool $neversendemails
 * @property int $autotaskid
 * @property int $client_id
 * @property int $connectwiseid
 * @property int $id
 * @property int $linked_agent_id
 * @property int $priority_id
 * @property int $site_id
 * @property int $telpref
 * @property string $client_name
 * @property string $colour
 * @property string $firstname
 * @property string $initials
 * @property string $name
 * @property string $site_name
 * @property string $sitephonenumber
 * @property string $surname
 * @property string $use
 */
class User extends Model
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
    protected string $path = '/users';
}
