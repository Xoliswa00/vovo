<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name', 'client_email', 'client_phone',
        'origin', 'destination', 'cargo_description',
        'weight_kg', 'preferred_date', 'status', 'admin_notes', 'quoted_price',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'quoted_price'   => 'decimal:2',
    ];

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'bg-yellow-100 text-yellow-800',
            'quoted'   => 'bg-blue-100 text-blue-800',
            'accepted' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default    => 'bg-gray-100 text-gray-800',
        };
    }
}
