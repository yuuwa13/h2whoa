<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks'; // Specify the table name

    protected $primaryKey = 'stock_id'; // Specify the primary key

    public $timestamps = true;

    protected $fillable = [
        'product_name',
        'quantity',
        'price_per_unit',
    ];

    // Relationship with OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'stock_id', 'stock_id');
    }
}