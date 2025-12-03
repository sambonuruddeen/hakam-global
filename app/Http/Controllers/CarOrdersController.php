<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\CarOrders;
use App\Http\Resources\CarOrdersResource;


class CarOrdersController extends Controller
{

    /**
     * Display a listing of all car orders.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = CarOrders::query()->with(['user', 'carListing.carModel.make', 'carListing.vendor', 'shipment', 'shipmentItem', 'paymentTransactions']);

        // Filter by order status
        if ($request->has('order_status')) {
            $query->where('order_status', $request->get('order_status'));
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        // Filter by car listing
        if ($request->has('car_listing_id')) {
            $query->where('car_listing_id', $request->get('car_listing_id'));
        }

        // Filter by shipment
        if ($request->has('shipment_id')) {
            $query->where('shipment_id', $request->get('shipment_id'));
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $orders = $query->paginate($perPage);

        if ($orders->isEmpty()) {
            return ApiResponse::success(
                [],
                'No car orders found.',
                [
                    'current_page' => $orders->currentPage(),
                    'next_page_url' => $orders->nextPageUrl(),
                    'prev_page_url' => $orders->previousPageUrl(),
                    'total' => $orders->total(),
                    'per_page' => $orders->perPage(),
                ]
            );
        }

        return ApiResponse::success(
            CarOrdersResource::collection($orders),
            'Car orders retrieved successfully.',
            [
                'current_page' => $orders->currentPage(),
                'next_page_url' => $orders->nextPageUrl(),
                'prev_page_url' => $orders->previousPageUrl(),
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
            ]
        );
    }

    /**
     * Store a newly created car order.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_listing_id' => 'required|exists:car_listings,id|unique:car_orders,car_listing_id',
            'purchase_price' => 'required|numeric|min:0.01',
            'purchase_currency' => 'sometimes|string|size:3',
            'shipment_id' => 'nullable|exists:shipments,id',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['purchase_date'] = now()->format('Y-m-d');
        $order = CarOrders::create($validated);

        return ApiResponse::success(
            new CarOrdersResource($order->load('user', 'carListing.carModel.make', 'carListing.vendor', 'shipment', 'paymentTransactions')),
            'Car order created successfully.',
            [],
            201
        );
    }

    /**
     * Display the specified car order.
     *
     * @param CarOrders $carOrder
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CarOrders $carOrder)
    {
        $carOrder->load('user', 'carListing.carModel.make', 'carListing.vendor', 'shipment', 'shipmentItem', 'paymentTransactions');
        return ApiResponse::success(
            new CarOrdersResource($carOrder),
            'Car order retrieved successfully.'
        );
    }

    /**
     * Update the specified car order.
     *
     * @param Request $request
     * @param CarOrders $carOrder
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, CarOrders $carOrder)
    {
        $validated = $request->validate([
            'order_status' => 'sometimes|in:Requested,Purchase Confirmed,Awaiting Pickup,Queued for Shipment,Shipped,Delivered,Cancelled',
            'purchase_date' => 'sometimes|date',
            'shipment_id' => 'sometimes|nullable|exists:shipments,id',
        ]);

        $carOrder->update($validated);

        return ApiResponse::success(
            new CarOrdersResource($carOrder->load('user', 'carListing.carModel.make', 'carListing.vendor', 'shipment', 'paymentTransactions')),
            'Car order updated successfully.'
        );
    }

    /**
     * Remove the specified car order.
     *
     * @param CarOrders $carOrder
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CarOrders $carOrder)
    {
        $carOrder->delete();

        return ApiResponse::success(
            null,
            'Car order deleted successfully.'
        );
    }

    /**
     * Get orders by status.
     *
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function byStatus(string $status)
    {
        $orders = CarOrders::where('order_status', $status)
            ->with(['user', 'carListing.carModel.make', 'carListing.vendor', 'shipment', 'paymentTransactions'])
            ->get();

        if ($orders->isEmpty()) {
            return ApiResponse::success(
                [],
                'No car orders found with the specified status.'
            );
        }

        return ApiResponse::success(
            CarOrdersResource::collection($orders),
            'Car orders retrieved successfully.'
        );
    }

    /**
     * Get orders for a specific user.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function byUser(int $userId)
    {
        $orders = CarOrders::where('user_id', $userId)
            ->with(['carListing.carModel.make', 'carListing.vendor', 'shipment', 'paymentTransactions'])
            ->get();

        return ApiResponse::success(
            CarOrdersResource::collection($orders),
            'Car orders for user retrieved successfully.'
        );
    }
}
