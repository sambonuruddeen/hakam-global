<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Make;
use App\Http\Resources\MakeResource;

class MakesController extends Controller
{
    /**
     * Display all car makes.
     */
    public function index(Request $request)
    {
        $query = Make::query();

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        // Pagination
        $perPage = $request->get('per_page', 50);
        $makes = $query->orderBy('name')->paginate($perPage);

        if ($makes->isEmpty()) {
            return ApiResponse::success(
                [],
                'No makes found.',
                [
                    'current_page' => $makes->currentPage(),
                    'next_page_url' => $makes->nextPageUrl(),
                    'prev_page_url' => $makes->previousPageUrl(),
                    'total' => $makes->total(),
                    'per_page' => $makes->perPage(),
                ]
            );
        }

        return ApiResponse::success(
            MakeResource::collection($makes),
            'Makes retrieved successfully.',
            [
                'current_page' => $makes->currentPage(),
                'next_page_url' => $makes->nextPageUrl(),
                'prev_page_url' => $makes->previousPageUrl(),
                'total' => $makes->total(),
                'per_page' => $makes->perPage(),
            ]
        );
    }

    /**
     * Store a new car make.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:makes,name',
            'country' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        $make = Make::create($validated);

        return ApiResponse::success(
            new MakeResource($make),
            'Make created successfully.',
            [],
            201
        );
    }

    /**
     * Display a specific make with its models.
     */
    public function show(Make $make)
    {
        $make->load('carModels');
        return ApiResponse::success(
            new MakeResource($make),
            'Make retrieved successfully.'
        );
    }

    /**
     * Update a make.
     */
    public function update(Request $request, Make $make)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|unique:makes,name,' . $make->id,
            'country' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        $make->update($validated);

        return ApiResponse::success(
            new MakeResource($make),
            'Make updated successfully.'
        );
    }

    /**
     * Delete a make and cascade delete models.
     */
    public function destroy(Make $make)
    {
        $make->delete();

        return ApiResponse::success(
            null,
            'Make deleted successfully.'
        );
    }
}
