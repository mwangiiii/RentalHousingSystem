<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'lister_id',
        'house_id',
        'hunter_id',
        'message',
        'is_read',
    ];

    public function lister()
    {
        return $this->belongsTo(Lister::class);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function hunter()
    {
        return $this->belongsTo(Hunter::class);
    }
}
