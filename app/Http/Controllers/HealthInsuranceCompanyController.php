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

class HealthInsuranceCompanyController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['index']]);
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
        $health_insurance_companies = HealthInsuranceCompany::orderBy('nome', 'asc')->get();
    
        return view('health_insurance_companies.index', [
            'health_insurance_companies' => $health_insurance_companies
        ]);
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('health_insurance_companies.create');
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
        $health_insurance_company = new HealthInsuranceCompany;
        $health_insurance_company->nome = $request->nome;

        if ($request->has('status')) {
            $status = true;
        }
        else {
            $status = false;
        }
        $health_insurance_company->status = $status;            

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
        
        if(!$health_insurance_company) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }
        
        $url = Storage::url($health_insurance_company->logo);

        return view('health_insurance_companies.show', ['logo_url' => $url, 'health_insurance_company' => $health_insurance_company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        if(!$health_insurance_company) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $health_insurance_company->nome = $request->nome;
        
        if ($request->has('status')) {
            $status = true;
        }
        else {
            $status = false;
        }

        $health_insurance_company->status = $status;            

        $path = $health_insurance_company->logo;

        if(Storage::disk('s3')->exists($path) && Input::hasFile('image')) {
            Storage::disk('s3')->delete($path);
        }

        $filePath = $this->uploadToS3($request, $health_insurance_company);
        $health_insurance_company->logo = $filePath; 

        $health_insurance_company->save();

        return response()->json($health_insurance_company, 201);
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
