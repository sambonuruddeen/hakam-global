<?php

namespace App\Http\Controllers;

use App\Models\CarShipments;
use App\Models\CarOrders;
use App\Models\Shipment;
use App\Http\Resources\CarShipmentResource;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\ExternalItem;

class CarShipmentsController extends Controller
{
    /**
     * Display a listing of all car shipments (pivot records).
     */
    public function index(Request $request)
    {
        $query = CarShipments::query()->with(['carOrder', 'externalItem', 'shipment']);

        // Filter by shipment
        if ($request->has('shipment_id')) {
            $query->where('shipment_id', $request->get('shipment_id'));
        }

        // Filter by car order
        if ($request->has('car_order_id')) {
            $query->where('car_order_id', $request->get('car_order_id'));
        }

        if ($request->has('external_item_id')) {
            $query->where('external_item_id', $request->get('external_item_id'));
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $carShipments = $query->paginate($perPage);

        if ($carShipments->isEmpty()) {
            return ApiResponse::success(
                [],
                'No car shipments found.',
                [
                    'current_page' => $carShipments->currentPage(),
                    'next_page_url' => $carShipments->nextPageUrl(),
                    'prev_page_url' => $carShipments->previousPageUrl(),
                    'total' => $carShipments->total(),
                ]
            );
        }

        return ApiResponse::success(
            CarShipmentResource::collection($carShipments),
            'Car shipments retrieved successfully.',
            [
                'current_page' => $carShipments->currentPage(),
                'next_page_url' => $carShipments->nextPageUrl(),
                'prev_page_url' => $carShipments->previousPageUrl(),
                'total' => $carShipments->total(),
            ]
        );
        // return CarShipmentResource::collection($carShipments);
    }

    /**
     * Store a new car shipment association (assign a car order to a shipment).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_order_id' => 'nullable|exists:car_orders,id',
            'shipment_id' => 'required|exists:shipments,id',
            'external_item_id' => 'nullable|exists:external_items,id',
        ]);

        // Check if association already exists
        $exists = CarShipments::where('car_order_id', $validated['car_order_id'])
            ->where('shipment_id', $validated['shipment_id'])
            ->exists();

        $exists = CarShipments::where('external_item_id', $validated['external_item_id'])
            ->where('shipment_id', $validated['shipment_id'])
            ->exists();

        if ($exists) {
            // return response()->json(['message' => 'This car order is already assigned to this shipment.'], 409);
            return ApiResponse::error('This car order is already assigned to this shipment.', 409);
        }

        $carShipment = CarShipments::create($validated);

        // Update the car order's shipment_id for direct reference
        CarOrders::find($validated['car_order_id'])->update(['shipment_id' => $validated['shipment_id']]);

        if (!$carShipment) {
            return ApiResponse::error('Failed to assign car order to shipment.', 500);
        }

        // return new CarShipmentResource($carShipment->load('carOrder', 'shipment'));
        return ApiResponse::success(
            new CarShipmentResource($carShipment->load('carOrder', 'shipment')),
            'Car order assigned to shipment successfully.'
        );
    }

    /**
     * Display the specified car shipment.
     */
    public function show(CarShipments $carShipment)
    {
        $carShipment->load('carOrder', 'externalItem', 'shipment');
        // return new CarShipmentResource($carShipment);
        return ApiResponse::success(
            new CarShipmentResource($carShipment),
            'Car shipment retrieved successfully.'
        );
    }

    /**
     * Remove a car shipment association.
     */
    public function destroy(CarShipments $carShipment)
    {
        $carShipment->delete();

        // return response()->noContent();
        return ApiResponse::success(null, 'Car shipment association deleted successfully.');
    }

    /**
     * Get all cars in a specific shipment.
     */
    public function shipmentCars(int $shipmentId)
    {
        $carShipments = CarShipments::where('shipment_id', $shipmentId)
            ->with(['carOrder', 'shipment'])
            ->get();

        // return CarShipmentResource::collection($carShipments);
        return ApiResponse::success(
            CarShipmentResource::collection($carShipments),
            'Car shipments for the specified shipment retrieved successfully.'
        );
    }

    /**
     * Get all shipments for a specific car order.
     */
    public function orderShipments(int $carOrderId)
    {
        $carShipments = CarShipments::where('car_order_id', $carOrderId)
            ->with(['carOrder', 'shipment'])
            ->get();

        // return CarShipmentResource::collection($carShipments);
        return ApiResponse::success(
            CarShipmentResource::collection($carShipments),
            'Car shipments for the specified car order retrieved successfully.'
        );
    }

    /**
     * Bulk assign multiple car orders to a shipment.
     */
    public function bulkAssign(Request $request)
    {
        $validated = $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'car_order_ids' => 'required|array',
            'car_order_ids.*' => 'exists:car_orders,id',
        ]);

        $shipmentId = $validated['shipment_id'];
        $carOrderIds = $validated['car_order_ids'];

        $created = [];
        $skipped = [];

        foreach ($carOrderIds as $carOrderId) {
            $exists = CarShipments::where('car_order_id', $carOrderId)
                ->where('shipment_id', $shipmentId)
                ->exists();

            if (!$exists) {
                $carShipment = CarShipments::create([
                    'car_order_id' => $carOrderId,
                    'shipment_id' => $shipmentId,
                ]);
                // Update the car order's shipment_id
                CarOrders::find($carOrderId)->update(['shipment_id' => $shipmentId]);
                $created[] = $carShipment->id;
            } else {
                $skipped[] = $carOrderId;
            }
        }

        // return response()->json([
        //     'message' => 'Bulk assignment completed',
        //     'created' => $created,
        //     'skipped' => $skipped,
        // ]);
        return ApiResponse::success(
            [
                'created' => $created,
                'skipped' => $skipped,
            ],
            'Bulk assignment completed.'
        );
    }
}
