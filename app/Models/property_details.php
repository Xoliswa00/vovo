<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class property_details extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyDetailsFactory> */
    use HasFactory;
        protected $fillable = [
        'title', 'description', 'price', 'address', 'city', 'state', 'country',
        'bedrooms', 'bathrooms', 'garage', 'parking_spaces',
        'property_type', 'status','size'
    ];

    public function images()
    {
        return $this->hasMany(propert_img::class, 'property_id');
    }
}
