<?php

namespace App\Models\Admin\V1;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generateOrderID();
            }
        });
    }

    public static function generateOrderID()
    {
        $letters = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));
        $numbers = mt_rand(1, 999999);
        return $letters . str_pad($numbers, 6, '0', STR_PAD_LEFT);
    }

    public function getPaymentMethodLabel(): string
    {
        return match ($this->transactions?->mode) {
            'cod' => 'Paying Cash on Delivery',
            'paypal' => 'Paid with Paypal',
            default => 'Paid with debit card',
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
