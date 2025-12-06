<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\CarListing;
use App\Http\Resources\CarListingResource;

class CarListingsController extends Controller
{
    /**
     * Display car listings with filtering.
     *
     *
     */
    public function index(Request $request)
    {
        $query = CarListing::query()->with('carModel.make', 'vendor', 'addedBy', 'carOrder');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by car model
        if ($request->has('car_model_id')) {
            $query->where('car_model_id', $request->get('car_model_id'));
        }

        // Filter by vendor
        if ($request->has('vendor_id')) {
            $query->where('vendor_id', $request->get('vendor_id'));
        }

        // Filter by condition
        if ($request->has('condition')) {
            $query->where('condition', $request->get('condition'));
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

        // Search by VIN
        if ($request->has('vin')) {
            $query->where('vin', 'like', '%' . $request->get('vin') . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $listings = $query->paginate($perPage);

        if ($listings->isEmpty()) {
            return ApiResponse::success(
                [],
                'No car listings found.',
                [
                    'current_page' => $listings->currentPage(),
                    'next_page_url' => $listings->nextPageUrl(),
                    'prev_page_url' => $listings->previousPageUrl(),
                    'total' => $listings->total(),
                    'per_page' => $listings->perPage(),
                ]
            );
        }

        return ApiResponse::success(
            CarListingResource::collection($listings),
            'Car listings retrieved successfully.',
            [
                'current_page' => $listings->currentPage(),
                'next_page_url' => $listings->nextPageUrl(),
                'prev_page_url' => $listings->previousPageUrl(),
                'total' => $listings->total(),
                'per_page' => $listings->perPage(),
            ]
        );
    }

    /**
     * Store a new car listing.
     *
     * @
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_model_id' => 'required|exists:car_models,id',
            'vendor_id' => 'nullable',
            'vin' => 'required|string|unique:car_listings,vin',
            'color' => 'nullable|string',
            'mileage' => 'nullable|integer|min:0',
            'condition' => 'required|in:New,Used,Certified Pre-Owned',
            'year' => 'required|integer|min:1900|max:' . date('Y') + 1,
            'price' => 'required|numeric|min:0',
            'currency' => 'sometimes|string|size:3',
            'status' => 'sometimes|in:Available,Sold,Reserved,In Transit',
            'location' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        $validated['added_by'] = auth()->id();
        $listing = CarListing::create($validated);

        return ApiResponse::success(
            new CarListingResource($listing->load('carModel.make', 'vendor', 'addedBy')),
            'Car listing created successfully.',
            [],
            201
        );
    }

    /**
     * Display a specific car listing.
     */
    public function show(CarListing $carListing)
    {
        $carListing->load('carModel.make', 'vendor', 'addedBy', 'carOrder');
        return ApiResponse::success(
            new CarListingResource($carListing),
            'Car listing retrieved successfully.'
        );
    }

    /**
     * Update a car listing.
     */
    public function update(Request $request, CarListing $carListing)
    {
        $validated = $request->validate([
            'car_model_id' => 'required|exists:car_models,id',
            'vendor_id' => 'nullable|integer',
            'vin' => 'required|string|unique:car_listings,vin,' . $carListing->id,
            'color' => 'nullable|string',
            'mileage' => 'nullable|integer|min:0',
            'condition' => 'required|in:New,Used,Certified Pre-Owned',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'currency' => 'sometimes|string|size:3',
            'location' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        $carListing->update($validated);

        return ApiResponse::success(
            new CarListingResource(
                $carListing->load('carModel.make', 'vendor', 'addedBy', 'carOrder')
            ),
            'Car listing updated successfully.'
        );
    }

    /**
     * Delete a car listing.
     */
    public function destroy(CarListing $carListing)
    {
        $carListing->delete();

        return ApiResponse::success(
            null,
            'Car listing deleted successfully.'
        );
    }
}
