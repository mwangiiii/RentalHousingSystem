<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', 'description', 'status'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
