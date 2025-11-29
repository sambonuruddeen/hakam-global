<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Vendor;
use App\Http\Resources\VendorResource;

class VendorsController extends Controller
{
    /**
     * Display all vendors with filtering and pagination.
     */
    public function index(Request $request)
    {
        $query = Vendor::query();

        // Filter by vendor type
        if ($request->has('vendor_type')) {
            $query->where('vendor_type', $request->get('vendor_type'));
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $vendors = $query->paginate($perPage);

        if ($vendors->isEmpty()) {
            return ApiResponse::success(
                [],
                'No vendors found.',
                [
                    'current_page' => $vendors->currentPage(),
                    'next_page_url' => $vendors->nextPageUrl(),
                    'prev_page_url' => $vendors->previousPageUrl(),
                    'total' => $vendors->total(),
                    'per_page' => $vendors->perPage(),
                ]
            );
        }

        return ApiResponse::success(
            VendorResource::collection($vendors),
            'Vendors retrieved successfully.',
            [
                'current_page' => $vendors->currentPage(),
                'next_page_url' => $vendors->nextPageUrl(),
                'prev_page_url' => $vendors->previousPageUrl(),
                'total' => $vendors->total(),
                'per_page' => $vendors->perPage(),
            ]
        );
    }

    /**
     * Store a new vendor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:vendors,name',
            'vendor_type' => 'required|in:Dealer,Supplier,Auction House,Individual',
            'contact_person' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'status' => 'sometimes|in:Active,Inactive,Suspended',
        ]);

        $vendor = Vendor::create($validated);

        return ApiResponse::success(
            new VendorResource($vendor),
            'Vendor created successfully.',
            [],
            201
        );
    }

    /**
     * Display a specific vendor.
     */
    public function show(Vendor $vendor)
    {
        return ApiResponse::success(
            new VendorResource($vendor),
            'Vendor retrieved successfully.'
        );
    }

    /**
     * Update a vendor.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|unique:vendors,name,' . $vendor->id,
            'vendor_type' => 'sometimes|in:Dealer,Supplier,Auction House,Individual',
            'contact_person' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'status' => 'sometimes|in:Active,Inactive,Suspended',
        ]);

        $vendor->update($validated);

        return ApiResponse::success(
            new VendorResource($vendor),
            'Vendor updated successfully.'
        );
    }

    /**
     * Delete a vendor.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return ApiResponse::success(
            null,
            'Vendor deleted successfully.'
        );
    }
}
