<?php

namespace Tests\Unit\Concerns\Stubs;

use Mockery;
use Mockery\Mock;
use Spinen\Halo\Api\Client as Halo;
use Spinen\Halo\Concerns\HasClient;

class ItemNeedingClient
{
    use HasClient;

    /**
     * @var Mock
     */
    public $parent_client_mock;

    /**
     * @var Mock
     */
    protected $parentModel;

    public function __construct()
    {
        $this->parent_client_mock = Mockery::mock(Halo::class);

        $this->parentModel = Mockery::mock(Halo::class);
        $this->parentModel->shouldReceive('getClient')
            ->andReturn($this->parent_client_mock);
    }

    public function unsetParentModel()
    {
        $this->parentModel = null;

        $this->parent_client_mock = null;

        return $this;
    }
}
