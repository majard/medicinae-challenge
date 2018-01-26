<?php

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
    return view('home');  
})->name('home');

Route::get('/clinicas', 'ClinicsController@index')->name('clinics');

Route::get('/clinicas/{id}', 'ClinicsController@show')->name('show_clinic');

Route::put('/clinicas/{id}', 'ClinicsController@update')->name('update_clinic');

Route::delete('/clinicas/{id}', 'ClinicsController@destroy')->name('delete_clinic');

Route::get('/cadastro/clinica', 'ClinicsController@create')->name('display_clinic_signup');

Route::post('/cadastro/clinica', 'ClinicsController@store')->name('clinic_signup');

Route::get('/planos-de-saude', 'HealthInsuranceCompanyController@index')->name('health_insurance_companies');

Route::get('/planos-de-saude/{id}', 'HealthInsuranceCompanyController@show')->name('show_health_insurance_company');

Route::put('/planos-de-saude/{id}', 'HealthInsuranceCompanyController@update')->name('update_health_insurance_company');

Route::delete('/planos-de-saude/{id}', 'HealthInsuranceCompanyController@destroy')->name('delete_health_insurance_company');

Route::get('/cadastro/plano-de-saude', 'HealthInsuranceCompanyController@create')->name('display_health_insurance_company_signup');

Route::post('/cadastro/plano-de-saude', 'HealthInsuranceCompanyController@store')->name('health_insurance_company_signup');

Route::post('/relacionamento/{clinic_id}/{health_insurance_company_id}', 'ClinicsController@attach')->name('attach_health_insurance');

Route::delete('/relacionamento/{clinic_id}/{health_insurance_company_id}', 'ClinicsController@detach')->name('detach_health_insurance');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
