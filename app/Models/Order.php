<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders'; // Specify the table name

    protected $primaryKey = 'order_id'; // Specify the primary key

    public $timestamps = true; // Enable timestamps

    protected $fillable = [
        'customer_id',
        'payment_method_id',
        'amount_paid',
        'order_datetime',
        'order_status', // Add this
    ];

    protected $casts = [
        'order_datetime' => 'datetime', // Ensure order_datetime is cast to a Carbon instance
    ];

    // Relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    // Relationship with OrderDetails
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    // Relationship with Sale
    public function sale()
    {
        return $this->hasOne(Sale::class, 'order_id', 'order_id');
    }

    // Calculate total price dynamically from order details
    public function calculateTotalPrice()
    {
        return $this->orderDetails->sum('total_price');
    }
}