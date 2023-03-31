<?php

namespace Spinen\Halo\Support\Relations;

use GuzzleHttp\Exception\GuzzleException;
use Spinen\Halo\Exceptions\InvalidRelationshipException;
use Spinen\Halo\Exceptions\NoClientException;
use Spinen\Halo\Exceptions\TokenException;
use Spinen\Halo\Support\Builder;
use Spinen\Halo\Support\Model;

/**
 * Class BelongsTo
 */
class BelongsTo extends Relation
{
    /**
     * Create a new belongs to relationship instance.
     *
     * @return void
     *
     * @throws InvalidRelationshipException
     */
    public function __construct(protected Builder $builder, protected Model $child, protected $foreignKey)
    {
        // In the underlying base relationship class, the "child" variable is
        // referred to as the "parentModel" since most relationships are not
        // inversed. But, since this one is we will create a "child" variable
        // for much better readability.

        parent::__construct($builder->whereId($this->getForeignKey()), $this->getChild());
    }

    /**
     * Get the child Model
     */
    public function getChild(): Model
    {
        return $this->child;
    }

    /**
     * Get the foreign key's name
     */
    public function getForeignKey(): int|string|null
    {
        return $this->getChild()->{$this->getForeignKeyName()};
    }

    /**
     * Get the name of the foreign key's name
     */
    public function getForeignKeyName(): string
    {
        return $this->foreignKey;
    }

    /**
     * Get the results of the relationship.
     *
     * @throws GuzzleException
     * @throws InvalidRelationshipException
     * @throws NoClientException
     * @throws TokenException
     */
    public function getResults(): ?Model
    {
        if (! $this->getForeignKey()) {
            return null;
        }

        return $this->getBuilder()
                    ->get()
                    ->first();
    }
}
