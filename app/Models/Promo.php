<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promo';
    protected $fillable = ['name', 'code', 'description', 'image', 'is_active'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'promo_id');
    }
}
