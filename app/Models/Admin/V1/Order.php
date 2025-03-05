<?php

namespace App\Models\Admin\V1;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    public function getPaymentMethodLabel(): string
    {
        return match ($this->transactions->mode) {
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
