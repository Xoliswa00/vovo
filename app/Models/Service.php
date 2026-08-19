<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'icon', 'status', 'category_id', 'vendor_id', 'price', 'location'];

    public function images()
    {
        return $this->hasMany(services_img::class, 'services_id')->orderByDesc('is_primary')->orderBy('id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function avgRating(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}
