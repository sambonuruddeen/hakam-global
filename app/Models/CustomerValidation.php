<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerValidation extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number',
        'account_name',
        'address',
        'phone_number',
        'email',
        'latitude',
        'longitude',
        'customer_type',
        'meter_number',
        'meter_status',
        'last_vending_date',
        'billing_type',
        'bill_delivery_method',
        'last_bill_payment_date',
        'transformer_id',
        'new_customer',
        'remarks',
        'status',
        'supervisor_remarks',
        'photo',
        'created_by',
        'updated_by'
    ];

    public function transformer()
    {
        return $this->belongsTo(Transformer::class, 'transformer_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
