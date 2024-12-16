<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    protected $fillable = [
        'blood_sample_id',
        'receiver_id',
        'status',
    ];

    public function bloodSample()
    {
        return $this->belongsTo(BloodSample::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}