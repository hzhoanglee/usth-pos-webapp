<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ['started_date', 'expired_date'];
}
