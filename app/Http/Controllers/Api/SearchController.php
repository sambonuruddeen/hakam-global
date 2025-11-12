<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Feeder11;
use App\Models\Transformer;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function customers(string $account_meter)
    {
        // Get the authenticated user
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Your session has expired. Please login again.'
            ], 401);
        }

        $customers = Customer::where('account_number', $account_meter)
            ->orWhere('meter_number', $account_meter)
            ->first();

        return ApiResponse::success($customers, 'Customers fetched successfully.');
    }

    public function feeder11()
    {
        // Get the authenticated user
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Your session has expired. Please login again.'
            ], 401);
        }

        $feeders = Feeder11::get();

        return ApiResponse::success($feeders, 'feeders fetched successfully.');
    }

    // Get Transformers by Feeder ID
    public function transformersByFeeder($feeder_id)
    {
        // Get the authenticated user
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Your session has expired. Please login again.'
            ], 401);
        }

        // Filter transformers by the selected feeder
        $transformers = Transformer::where('feeder11_id', $feeder_id)->get();

        return ApiResponse::success($transformers, 'Transformers fetched successfully.');
    }
}
