<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethode extends Model
{
    use HasFactory;

    protected $table = 'payment_methode';
    protected $fillable = ['type'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'payment_methode_id');
    }
}
