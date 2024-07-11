<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'rent', 
        'property_id',
        'description',
        'status',
    ];

    const STATUS_VACANT = 'vacant';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_BOOKED = 'booked';

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function isOccupied()
    {
        return $this->tenants()->exists();
    }
}