<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_id',
        'move_in_date',
        'lease_duration',
        'number_of_occupants',
        'employment_status',
        'contact_method',
        'message',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
