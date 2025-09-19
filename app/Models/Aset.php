<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aset extends Model
{
    use HasFactory;

    protected $table = 'aset';
    protected $fillable = [
        'name',
        'category',
        'image',
        'description'
    ];
}
