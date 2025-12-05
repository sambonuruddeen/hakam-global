<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\PaymentTransaction;
use App\Http\Resources\PaymentTransactionResource;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentTransactionsController extends Controller
{
    /**
     * Display payment transactions with filtering.
     */
    public function index(Request $request)
    {
        $query = PaymentTransaction::query();

        // Filter by transaction type
        if ($request->has('transaction_type')) {
            $query->where('transaction_type', $request->get('transaction_type'));
        }

        // Filter by payment status
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->get('payment_status'));
        }

        // Filter by related type (CarOrder or Shipment)
        if ($request->has('related_type')) {
            $query->where('related_type', $request->get('related_type'));
        }

        // Filter by related ID (specific car order or shipment)
        if ($request->has('related_id')) {
            $query->where('related_id', $request->get('related_id'));
        }

        // Filter by currency
        if ($request->has('currency')) {
            $query->where('currency', $request->get('currency'));
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $transactions = $query->paginate($perPage);

        if ($transactions->isEmpty()) {
            return ApiResponse::success(
                [],
                'No payment transactions found.',
                [
                    'current_page' => $transactions->currentPage(),
                    'next_page_url' => $transactions->nextPageUrl(),
                    'prev_page_url' => $transactions->previousPageUrl(),
                    'total' => $transactions->total(),
                    'per_page' => $transactions->perPage(),
                ]
            );
        }

        return ApiResponse::success(
            PaymentTransactionResource::collection($transactions),
            'Payment transactions retrieved successfully.',
            [
                'current_page' => $transactions->currentPage(),
                'next_page_url' => $transactions->nextPageUrl(),
                'prev_page_url' => $transactions->previousPageUrl(),
                'total' => $transactions->total(),
                'per_page' => $transactions->perPage(),
            ]
        );
    }

    /**
     * Store a new payment transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_type' => 'required|in:Car Purchase,Shipping',
            'related_id'   => 'required|integer',
            'related_type' => 'required|in:App\Models\CarOrder,App\Models\Shipment',
            'amount'          => 'required|numeric|min:0.01',
            'currency'        => 'nullable|string|size:3',
            'payment_status'  => 'nullable|in:Pending,Completed,Cancelled,Refunded',
            'payment_method'  => 'nullable|string',
            'payment_date'    => 'nullable|date',
            'reference_number' => 'nullable|string|unique:payment_transactions,reference_number',
            'notes'           => 'nullable|string',
        ]);

        // Set default values
        if (!isset($validated['currency'])) {
            $validated['currency'] = 'NGN';
        }

        if (!isset($validated['payment_status'])) {
            $validated['payment_status'] = 'Pending';
        }

        // Auto-generate reference number if missing
        if (!isset($validated['reference_number'])) {
            $validated['reference_number'] = 'REF-' . strtoupper(Str::random(10));
        }

        // Create the transaction
        $transaction = PaymentTransaction::create($validated);

        return ApiResponse::success(
            new PaymentTransactionResource($transaction),
            'Payment transaction created successfully.',
            [],
            201
        );
    }

    /**
     * Display a specific payment transaction.
     */
    public function show(PaymentTransaction $paymentTransaction)
    {
        return ApiResponse::success(
            new PaymentTransactionResource($paymentTransaction),
            'Payment transaction retrieved successfully.'
        );
    }

    /**
     * Update a payment transaction.
     */
    public function update(Request $request, PaymentTransaction $paymentTransaction)
    {
        $validated = $request->validate([
            'payment_status' => 'sometimes|in:Pending,Completed,Failed,Refunded',
            'payment_method' => 'nullable|string',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $paymentTransaction->update($validated);

        return ApiResponse::success(
            new PaymentTransactionResource($paymentTransaction),
            'Payment transaction updated successfully.'
        );
    }

    /**
     * Delete a payment transaction.
     */
    public function destroy(PaymentTransaction $paymentTransaction)
    {
        $paymentTransaction->delete();

        return ApiResponse::success(
            null,
            'Payment transaction deleted successfully.'
        );
    }

    /**
     * Get pending payments.
     */
    public function pending(Request $request)
    {
        $query = PaymentTransaction::pending();

        if ($request->has('transaction_type')) {
            $query->where('transaction_type', $request->get('transaction_type'));
        }

        $transactions = $query->paginate($request->get('per_page', 15));

        return ApiResponse::success(
            PaymentTransactionResource::collection($transactions),
            'Pending payment transactions retrieved successfully.'
        );
    }

    /**
     * Get completed payments.
     */
    public function completed(Request $request)
    {
        $query = PaymentTransaction::completed();

        if ($request->has('transaction_type')) {
            $query->where('transaction_type', $request->get('transaction_type'));
        }

        $transactions = $query->paginate($request->get('per_page', 15));

        return ApiResponse::success(
            PaymentTransactionResource::collection($transactions),
            'Completed payment transactions retrieved successfully.'
        );
    }
}
