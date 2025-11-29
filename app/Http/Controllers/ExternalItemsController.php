<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\ExternalItem;
use App\Http\Resources\ExternalItemResource;

class ExternalItemsController extends Controller
{
    /**
     * Display external items with filtering.
     */
    public function index(Request $request)
    {
        $query = ExternalItem::query()->with('vendor');

        // Filter by vendor
        if ($request->has('vendor_id')) {
            $query->where('vendor_id', $request->get('vendor_id'));
        }

        // Filter by make
        if ($request->has('make')) {
            $query->where('make', 'like', '%' . $request->get('make') . '%');
        }

        // Filter by model
        if ($request->has('model')) {
            $query->where('model', 'like', '%' . $request->get('model') . '%');
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

        // Pagination
        $perPage = $request->get('per_page', 15);
        $items = $query->paginate($perPage);

        if ($items->isEmpty()) {
            return ApiResponse::success(
                [],
                'No external items found.',
                [
                    'current_page' => $items->currentPage(),
                    'next_page_url' => $items->nextPageUrl(),
                    'prev_page_url' => $items->previousPageUrl(),
                    'total' => $items->total(),
                    'per_page' => $items->perPage(),
                ]
            );
        }

        return ApiResponse::success(
            ExternalItemResource::collection($items),
            'External items retrieved successfully.',
            [
                'current_page' => $items->currentPage(),
                'next_page_url' => $items->nextPageUrl(),
                'prev_page_url' => $items->previousPageUrl(),
                'total' => $items->total(),
                'per_page' => $items->perPage(),
            ]
        );
    }

    /**
     * Store a new external item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vin' => 'nullable|string|unique:external_items,vin',
            'description' => 'required|string',
            'make' => 'nullable|string',
            'model' => 'nullable|string',
            'year' => 'nullable|integer|min:1900|max:' . date('Y') + 1,
            'price' => 'required|numeric|min:0',
            'currency' => 'sometimes|string|size:3',
            'vendor_id' => 'nullable|exists:vendors,id',
            'source_info' => 'nullable|string',
        ]);

        $item = ExternalItem::create($validated);

        return ApiResponse::success(
            new ExternalItemResource($item->load('vendor')),
            'External item created successfully.',
            [],
            201
        );
    }

    /**
     * Display a specific external item.
     */
    public function show(ExternalItem $externalItem)
    {
        $externalItem->load('vendor');
        return ApiResponse::success(
            new ExternalItemResource($externalItem),
            'External item retrieved successfully.'
        );
    }

    /**
     * Update an external item.
     */
    public function update(Request $request, ExternalItem $externalItem)
    {
        $validated = $request->validate([
            'description' => 'sometimes|string',
            'make' => 'nullable|string',
            'model' => 'nullable|string',
            'year' => 'nullable|integer|min:1900|max:' . date('Y') + 1,
            'price' => 'sometimes|numeric|min:0',
            'currency' => 'sometimes|string|size:3',
            'vendor_id' => 'nullable|exists:vendors,id',
            'source_info' => 'nullable|string',
        ]);

        $externalItem->update($validated);

        return ApiResponse::success(
            new ExternalItemResource($externalItem->load('vendor')),
            'External item updated successfully.'
        );
    }

    /**
     * Delete an external item.
     */
    public function destroy(ExternalItem $externalItem)
    {
        $externalItem->delete();

        return ApiResponse::success(
            null,
            'External item deleted successfully.'
        );
    }
}
