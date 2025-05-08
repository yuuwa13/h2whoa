<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks'; // Specify the table name

    protected $primaryKey = 'stock_id'; // Specify the primary key

    public $timestamps = true; // Enable timestamps

    protected $fillable = [
        'product_name',
        'quantity',
        'price_per_unit',
        'is_available',
        'is_quantifiable', // Added is_quantifiable to fillable attributes
        'maximum_orders_allowed', // Added maximum_orders_allowed to fillable attributes
    ];

    protected $attributes = [
        'maximum_orders_allowed' => 0, // Default value for maximum_orders_allowed
    ];

    // Relationship with OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'stock_id', 'stock_id');
    }

    public function getIsAvailableAttribute($value)
    {
        // Respect the `is_available` value for non-quantifiable stocks
        return $this->is_quantifiable ? $value : $this->attributes['is_available'];
    }

    public function isInfinite(): bool
    {
        return !$this->is_quantifiable;
    }

    public function getEffectiveQuantityAttribute()
    {
        // If not quantifiable, use maximum_orders_allowed as the effective quantity
        return $this->is_quantifiable ? $this->quantity : $this->maximum_orders_allowed;
    }

    public function getQuantityAttribute($value)
    {
        // If not quantifiable, return maximum_orders_allowed as the quantity
        return $this->is_quantifiable ? $value : $this->maximum_orders_allowed;
    }
}