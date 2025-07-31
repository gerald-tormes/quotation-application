<?php

namespace App\Http\Controllers\Items;

use App\DTOs\ItemData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Item\StoreItemRequest;
use Illuminate\Http\Request;

class StoreItem extends Controller
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
    public function __invoke(StoreItemRequest $request)
    {
        $dto = ItemData::fromRequest($request);

        // Use the service to create the item.
        $this->itemService->createItem($dto);

        // Redirect to the items index page with a success message.
        return redirect()->route('items.index')->with('success', 'Item created successfully.');


    }

}
