<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Http\Resources\ShipmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ApiResponse;

class ShipmentController extends Controller
{
    /**
     * Display a listing of all shipments.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Shipment::query();

        // Eager load car orders and car shipments
        $query->with(['carOrders', 'carShipments']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by tracking number
        if ($request->has('tracking_number')) {
            $query->where('tracking_number', 'like', '%' . $request->get('tracking_number') . '%');
        }

        // Filter by origin
        if ($request->has('origin')) {
            $query->where('origin', $request->get('origin'));
        }

        // Filter by destination
        if ($request->has('destination')) {
            $query->where('destination', $request->get('destination'));
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $shipments = $query->paginate($perPage);

        // return ShipmentResource::collection($shipments);
        return ApiResponse::success(
            ShipmentResource::collection($shipments),
            'Shipments retrieved successfully.',
            [
                'current_page' => $shipments->currentPage(),
                'next_page_url' => $shipments->nextPageUrl(),
                'prev_page_url' => $shipments->previousPageUrl(),
                'last_page'    => $shipments->lastPage(),
                'per_page'     => $shipments->perPage(),
                'total'        => $shipments->total(),
            ]
        );
    }

    /**
     * Store a newly created shipment in storage.
     *
     * @param Request $request
     * @return ShipmentResource
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_company' => 'required|string|max:255',
            'container_type' => 'required|string|max:255',
            'container_number' => 'required|string|unique:shipments',
            'tracking_number' => 'required|string|unique:shipments',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'shipment_date' => 'required|date',
            'delivery_date' => 'nullable|date|after_or_equal:shipment_date',
            'status' => 'required|in:ordered,in_transit,at_port,last_mile,delivered',
        ]);

        $shipment = Shipment::create($validated);

        return new ShipmentResource($shipment);
    }

    /**
     * Display the specified shipment.
     *
     * @param Shipment $shipment
     * @return ShipmentResource
     */
    public function show(Shipment $shipment)
    {
        return new ShipmentResource($shipment);
    }

    /**
     * Update the specified shipment in storage.
     *
     * @param Request $request
     * @param Shipment $shipment
     * @return ShipmentResource
     */
    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'shipping_company' => 'sometimes|string|max:255',
            'container_type' => 'sometimes|string|max:255',
            'container_number' => 'sometimes|string|unique:shipments,container_number,' . $shipment->id,
            'tracking_number' => 'sometimes|string|unique:shipments,tracking_number,' . $shipment->id,
            'origin' => 'sometimes|string|max:255',
            'destination' => 'sometimes|string|max:255',
            'shipment_date' => 'sometimes|date',
            'delivery_date' => 'nullable|date|after_or_equal:shipment_date',
            'status' => 'sometimes|in:ordered,in_transit,at_port,last_mile,delivered',
        ]);

        $shipment->update($validated);

        return new ShipmentResource($shipment);
    }

    /**
     * Remove the specified shipment from storage.
     *
     * @param Shipment $shipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return response()->noContent();
    }

    /**
     * Get shipments by status.
     *
     * @param string $status
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function byStatus(string $status)
    {
        $shipments = Shipment::where('status', $status)->get();

        return ShipmentResource::collection($shipments);
    }

    /**
     * Get shipment statistics and metrics.
     *
     * @return \Illuminate\Http\Response
     */
    public function statistics()
    {
        $stats = [
            'total_shipments' => Shipment::count(),
            'active_shipments' => Shipment::whereIn('status', ['ordered', 'in_transit', 'at_port', 'last_mile'])->count(),
            'delivered_shipments' => Shipment::where('status', 'delivered')->count(),
            'by_status' => [
                'ordered' => Shipment::where('status', 'ordered')->count(),
                'in_transit' => Shipment::where('status', 'in_transit')->count(),
                'at_port' => Shipment::where('status', 'at_port')->count(),
                'last_mile' => Shipment::where('status', 'last_mile')->count(),
                'delivered' => Shipment::where('status', 'delivered')->count(),
            ],
        ];

        return response()->json($stats);
    }

    /**
     * Get the latest shipments.
     *
     * @param int $limit
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function latest(int $limit = 10)
    {
        $shipments = Shipment::latest()->limit($limit)->get();

        return ShipmentResource::collection($shipments);
    }
}
