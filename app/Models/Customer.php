<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    public $timestamps = true;

    // include password here so Auth can fill it
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'password',
        'is_deleted',
    ];

    // hide password & remember_token if we add one later
    protected $hidden = [
        'password',
    ];

    public function editLogs()
    {
        return $this->hasMany(CustomerEditLog::class, 'customer_id', 'customer_id')
                    ->orderByDesc('changed_at');
    }


    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
