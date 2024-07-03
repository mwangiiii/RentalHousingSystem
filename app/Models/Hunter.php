<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hunter extends Model
{
    use HasFactory;

    protected $table = 'hunter'; // Explicitly specifying the table name
    
    protected $fillable = [
        'user_id',
        'name',
        'contact',
        'email',
        'identification_number',
        'password',
        'role_id',
    ];

    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
