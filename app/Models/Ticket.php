<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'is_active'
    ];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'ticket_id');
    }
}
