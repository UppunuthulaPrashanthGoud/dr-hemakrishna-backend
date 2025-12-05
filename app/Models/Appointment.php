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
        'payment_status', // pending, completed, failed
        'transaction_id', // for online payments
        'amount'
    ];
}