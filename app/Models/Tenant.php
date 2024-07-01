<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'property_id', 'room_id', 'lease_start', 'lease_end','move_in_date',
        'move_out_date'
    ];

    protected $casts = [
        'lease_start' => 'date',
        'lease_end' => 'date',
        'move_in_date' => 'date',
        'move_out_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}



