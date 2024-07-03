<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Lister extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'contact',
        'email',
        'identification_number',
        'password',
    ];

    /**
     * Define the user relationship.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the houses relationship.
     */
    public function houses()
    {
        return $this->hasMany(House::class);
    }
}
