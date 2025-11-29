<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Http\Resources\CarResource;
use App\Helpers\ApiResponse;

class CarController extends Controller
{
    /**
     * Display a listing of all cars.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = CarListing::query()->with('carModel.make', 'vendor', 'addedBy', 'carOrder');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }
        
        // Filter by make
        if ($request->has('make')) {
            $query->where('make', $request->get('make'));
        }

        // Filter by model
        if ($request->has('model')) {
            $query->where('model', $request->get('model'));
        }

        // Filter by year
        if ($request->has('year')) {
            $query->where('year', $request->get('year'));
        }

        // Filter by vin
        if ($request->has('vin')) {
            $query->where('vin', 'like', '%' . $request->get('vin') . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $cars = $query->paginate($perPage);

        if($cars->isEmpty()) {
            return ApiResponse::success(
                [],
                'No cars found.'
            );
        }

        return ApiResponse::success(
            CarResource::collection($cars),
            'Cars retrieved successfully.',
            [
                'current_page' => $cars->currentPage(),
                'next_page_url' => $cars->nextPageUrl(),
                'prev_page_url' => $cars->previousPageUrl(),
                'last_page'    => $cars->lastPage(),
                'per_page'     => $cars->perPage(),
                'total'        => $cars->total(),
            ]
        );
    }

    /**
     * Store a newly created car in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vin' => 'required|string|unique:cars,vin|max:255',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900',
            'value' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10|in:USD,NGN,KRW,EUR,GBP',
            'color' => 'nullable|string|max:100',
            'mileage' => 'nullable|integer|min:0',
            'engine_type' => 'nullable|string|max:100',
            'fuel_type' => 'nullable|string|max:100',
            'transmission' => 'nullable|string|max:100',
            'body_style' => 'nullable|string|max:100',
            'drive_train' => 'nullable|string|max:100',
            'condition' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'options' => 'nullable|string',
            'status' => 'nullable|string|max:100|in:Available,Sold,Reserved',
            'additional_notes' => 'nullable|string',
        ]);

        $car = new Car($validated);
        $car->added_by = auth()->id();
        $car->save();

        return ApiResponse::success(
            new CarResource($car),
            'Car created successfully.'
        );
    }

    /**
     * Display the specified car.
     * 
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $car = Car::find($id);

        if (!$car) {
            return ApiResponse::error('Car not found.', 404);
        }

        return ApiResponse::success(
            new CarResource($car),
            'Car retrieved successfully.'
        );
      
    }

    /**
     * Update the specified car in storage.
     * 
     * @param Request $request
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Car $car)
    {

        try {
            $validated = $request->validate([
                'vin' => 'sometimes|string|unique:cars,vin|max:255',
                'make' => 'sometimes|string|max:255',
                'model' => 'sometimes|string|max:255',
                'year' => 'sometimes|integer|min:1900',
                'value' => 'sometimes|numeric|min:0',
                'currency' => 'nullable|string|max:10|in:USD,NGN,KRW,EUR,GBP',
                'color' => 'nullable|string|max:100',
                'mileage' => 'nullable|integer|min:0',
                'engine_type' => 'nullable|string|max:100',
                'fuel_type' => 'nullable|string|max:100',
                'transmission' => 'nullable|string|max:100',
                'body_style' => 'nullable|string|max:100',
                'drive_train' => 'nullable|string|max:100',
                'condition' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'options' => 'nullable|string',
                'status' => 'nullable|string|in:Available,Sold,Reserved',
                'additional_notes' => 'nullable|string',
            ]);


            $car->update($validated);

            return ApiResponse::success(
                new CarResource($car),
                'Car updated successfully.'
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation Error.', 422, $e->errors());
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred while updating the car.'. $e, 500);
        }
    }

    /**
     * Remove the specified car from storage.
     * 
     * @param Car $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return ApiResponse::success(
            null,
            'Car deleted successfully.'
        );
    }
}
