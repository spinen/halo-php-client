<?php

namespace Tests\Unit\Support\Stubs;

use Spinen\Halo\Exceptions\InvalidRelationshipException;
use Spinen\Halo\Exceptions\ModelNotFoundException;
use Spinen\Halo\Exceptions\NoClientException;
use Spinen\Halo\Support\Model as BaseModel;
use Spinen\Halo\Support\Relations\HasMany;
use stdClass;

class Model extends BaseModel
{
    /**
     * Path to API endpoint.
     */
    protected string $path = 'some/path';

    /**
     * Mutator for Mutator.
     */
    public function setMutatorAttribute($value)
    {
        $this->attributes['mutator'] = 'mutated: '.$value;
    }

    public function setResponseCollectionKey($key)
    {
        $this->responseCollectionKey = $key;
    }

    public function setResponseKey($key)
    {
        $this->responseKey = $key;
    }

    /**
     * Allow swapping nested for test
     */
    public function setNested($nested): Model
    {
        $this->nested = $nested;

        return $this;
    }

    /**
     * @throws InvalidRelationshipException
     * @throws ModelNotFoundException
     * @throws NoClientException
     */
    public function related(): HasMany
    {
        return $this->hasMany(Model::class);
    }

    public function nonrelation()
    {
        return new stdClass();
    }

    public function nullrelation()
    {
        return null;
    }
}
