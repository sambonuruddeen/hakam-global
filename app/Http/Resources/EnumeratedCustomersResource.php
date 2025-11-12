<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnumeratedCustomersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $transformer = $this->transformer;
        $feeder11 = $transformer?->feeder11;
        $feeder33 = $feeder11?->feeder33;

        return [
            'id'                  => $this->id,
            'account_name'        => $this->account_name,
            'account_number'      => $this->account_number,
            'customer_type'       => $this->customer_type,
            'status'              => $this->status,
            'created_at'          => $this->created_at?->format('M d, Y'),
            'address'             => $this->address,
            'phone_number'        => $this->phone_number,
            'email'               => $this->email,
            'latitude'            => $this->latitude,
            'longitude'           => $this->longitude,
            'meter_number'        => $this->meter_number,
            'meter_status'        => $this->meter_status,
            'billing_type'        => $this->billing_type,
            'last_vending_date'   => $this->last_vending_date,
            'bill_delivery_method' => $this->bill_delivery_method,
            'last_bill_payment_date'   => $this->last_bill_payment_date,
            'transformer'         => $transformer ? [
                'name'      => $transformer->name,
                'code'      => $transformer->code,
                'feeder11'  => $feeder11 ? [
                    'name'      => $feeder11->name,
                    'feeder33'  => $feeder33 ? [
                        'name'          => $feeder33->name,
                        'businessUnit'  => $feeder33->businessUnit->name,
                    ] : null,
                ] : null,
            ] : null,
            'new_customer'        => $this->new_customer,
            'remarks'              => $this->remarks,
            'supervisor_remarks'  => $this->supervisor_remarks,
        ];
    }
}
