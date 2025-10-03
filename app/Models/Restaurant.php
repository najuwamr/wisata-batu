<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;

    protected $table = 'restaurant';
    protected $fillable = ['name', 'description', 'image', 'is_active'];

    public function menu()
    {
        return $this->hasMany(Menu::class, 'restaurant_id');
    }
}

