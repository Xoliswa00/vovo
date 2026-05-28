<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services extends Model
{
    /** @use HasFactory<\Database\Factories\ServicesFactory> */
    use HasFactory;
      protected $fillable = ['title', 'description', 'icon', 'status'];

    public function images()
    {
        return $this->hasMany(services_img::class);
    }
}
