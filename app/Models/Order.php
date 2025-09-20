<?php

namespace App\Models;

use App\Mail\OrderCompletedMail;
use App\Events\OrderStatusChanged;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status','order_tracking_id','payment_type','tax','subtotal','total','shipping_cost',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saved(function ($order) {
            if ($order->status === 'completed' && $order->wasChanged('status')) {
                event(new OrderStatusChanged($order));
            }
        });
        static::created(function ($order) {
            if ($order->status === 'completed' && $order->wasChanged('status')) {
                event(new OrderStatusChanged($order));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
