<?php

namespace Spinen\Halo\Support\Relations;

use GuzzleHttp\Exception\GuzzleException;
use Spinen\Halo\Exceptions\InvalidRelationshipException;
use Spinen\Halo\Exceptions\NoClientException;
use Spinen\Halo\Exceptions\TokenException;
use Spinen\Halo\Support\Collection;

/**
 * Class HasMany
 */
class HasMany extends Relation
{
    /**
     * Get the results of the relationship.
     *
     * @throws GuzzleException
     * @throws InvalidRelationshipException
     * @throws NoClientException
     * @throws TokenException
     */
    public function getResults(): Collection
    {
        return $this->getBuilder()
                    ->get();
    }
}
