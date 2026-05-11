<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'file_path', 'bank', 'operation_number', 'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
