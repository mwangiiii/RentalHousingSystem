<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Houses relationship: One category can have many houses.
     */
    public function houses()
    {
        return $this->hasMany(House::class);
    }
}
