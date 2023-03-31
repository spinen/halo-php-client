<?php

namespace Spinen\Halo\Support\Relations;

use Spinen\Halo\Support\Model;

/**
 * Class ChildOf
 */
class ChildOf extends BelongsTo
{
    /**
     * Get the results of the relationship.
     */
    public function getResults(): Model
    {
        // TODO: May need to deal with null relatedModel?
        return $this->getChild();
    }
}
