<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services_img extends Model
{
    /** @use HasFactory<\Database\Factories\ServicesImgFactory> */
    use HasFactory;
      protected $fillable = ['services_id', 'image_path', 'is_primary'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'services_id');
    }
}
