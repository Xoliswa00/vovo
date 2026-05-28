<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'business_name', 'description', 'logo_path', 'phone', 'address', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(services::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
