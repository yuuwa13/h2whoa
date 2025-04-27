<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerEditLog extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'customer_id', 'field', 'old_value', 'new_value', 'changed_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
