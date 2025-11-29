<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Helpers\ApiResponse;
use App\Models\CarShipments;
use App\Models\CarOrders;
use App\Models\ExternalItem;
use App\Models\ShipmentItem;
use App\Http\Resources\ShipmentItemResource;

class ShipmentItemsController extends Controller
{
    /**
     * Add an item (CarOrder or ExternalItem) to a shipment.
     */
    public function store(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'item_type' => 'required|exists:ShipmentItem',
            'item_id' => 'required|integer',
            'custom_description' => 'nullable|string|max:1000',
            'custom_price' => 'nullable|numeric|min:0',
            'custom_currency' => 'nullable|string|size:3',
        ]);

        // Verify the item exists
        $itemClass = $validated['item_type'];
        $item = $itemClass::find($validated['item_id']);

        if (!$item) {
            return ApiResponse::error('The specified item does not exist.', 404);
        }

        // Check for duplicate
        $exists = ShipmentItem::where('shipment_id', $shipment->id)
            ->where('item_type', $validated['item_type'])
            ->where('item_id', $validated['item_id'])
            ->exists();

        if ($exists) {
            return ApiResponse::error('This item is already in the shipment.', 409);
        }

        $shipmentItem = ShipmentItem::create(array_merge(
            $validated,
            ['shipment_id' => $shipment->id]
        ));

        return ApiResponse::success(
            new ShipmentItemResource($shipmentItem->load('item')),
            'Item added to shipment successfully.',
            [],
            201
        );
    }

    /**
     * Get all items in a shipment (mixed types).
     * 
     * 
     */
    public function shipmentItems(Request $request, $shipmentId)
    {
        // Find the Shipment or return an error if not found
        $shipment = Shipment::find($shipmentId); // $shipmentId should be passed via route

        if (!$shipment) {
            return ApiResponse::error('Shipment not found', 404);
        }
        
        $items = $shipment->shipmentItems()->with('item')->get();

        if($items->isEmpty()) {
            return ApiResponse::error('No shipment items found', 404);
        }


        return ApiResponse::success(
            ShipmentItemResource::collection($items),
            'Shipment items retrieved successfully.',
            [
                'total' => $items->count(),
                'car_orders_count' => $items->where('item_type', 'App\Models\CarOrder')->count(),
                'external_items_count' => $items->where('item_type', 'App\Models\ExternalItem')->count(),
            ]
        );
    }

    /**
     * Remove an item from a shipment.
     */
    public function destroy(Shipment $shipment, ShipmentItem $shipmentItem)
    {
        if ($shipmentItem->shipment_id !== $shipment->id) {
            return ApiResponse::error('This item is not in the specified shipment.', 404);
        }

        $shipmentItem->delete();

        return ApiResponse::success(
            null,
            'Item removed from shipment successfully.'
        );
    }

    /**
     * Update a shipment item.
     */
    public function update(Request $request, Shipment $shipment, ShipmentItem $shipmentItem)
    {
        if ($shipmentItem->shipment_id !== $shipment->id) {
            return ApiResponse::error('This item is not in the specified shipment.', 404);
        }

        $validated = $request->validate([
            'custom_description' => 'nullable|string|max:1000',
            'custom_price' => 'nullable|numeric|min:0',
            'custom_currency' => 'nullable|string|size:3',
        ]);

        $shipmentItem->update($validated);

        return ApiResponse::success(
            new ShipmentItemResource($shipmentItem->load('item')),
            'Shipment item updated successfully.'
        );
    }
}
