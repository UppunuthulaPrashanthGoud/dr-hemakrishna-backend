<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Customer extends Authenticatable
{
  
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded=['id'];
    protected $fillable = [
        /*fillable props*/
        'firstname',
        'lastname',
        'email',
        'country',
        'phone',
        'password'
    ];
    //
    protected $hidden=[
        /*Hidden props*/
    ];
    //
    protected $casts=[
        /*Your casts*/
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
}
