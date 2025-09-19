<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'midtrans_order_id',
        'midtrans_tr_id',
        'customer_id',
        'payment_methode_id',
        'status_transaction_id',
        'total_price',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethode::class, 'payment_methode_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusTransaction::class, 'status_transaction_id');
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }
}
