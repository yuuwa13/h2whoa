<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = 'sale_details';
    protected $primaryKey = 'sale_detail_id';
    protected $fillable = [
        'sale_id',
        'product_name',
        'quantity',
        'price_per_unit',
        'total_price',
    ];

    // Relationship with Sale
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'sale_id');
    }
}
