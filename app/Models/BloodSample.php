<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodSample extends Model
{
    protected $fillable = [
        'hospital_id',
        'blood_type',
        'quantity',
    ];

    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }

    public function requests()
    {
        return $this->hasMany(BloodRequest::class);
    }
}