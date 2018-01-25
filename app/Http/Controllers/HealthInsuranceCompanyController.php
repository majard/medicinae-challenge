<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Response;
use Validator;

use App\HealthInsuranceCompany;

class HealthInsuranceCompanyController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    protected $rules =
    [
        'nome' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=150,height=150',
    ];

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
    public function store(Request $request)
    {                
   
        $validator = Validator::make(Input::all(), $this->rules);

        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {        
            $path = "nil";
            
            if (Input::hasFile('image')) {
                $path = "exists";
            }
            $health_insurance_company = new HealthInsuranceCompany;
            $health_insurance_company->nome = $request->nome;
            $health_insurance_company->status =  true;
            $path = $request->file('image')->store('test');
            $url = Storage::url($path);
            $health_insurance_company->logo = $url; 
            $health_insurance_company->save();

            return response()->json($health_insurance_company, 201);
        }
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

        return view('health_insurance_companies.show', ['health_insurance_company' => $health_insurance_company]);
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
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make(Input::all(), $this->rules);

        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $health_insurance_company = HealthInsuranceCompany::findOrFail($id);

            if(!$health_insurance_company) {
                return response()->json([
                    'message'   => 'Record not found',
                ], 404);
            }

            $health_insurance_company->nome = $request->nome;
            $health_insurance_company->cnpj = $request->cnpj;
            $health_insurance_company->user_id =  Auth::user()->id;
            $health_insurance_company->save();

            return response()->json($health_insurance_company, 201);
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
        
        $health_insurance_company = HealthInsuranceCompany::findOrFail($id);

        if(!$health_insurance_company) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $health_insurance_company->delete();

        return response()->json($health_insurance_company, 200);
    }
}
