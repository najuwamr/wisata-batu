<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'customer_id',
        'order_code',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'amount',
        'payment_type',
        'status',
        'expires_at',
        'paid_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
