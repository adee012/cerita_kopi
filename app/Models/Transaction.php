<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'user_name',
        'email',
        'address',
        'amount',
        'status',
        'snap_token'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
