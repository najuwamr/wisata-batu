<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promo';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['name', 'code', 'discount_percent', 'qty', 'valid_until', 'description', 'image', 'is_active'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'promo_id');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
