<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClinic;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Response;

use App\Clinic;

class ClinicsController extends Controller
{    
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

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
     * @param  App\Http\Requests\StoreClinic  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClinic $request)
    {           
        $clinic = new Clinic;
        $clinic->nome = $request->nome;
        $clinic->cnpj = $request->cnpj;
        $clinic->user_id =  Auth::user()->id;
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
        
        $clinic = Clinic::findOrFail($id);
        
        if(!$clinic) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return view('clinics.show', ['clinic' => $clinic]);
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
     * @param  App\Http\Requests\StoreClinic  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClinic $request, $id)
    {

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
    
            return response()->json($clinic, 201);
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
            return response()->json($clinic, 200);
        }
        else {
            return response()->json([
                'message'   => 'User does not have authority to delete this clinic.',
            ], 403);
        }
    }
}
