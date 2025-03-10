<?php

namespace App\Models\Admin\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

        public function checkStatus(): string
    {
        return match ($this->status) {
            'approved' => '<span class="badge bg-success">Approved</span>',
            'declined' => '<span class="badge bg-danger">Declined</span>',
            'refunded' => '<span class="badge bg-danger">Refunded</span>',
            default => '<span class="badge bg-info">Pending</span>',
        };
    }
 public function order(): BelongsTo
 {
     return $this->belongsTo(Order::class);
 }


}
