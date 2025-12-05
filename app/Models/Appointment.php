<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'mobile',
        'email',
        'selected_date',
        'selected_time',
        'reason',
        'message',
        'status',
        'payment_method', // online or offline
        'payment_status', // pending, completed, failed, unpaid
        'transaction_id', // for online payments
        'amount'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'selected_date' => 'date',
        'selected_time' => 'string'
    ];

    // Accessor to format the appointment date and time
    public function getAppointmentDateTimeAttribute()
    {
        return $this->selected_date->format('d M Y') . ' at ' . $this->selected_time;
    }

    // Scope to get paid appointments
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'completed');
    }

    // Scope to get unpaid appointments
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'unpaid');
    }

    // Scope to get confirmed appointments
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
}