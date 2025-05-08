<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales'; // Specify the table name

    protected $primaryKey = 'sale_id'; // Specify the primary key

    protected $fillable = [
        'order_id',
        'sale_type',
        'unique_sale_id', // Ensure unique_sale_id is fillable
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            $prefix = strtoupper(substr($sale->sale_type, 0, 3)); // Generate prefix based on sale type
            $latestSale = self::where('sale_type', $sale->sale_type)->latest('sale_id')->first();
            $nextId = $latestSale ? ((int) str_replace($prefix . '-', '', $latestSale->unique_sale_id) + 1) : 1;
            $sale->unique_sale_id = $prefix . '-' . $nextId;
        });
    }

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // Relationship with SaleDetail
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id', 'sale_id');
    }
}
