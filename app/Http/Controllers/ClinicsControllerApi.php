<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClinic;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Response;

use App\Clinic;
use App\HealthInsuranceCompany;

class ClinicsControllerApi extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clinics = Clinic::orderBy('nome', 'asc')->with('health_insurance_companies')->get();

        return response()->json($clinics, 200);
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreClinic  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClinic $request)
    {           

        if(Clinic::where('cnpj', '=', Input::get('cnpj'))->exists()) {
            return response()->json([
                'message'   => 'This cnpj already exists in the database.',
            ], 409);
        }

        $clinic = new Clinic;
        $clinic->nome = $request->nome;
        $clinic->cnpj = $request->cnpj;
        $clinic->user_id =  Auth::guard('api')->id();
        $clinic->save();

        return response()->json($clinic, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $clinic = Clinic::with('health_insurance_companies')->findOrFail($id);
        
        if(!$clinic) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json($clinic, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreClinic  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClinic $request, $id)
    {
        if(Clinic::where('cnpj', '=', Input::get('cnpj'))->exists()) {
            return response()->json([
                'message'   => 'This cnpj already exists in the database.',
            ], 409);
        }

        $clinic = Clinic::findOrFail($id);

        if(!$clinic) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        
        if ($clinic->user_id == Auth::user()->id) {            
            
            $clinic->nome = $request->nome;
            $clinic->cnpj = $request->cnpj;
            $clinic->user_id =  Auth::user()->id;
            $clinic->save();
    
            return response()->json($clinic, 200);
        }
        else {
            return response()->json([
                'message'   => 'User does not have authority to edit this clinic.',
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        
        $clinic = Clinic::findOrFail($id);

        if(!$clinic) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }


        if ($clinic->user_id == Auth::user()->id) {            

            $clinic->delete();
            return response()->json($clinic, 204);
        }
        else {
            return response()->json([
                'message'   => 'User does not have authority to delete this clinic.',
            ], 403);
        }
    }


    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attach($clinic_id, $health_insurance_company_id)
    {
        //
        
        $clinic = Clinic::findOrFail($clinic_id);
        $health_insurance_company = HealthInsuranceCompany::findOrFail($health_insurance_company_id);

        if(!$clinic || !$health_insurance_company) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }
        
        if(!$health_insurance_company->status) {
            return response()->json([
                'message'   => 'Health Insurance Company is not active!',
            ], 409);
        }

        if ($clinic->user_id == Auth::user()->id) {
            $clinic->health_insurance_companies()->attach($health_insurance_company_id);
            return response()->json($clinic, 201);
            
        }
        else {
            return response()->json([
                'message'   => 'User does not have authority to delete this relationshionship.',
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detach($clinic_id, $health_insurance_company_id)
    {
        //
        
        $clinic = Clinic::findOrFail($clinic_id);
        $health_insurance_company = HealthInsuranceCompany::findOrFail($health_insurance_company_id);

        if(!$clinic || !$health_insurance_company) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }


        if ($clinic->user_id == Auth::user()->id) {            

            $clinic->health_insurance_companies()->detach($health_insurance_company_id);
            return response()->json($clinic, 200);
        }
        else {
            return response()->json([
                'message'   => 'User does not have authority to delete this relationship.',
            ], 403);
        }
    }
}
