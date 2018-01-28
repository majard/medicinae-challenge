<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/', function () {
    return response()->json(['message' => 'Medicinae API', 'status' => 'Connected']);;
});

Route::resource('clinics', 'ClinicsControllerApi');
Route::resource('health_insurance_companies', 'HealthInsuranceCompaniesControllerApi');

Route::post('register', 'Auth\RegisterController@registerApi');
Route::post('login', 'Auth\LoginController@loginApi');
Route::post('logout', 'Auth\LoginController@logoutApi');

Route::post('/attach/{clinic_id}/{health_insurance_company_id}', 'ClinicsControllerApi@attach')->name('attach_health_insurance');
Route::delete('/detach/{clinic_id}/{health_insurance_company_id}', 'ClinicsControllerApi@detach')->name('detach_health_insurance');