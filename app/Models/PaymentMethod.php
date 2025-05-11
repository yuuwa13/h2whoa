<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $primaryKey = 'payment_method_id';

    public $timestamps = false;

    protected $fillable = [
        'method_name',
    ];

    // Relationship with Order
    public function orders()
    {
        return $this->hasMany(Order::class, 'payment_method_id', 'payment_method_id');
    }
}