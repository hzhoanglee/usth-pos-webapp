<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'details' => 'json'
    ];
}
