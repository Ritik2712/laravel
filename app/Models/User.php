<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'address',
        'state',
        'blood_group',
        'image_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function bloodSamples()
    {
        return $this->hasMany(BloodSample::class, 'hospital_id');
    }

    public function bloodRequests()
    {
        return $this->hasMany(BloodRequest::class, 'receiver_id');
    }
}