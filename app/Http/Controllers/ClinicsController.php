<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Response;
use Validator;

use App\Clinic;

class ClinicsController extends Controller
{
    protected $rules =
    [
        'nome' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clinics = Clinic::orderBy('nome', 'asc')->get();
    
        return view('clinics.index', [
            'clinics' => $clinics
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
        return view('clinics.create');
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

            $clinic = new Clinic;
            $clinic->nome = $request->nome;
            $clinic->cnpj = $request->cnpj;
            $clinic->user_id =  Auth::user()->id;
            $clinic->save();

            return response()->json($clinic);
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
        
        $clinic = Clinic::findOrFail($id);

        return view('clinic.show', ['clinic' => $clinic]);
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

            $clinic = Clinic::findOrFail($id);

            $clinic->nome = $request->nome;
            $clinic->cnpj = $request->cnpj;
            $clinic->user_id =  Auth::user()->id;
            $clinic->save();

            return response()->json($clinic);
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
        $clinic->delete();

        return response()->json($clinic);
    }
}
