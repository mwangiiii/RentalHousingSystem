<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', 'amount', 'payment_date', 'due_date', 'status', 'user_id','payment_reason_id','transaction_id','failure_reason'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'due_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    
    public function paymentReason()
    {
        return $this->belongsTo(PaymentReason::class);
    }
}



