<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Aset extends Model
{
    use HasFactory;

    protected $table = 'aset';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'category',
        'image',
        'description'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
