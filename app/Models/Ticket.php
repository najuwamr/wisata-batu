<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';

    protected $fillable = [
        'order_id',
        'customer_id',
        'ticket_type_id',
        'token',
        'status',
        'scanned_at',
    ];
}
