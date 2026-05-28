<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'vehicle_id', 'driver_name', 'driver_phone',
        'origin', 'destination', 'cargo_description', 'weight_kg',
        'status', 'pickup_date', 'delivery_date', 'tracking_notes',
    ];

    protected $casts = [
        'pickup_date'   => 'date',
        'delivery_date' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'bg-yellow-100 text-yellow-800',
            'assigned'   => 'bg-blue-100 text-blue-800',
            'in_transit' => 'bg-indigo-100 text-indigo-800',
            'delivered'  => 'bg-green-100 text-green-800',
            'cancelled'  => 'bg-red-100 text-red-800',
            default      => 'bg-gray-100 text-gray-800',
        };
    }
}
