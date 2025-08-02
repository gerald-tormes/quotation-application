<?php

use App\DTOs\ItemData;
use App\Http\Controllers\Items\StoreItem;
use App\Http\Requests\Item\StoreItemRequest;
use App\Services\ItemService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::post('/items', StoreItem::class)->name('items.store');


Route::get('/test-items', function (ItemService $itemService) {
    $data = [
        'item_code' => 'ITEM123',
        'name' => 'Test Item1',
        'category' => 'Test Category',
        'type' => 'Test Type',
        'cost_price' => 100.00,
        'selling_price' => 150.00,
        'is_active' => true,
    ];

    $dto = new \App\DTOs\ItemData(...$data);

    $item = $itemService->createItem($dto);

    return response()->json([
        'item' => $item,
        'logs' => \App\Models\ActivityLog::latest()->take(1)->get(),
    ]);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
