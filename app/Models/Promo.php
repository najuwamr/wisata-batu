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
    protected $fillable = ['name', 'code', 'discount_percent', 'total_qty', 'used_qty','daily_qty', 'start_date', 'end_date', 'max_disc_amount', 'image', 'is_active', 'category'];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'tiket_promo', 'promo_id', 'ticket_id');
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
