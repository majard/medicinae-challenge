<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['cnpj', 'nome'];
    
    public function health_insurance_companies()
    {
        return $this->belongsToMany('App\HealthInsuranceCompany');
    }
}
