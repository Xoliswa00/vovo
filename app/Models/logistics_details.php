<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logistics_details extends Model
{
    /** @use HasFactory<\Database\Factories\LogisticsDetailsFactory> */
    use HasFactory;
       protected $fillable = ['property_id', 'path'];

}
