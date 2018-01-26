<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $fillable = ['cnpj', 'nome'];
    
    public function health_insurance_companies()
    {
        return $this->belongsToMany('App\HealthInsuranceCompany');
    }
}
