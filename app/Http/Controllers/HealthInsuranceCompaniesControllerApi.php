<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHealthInsuranceCompany;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Filesystem\Filesystem;

use Response;

use App\HealthInsuranceCompany;

class HealthInsuranceCompaniesControllerApi extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    protected function uploadToS3($request, $health_insurance_company) {
        $image = $request->file('image');
        $imageFileName = $health_insurance_company->nome . time() . '.' . $image->getClientOriginalExtension();
        $s3 = \Storage::disk('s3');
        $filePath = '/logos/' . $imageFileName;
        $s3->put($filePath, file_get_contents($image), 'public');
        return $filePath;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $health_insurance_companies = HealthInsuranceCompany::orderBy('id', 'asc')->get();
    
        return response()->json($health_insurance_companies, 200);

        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHealthInsuranceCompany $request)
    {    
        if (HealthInsuranceCompany::where('nome', $request->nome)->exists()) {            
            return response()->json([
                'message'   => 'This name already exists in the database.',
            ], 409);
        }

        $health_insurance_company = new HealthInsuranceCompany;
        $health_insurance_company->nome = $request->nome;

        $health_insurance_company->status = $request->status;        

        $filePath = $this->uploadToS3($request, $health_insurance_company);
        $health_insurance_company->logo = $filePath; 
        
        $health_insurance_company->save();

        return response()->json($health_insurance_company, 201);
        //
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
        $health_insurance_company = HealthInsuranceCompany::findOrFail($id);

        return response()->json($health_insurance_company, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreHealthInsuranceCompany $request, $id)
    {
        $health_insurance_company = HealthInsuranceCompany::findOrFail($id);

        $same_name_co = HealthInsuranceCompany::where('nome', $request->nome)->first();
        if ($same_name_co && $same_name_co->id != $health_insurance_company->id ) {                
            return response()->json([
                'message'   => 'This name already exists in the database.',
            ], 409);
        }

        $health_insurance_company->nome = $request->nome;

        $health_insurance_company->status = $request->status;            

        $path = $health_insurance_company->logo;

        if(Storage::disk('s3')->exists($path) && Input::hasFile('image')) {
            Storage::disk('s3')->delete($path);
        }

        $filePath = $this->uploadToS3($request, $health_insurance_company);
        $health_insurance_company->logo = $filePath; 

        $health_insurance_company->save();

        return response()->json($health_insurance_company, 200);
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
        
        $health_insurance_company = HealthInsuranceCompany::findOrFail($id);

        if(!$health_insurance_company) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $path = $health_insurance_company->logo;

        if(Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
        }

        $health_insurance_company->delete();

        return response()->json($health_insurance_company, 200);
    }
}
