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
        'tanggal_kedatangan',
        'midtrans_order_id',
        'midtrans_tr_id',
        'total_price',
        'status',
        'customer_id',
        'payment_methode_id',
        'synced_to_sheets',
        'spreadsheet_id',
    ];

    protected $casts = [
        'id' => 'string',
        'tanggal_kedatangan' => 'datetime',
        'synced_to_sheets' => 'boolean',
        'total_price' => 'integer',
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

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }
}
