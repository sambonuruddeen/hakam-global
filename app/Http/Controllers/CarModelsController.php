<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\CarModel;
use App\Http\Resources\CarModelResource;

class CarModelsController extends Controller
{
    /**
     * Display car models with filtering.
     */
    public function index(Request $request)
    {
        $query = CarModel::query()->with('make');

        // Filter by make
        if ($request->has('make_id')) {
            $query->where('make_id', $request->get('make_id'));
        }

        // Filter by year
        if ($request->has('year')) {
            $query->where('year', $request->get('year'));
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        // Pagination
        $perPage = $request->get('per_page', 30);
        $models = $query->paginate($perPage);

        if ($models->isEmpty()) {
            return ApiResponse::success(
                [],
                'No car models found.',
                [
                    'current_page' => $models->currentPage(),
                    'next_page_url' => $models->nextPageUrl(),
                    'prev_page_url' => $models->previousPageUrl(),
                    'total' => $models->total(),
                    'per_page' => $models->perPage(),
                ]
            );
        }

        return ApiResponse::success(
            CarModelResource::collection($models),
            'Car models retrieved successfully.',
            [
                'current_page' => $models->currentPage(),
                'next_page_url' => $models->nextPageUrl(),
                'prev_page_url' => $models->previousPageUrl(),
                'total' => $models->total(),
                'per_page' => $models->perPage(),
            ]
        );
    }

    /**
     * Store a new car model.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'make_id' => 'required|exists:makes,id',
            'name' => 'required|string',
            'year' => 'nullable|integer|min:1900|max:' . date('Y') + 1,
            'engine_type' => 'nullable|string',
            'fuel_type' => 'nullable|string',
            'transmission' => 'nullable|string',
            'body_style' => 'nullable|string',
            'drive_train' => 'nullable|string',
        ]);

        $model = CarModel::create($validated);

        return ApiResponse::success(
            new CarModelResource($model->load('make')),
            'Car model created successfully.',
            [],
            201
        );
    }

    /**
     * Display a specific car model.
     */
    public function show(CarModel $carModel)
    {
        $carModel->load('make', 'carListings');
        return ApiResponse::success(
            new CarModelResource($carModel),
            'Car model retrieved successfully.'
        );
    }

    /**
     * Update a car model.
     */
    public function update(Request $request, CarModel $carModel)
    {
        $validated = $request->validate([
            'make_id' => 'sometimes|exists:makes,id',
            'name' => 'sometimes|string',
            'year' => 'nullable|integer|min:1900|max:' . date('Y') + 1,
            'engine_type' => 'nullable|string',
            'fuel_type' => 'nullable|string',
            'transmission' => 'nullable|string',
            'body_style' => 'nullable|string',
            'drive_train' => 'nullable|string',
        ]);

        $carModel->update($validated);

        return ApiResponse::success(
            new CarModelResource($carModel->load('make')),
            'Car model updated successfully.'
        );
    }

    /**
     * Delete a car model.
     */
    public function destroy(CarModel $carModel)
    {
        $carModel->delete();

        return ApiResponse::success(
            null,
            'Car model deleted successfully.'
        );
    }
}
