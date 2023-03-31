<?php

namespace Spinen\Halo\Support\Relations;

use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use Spinen\Halo\Exceptions\InvalidRelationshipException;
use Spinen\Halo\Support\Builder;
use Spinen\Halo\Support\Model;

/**
 * Class Relation
 */
abstract class Relation
{
    use ForwardsCalls, Macroable {
        __call as macroCall;
    }

    /**
     * The related model instance.
     */
    protected Model $related;

    /**
     * Create a new relation instance.
     *
     *
     * @return void
     *
     * @throws InvalidRelationshipException
     */
    public function __construct(protected Builder $builder, protected Model $parent)
    {
        $this->related = $builder->getModel();
    }

    /**
     * Handle dynamic method calls to the relationship.
     */
    public function __call(string $method, array $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        $result = $this->forwardCallTo($this->getBuilder(), $method, $parameters);

        if ($result === $this->getBuilder()) {
            return $this;
        }

        return $result;
    }

    /**
     * Get the Builder instance
     */
    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    /**
     * Get the parent Model instance
     */
    public function getParent(): Model
    {
        return $this->parent;
    }

    /**
     * Get the related Model instance
     */
    public function getRelated(): Model
    {
        return $this->related;
    }

    /**
     * Get the results of the relationship.
     */
    abstract public function getResults();
}
