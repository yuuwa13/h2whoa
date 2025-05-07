<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcashDetail extends Model
{
    use HasFactory;

    protected $table = 'gcash_details';

    protected $fillable = [
        'name',
        'reference_number',
        'image',
    ];
}