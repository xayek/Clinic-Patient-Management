<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
}
