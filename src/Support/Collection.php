<?php

namespace Spinen\Halo\Support;

use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    /**
     *
     * @var array
     */
    protected array $pagination = [];

    /**
     * Current page that the collection holds
     */
    public function page(): ?int
    {
        return $this->pagination['page'] ?? null;
    }

    /**
     * Number of avaliable pages
     */
    public function pages(): ?int
    {
        return ceil($this->recordCount() / $this->pageSize());
    }

    /**
     * Records per page
     */
    public function pageSize(): ?int
    {
        return $this->pagination['pageSize'] ?? null;
    }

    /**
     * Count of records avaliable in the the
     */
    public function recordCount(): ?int
    {
        return $this->pagination['count'] ?? null;
    }

    /**
     * Set pagination
     */
    public function setPagination(?int $count = null, ?int $page = null, ?int $pageSize = null): self
    {
        $this->pagination = array_merge($this->pagination, compact('count', 'page', 'pageSize'));

        return $this;
    }
}
