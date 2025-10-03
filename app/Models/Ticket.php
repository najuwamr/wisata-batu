<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'is_active'
    ];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'ticket_id');
    }

    public function promo()
    {
        return $this->belongsToMany(Promo::class, 'ticket_promo', 'ticket_id', 'promo_id');
    }

    public function aset()
    {
        return $this->belongsToMany(Aset::class, 'aset_tiket', 'aset_id', 'ticket_id');
    }

    public function getShortNameAttribute()
    {
        return str_replace('Tiket ', '', $this->name);
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
