<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['name', 'email', 'telephone'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
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

