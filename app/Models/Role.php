<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name',
        'property_id'
    ];

    public $timestamps = true;

    //User Role Relationship

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
    public function listers()
    {
        return $this->hasMany(Lister::class);
    }
}
