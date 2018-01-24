<?php


use App\Clinic;
use App\HealthInsuranceCompany;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');  
    
   
});

Route::get('/clinicas', function () {
    $clinics = Clinic::orderBy('nome', 'asc')->get();

    return view('clinics', [
        'clinics' => $clinics
    ]);

})->name('clinics');

Route::get('/planos-de-saude', function () {
    $health_insurance_companies = HealthInsuranceCompany::orderBy('nome', 'asc')->get();

    return view('health_insurance', [
        'health_insurance_companies' => $health_insurance_companies
    ]);
})->name('health_insurance_signup');


Route::get('/cadastro/clinica', function (Request $request) {
    return view('clinic_signup');

})->name('display_clinic_signup');

Route::post('/cadastro/clinica', function (Request $request) {    
    
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
    
        $clinic = new Clinic;
        $clinic->nome = $request->nome;
        $clinic->cnpj = $request->cnpj;
        $clinic->user_id =  Auth::user()->id;
        $clinic->save();
    
        return redirect('/');
        //
    })->name('clinic_signup');

    $clinic = new Clinic;
    $clinic->nome = $request->nome;
    $clinic->cnpj = $request->cnpj;
    $clinic->user_id =  Auth::user()->id;
    $clinic->save();

    return redirect('/');
    //
})->name('clinic_signup');

Route::post('/cadastro/plano-de-saude', function (Request $request) {
    //
})->name('health_insurance_signup');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
