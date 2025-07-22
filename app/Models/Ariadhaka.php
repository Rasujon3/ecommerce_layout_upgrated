<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ariadhaka extends Model
{
    use HasFactory;

    protected $table = 'ariadhakas';

    protected $fillable = [
        'user_id',
        'division',
        'area_name',
        'area_type',
        'status',
        'delivery_charges',
    ];
}
