<?php

namespace Tests\Unit;

use App\DTOs\ItemData;
use App\Http\Requests\Item\StoreItemRequest;
use Illuminate\Support\Facades\Validator;


class ItemDataTest extends \Tests\TestCase
{
    public function testExample()
    {
        $data = [
            'item_code' => 'ITEM123',
            'name' => 'Test Item',
            'category' => 'Test Category',
            'type' => 'Test Type',
            'cost_price' => 100.00,
            'selling_price' => 150.00,
            'is_active' => true,
        ];

         $request = StoreItemRequest::create('/items', 'POST', $data);
    $request->setValidator(
            Validator::make($data, (new StoreItemRequest)->rules())
        );

         $dto = ItemData::fromRequest($request);

    $this->assertEquals('ITEM123', $dto->item_code);
    $this->assertEquals('Test Item', $dto->name);
    $this->assertEquals('Test Category', $dto->category);
    $this->assertEquals('Test Type', $dto->type);
    $this->assertEquals(100.00, $dto->cost_price);
    $this->assertEquals(150.00, $dto->selling_price);
    $this->assertTrue($dto->is_active);
    }


    public function testFromRequest()
    {
        $data = [
            'item_code' => null,
            'name' => 'Test Item',
            'category' => null,
            'type' => null,
            'cost_price' => '0',
            'selling_price' => '10',
            'is_active' => false,
        ];

        $request = StoreItemRequest::create('/items', 'POST', $data);
        $request->setValidator(
            Validator::make($data, (new StoreItemRequest)->rules())
        );

        $dto = ItemData::fromRequest($request);

        $this->assertNull($dto->item_code);
        $this->assertEquals('Test Item', $dto->name);
        $this->assertNull($dto->category);
        $this->assertFalse($dto->is_active);
    }

    /** @test */
public function debug_request_data()
{
    $data = ['item_code' => 'TEST123', 'name' => 'Test'];

    $request = StoreItemRequest::create('/items', 'POST', $data);

    // This will show you what the request actually contains
    dump($request->all());
    dump($request->input('item_code'));

    $this->assertTrue(true); // Just to make test pass
}
}

