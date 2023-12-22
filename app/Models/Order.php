<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'cashier_id', '_id');
    }

    public function client()
    {
        return $this->belongsTo(Customer::class, 'customer_id', '_id');
    }



}
