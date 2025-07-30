<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\IndexItemRequest;
use Illuminate\Http\Request;

class IndexItems extends Controller
{

    public function __construct(
        private readonly \App\Services\ItemService $itemService
    ) {
        // The constructor can be used to inject dependencies like services.
        // This keeps the controller clean and focused on request handling.
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexItemRequest $request)
    {

        $filters = $request->getFilters();
        $sorting = $request->getSorting();
        $perPage = $request->getPerPage();

        // Use the filters, sorting, and pagination in your query

        $items = $this->itemService
        ->getFilterableAndSortable($filters, $sorting, $perPage);

        // Fetch categories and types for the view
        // This can be used to populate dropdowns or filters in the UI.
        // The service methods encapsulate the logic for fetching categories and types.
        $categories = $this->itemService->getCategories($filters['type'] ?? null);
        $types = $this->itemService->getTypes();

        // Return the view with the items, filters, sorting, categories, and types
        // This allows the view to render the items list along with any filters or sorting options.

        return view('items.index', [
            'items' => $items,
            'filters' => $filters,
            'sorting' => $sorting,
            'categories' => $categories,
            'types' => $types,
        ]);

    }
}
