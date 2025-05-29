<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'order_code',
        'total_amount',
        'status',
        'shipping_address',
        'payment_method',
        'installment_plan',
    ];

    // Definisikan relasi di sini
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
