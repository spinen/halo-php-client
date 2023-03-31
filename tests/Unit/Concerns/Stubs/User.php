<?php

namespace Tests\Unit\Concerns\Stubs;

use Spinen\Halo\Concerns\HasHalo;

class User
{
    use HasHalo;

    public $attributes = [
        'halo_token' => 'encrypted',
    ];

    public $fillable = [];

    public $hidden = [];

    /**
     * @var string
     */
    protected $halo_token = 'pk_token';

    public function getBuilder()
    {
        return $this->builder;
    }
}
