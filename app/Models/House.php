<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'price',
        'description',
        'availability',
        'contact',
        'rules_and_regulations',
        'amenities',
        'user_id',
        'lister_id', // Make sure 'lister_id' is correctly listed in fillable array
        'category_id', // Corrected field name to match database schema
        'main_image', // Ensure this matches the actual field name in your database
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function lister()
    {
        return $this->belongsTo(User::class, 'lister_id');
    }
    
    public function mainImage()
    {
        return $this->hasOne(Image::class)->whereNotNull('is_main');
    }

    public function category()
    {
        return $this->belongsTo(Category::class); // Ensure correct relationship method name
    }
}
