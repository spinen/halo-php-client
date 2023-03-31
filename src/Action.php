<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Action
 *
 * @property
 */
class Action extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'datecreated' => 'datetime:Uv',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/actions';
}
