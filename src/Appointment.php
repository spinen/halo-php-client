<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Appointment
 *
 * @property
 */
class Appointment extends Model
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
    protected string $path = '/appointment';
}
