<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details'; // Specify the table name

    protected $primaryKey = 'order_detail_id'; // Specify the primary key

    public $timestamps = false; // Disable timestamps

    protected $fillable = [
        'order_id',
        'stock_id',
        'quantity',
        'total_price',
    ];

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // Relationship with Stock
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'stock_id');
    }
}