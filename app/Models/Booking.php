<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_id', // Foreign key
        'name',
        'phone_number',
        'email',
        'check_in_date',
        'status',
        'payment_status',
        'payment_method',
        'transaction_id',
        'additional_notes',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
