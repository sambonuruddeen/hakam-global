<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\EnumeratedCustomersResource;
use App\Models\CustomerValidation;
use App\Models\Transformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CustomerValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Your session has expired. Please login again.'
            ], 401);
        }

        // Fetch enumerated customers with transformer relation (paginated)
        $customers = CustomerValidation::latest()->paginate(20);

        // return ApiResponse::success(
        //     EnumeratedCustomersResource::collection($customers),
        //     'Enumerated Customers fetched successfully'
        // );

        return ApiResponse::success($customers, 'Enumerated Customers fetched successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Your session has expired. Please login again.'
            ], 401);
        }

        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'account_name'        => 'required|string|max:255',
            'account_number'      => 'required|string',
            'customer_type'       => 'required|string',
            'address'             => 'required|string',
            'phone_number'        => 'required',
            'email'               => 'nullable|email',
            'latitude'            => 'required',
            'longitude'           => 'required',
            'meter_number'        => 'nullable|string',
            'meter_status'        => 'nullable|string',
            'billing_type'        => 'nullable|string',
            'last_vending_date'   => 'nullable|date',
            'bill_delivery_method' => 'nullable|string',
            'last_bill_payment_date'   => 'nullable|date',
            'transformer_id'      => 'required|exists:transformers,id',
            'new_customer'        => 'nullable',
            'remark'              => 'nullable|string',
            'supervisor_remarks'  => 'nullable|string',
            'status'              => 'nullable|string',
            'photo'               => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Check if customer exists and status is approved
        $existingCustomer = CustomerValidation::where('account_number', $request->account_number)->first();
        if ($existingCustomer && $existingCustomer->status === 'Approved') {
            return response()->json([
                'message' => 'Customer record has already been approved and cannot be created or updated.'
            ], 403); // Forbidden
        }

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('customer_photos', 'public');
        }

        // Create or update customer based on account_number
        $customer = CustomerValidation::updateOrCreate(
            ['account_number' => $request->account_number], // match column
            [
                'account_name'        => $request->account_name,
                'customer_type'       => $request->customer_type,
                'address'             => $request->address,
                'phone_number'        => $request->phone_number,
                'email'               => $request->email,
                'latitude'            => $request->latitude,
                'longitude'           => $request->longitude,
                'meter_number'        => $request->meter_number,
                'meter_status'        => $request->meter_status,
                'billing_type'        => $request->billing_type,
                'last_vending_date'   => $request->last_vending_date,
                'bill_delivery_method' => $request->bill_delivery_method,
                'last_bill_payment_date'   => $request->last_bill_payment_date,
                'transformer_id'      => $request->transformer_id,
                'new_customer'        => $request->new_customer,
                'remarks'              => $request->remarks,
                'supervisor_remarks'  => $request->supervisor_remarks,
                'status'              => 'Pending',
                'photo'               => $photoPath,
                'created_by'          => $user->id,
            ]
        );

        return response()->json([
            'message' => 'Customer Enumeration Created/Updated successfully',
            'data'    => new EnumeratedCustomersResource($customer)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Your session has expired. Please login again.'
            ], 401);
        }

        // Fetch enumerated customer Details
        $customer = CustomerValidation::with('transformer.feeder11.feeder33')
            ->find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found.'
            ], 404);
        }

        return ApiResponse::success(
            new EnumeratedCustomersResource($customer),
            'Enumerated Customer fetched successfully'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Approve Enumerated Customer
    public function approve(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Your session has expired. Please login again.'
            ], 401);
        }

        $request->validate([
            'id' => 'required|integer|exists:customer_validations,id',
            'remark' => 'nullable|string',
        ]);

        $customer = CustomerValidation::find($request->id);
        $customer->status = 'Approved';
        $customer->updated_by = $user->id;
        $customer->supervisor_remarks = $request->remark;
        $customer->save();

        return ApiResponse::success($customer, 'Customer rejected successfully.');
    }

    // Reject Enumerated Customer
    public function reject(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Your session has expired. Please login again.'
            ], 401);
        }

        $request->validate([
            'id' => 'required|integer|exists:customer_validations,id',
            'remark' => 'nullable|string',
        ]);

        $customer = CustomerValidation::find($request->id);
        $customer->status = 'Rejected';
        $customer->updated_by = $user->id;
        $customer->supervisor_remarks = $request->remark;
        $customer->save();

        return ApiResponse::success($customer, 'Customer rejected successfully.');
    }
}
