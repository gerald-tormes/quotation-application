<?php

namespace App\Services;

use App\Models\Item;
use App\Traits\FilterableAndSortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ItemService
{
    // This service can be used to encapsulate business logic related to items.
    // For example, methods for creating, updating, deleting, or retrieving items
    // can be added here to keep the controller clean and focused on request handling.

     use FilterableAndSortable;

     private function buildQuery(array $filters): Builder
     {
         return Item::query()
         ->when($filters['category'] ?? null, function (Builder $query, $category) {
             return $query->byCategory($category);
         })
         ->when($filters['type'] ?? null, function (Builder $query, $type) {
             return $query->byType($type);
         })
         ->when($filters['search'] ?? null, function (Builder $query, $search) {
             return $query->search($search);
         })
         ->when($filters['active'] ?? null, function (Builder $query, $active) {
             return $query->active($active);
         });
     }

      /**
     * Get a list of distinct categories, optionally filtered by type.
     *
     * @param string|null $type Optional item type to filter categories by
     * @return Collection Formatted list of categories for dropdowns
     */
    public function getCategories(?string $type = null): Collection
    {
        return Item::select('category')
            ->distinct()
            ->byType($type)
        ->orderBy('category')
        ->get()
        ->map(fn($item) => [
            'value' => $item->category,
            'label' => ucfirst($item->category),
        ]);
     }

     /**
     * Get a list of distinct item types.
     *
     * @return Collection Formatted list of types for dropdowns
     */

    public function getTypes(): Collection
    {
        return Item::select('type')
            ->distinct()
            ->orderBy('type')
            ->get()
            ->map(fn($item) => [
                'value' => $item->type,
                'label' => ucfirst($item->type),
            ]);
    }
}
