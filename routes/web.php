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
    return view('clinics');

});Route::get('/planos-de-saude', function () {
    return view('health_insurance');
});
Route::post('/cadastro/clinica', function (Request $request) {
    
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
