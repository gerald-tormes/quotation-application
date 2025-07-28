<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait FilterableAndSortable
{
    /**
     * Retrieve filterable and sortable items with pagination.
     *
     * @param array $filters
     * @param array $sorting
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getFilterableAndSortable(array $filters, array $sorting, int $perPage): LengthAwarePaginator
    {
         $query = $this->buildQuery($filters);

        return $query->orderBy($sorting['field'], $sorting['direction'])
            ->paginate($perPage)
            ->withQueryString()
            ->appends([
                'sortField' => $sorting['field'],
                'sortDirection' => $sorting['direction'],
            ]);
    }

    /**
     * Build the query based on the provided filters.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract protected function buildQuery(array $filters): Builder;
}
