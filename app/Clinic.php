<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    
    public function health_insurance_companies()
    {
        return $this->belongsToMany('App\HealthInsuranceCompany');
    }
}
