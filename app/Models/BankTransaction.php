<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class BankTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];
}
