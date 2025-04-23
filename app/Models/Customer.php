<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; // Specify the table name

    protected $primaryKey = 'customer_id'; // Specify the primary key

    protected $fillable = [
        'name',
        'email',
        'phone',
        'is_deleted', // Soft delete flag
    ];

    // Relationship with Orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}