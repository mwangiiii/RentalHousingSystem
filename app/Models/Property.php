<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'units',
        'description',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function maintenanceWorkers()
    {
        return $this->hasManyThrough(User::class, Role::class, 'property_id', 'role_id', 'id', 'id')
            ->where('roles.role_name', 'Maintenance Worker');
    }
}

