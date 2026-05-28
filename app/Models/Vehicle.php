<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'registration_plate', 'type', 'make', 'model', 'year', 'capacity_kg', 'status', 'notes'];

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'available'   => 'bg-green-100 text-green-800',
            'on_job'      => 'bg-blue-100 text-blue-800',
            'maintenance' => 'bg-red-100 text-red-800',
            default       => 'bg-gray-100 text-gray-800',
        };
    }
}
