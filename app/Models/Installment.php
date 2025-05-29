<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'due_date',
        'is_paid',
        'paid_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
    ];

    // Definisikan relasi di sini
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
