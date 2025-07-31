<?php

namespace App\DTOs;

use App\Http\Requests\Item\StoreItemRequest;

class ItemData
{
    public function __construct(
        public ?string $item_code,
        public ?string $name,
        public ?string $category,
        public ?string $type,
        public ?float $cost_price,
        public ?float $selling_price,
        public ?bool $is_active = true,
    ) {}

    public static function fromRequest(StoreItemRequest $request): self
    {
        return new self(
            item_code: $request->input('item_code'),
            name: $request->input('name'),
            category: $request->input('category'),
            type: $request->input('type'),
            cost_price: (float) $request->input('cost_price'),
            selling_price: (float) $request->input('selling_price'),
            is_active: $request->boolean('is_active'),
        );
    }

    //     public function toArray(): array
    // {
    //     return [
    //         'item_code' => $this->item_code,
    //         'name' => $this->name,
    //         'category' => $this->category,
    //         'type' => $this->type,
    //         'cost_price' => $this->cost_price,
    //         'selling_price' => $this->selling_price,
    //         'is_active' => $this->is_active,
    //     ];
    // }

}
