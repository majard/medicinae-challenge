<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

use App\Clinic;
use App\HealthInsuranceCompany;
use App\User;


define('LOGO_1', 'LOGO1');
define('LOGO_2', 'LOGO2');
define('COMPANY_NAME', 'HIC');
define('WIDTH', 150);
define('HEIGHT', 150);

class HealthInsuranceCompanyTest extends TestCase
{
    public function testHealthInsuranceCompaniesAreListedCorrectly()
    {     
        $user = Auth::user();
        $token = $user->generateToken();

        DB::statement('TRUNCATE health_insurance_companies CASCADE');

        $hic_1 = factory(HealthInsuranceCompany::class)->create();
        $hic_2 = factory(HealthInsuranceCompany::class)->create();        

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/health_insurance_companies', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 'nome' => $hic_1->nome, 'logo' => $hic_1->logo, 'status' => $hic_1->status],
                [ 'nome' => $hic_2->nome, 'logo' => $hic_2->logo, 'status' => $hic_2->status],
            ])
            ->assertJsonStructure([
                '*' => ['id', 'logo', 'nome', 'status', 'created_at', 'updated_at'],
            ]);

    }

    public function testHealthInsuranceCompaniesAreCreatedCorrectly()
    {     
        $user = Auth::user();
        $token = $user->generateToken();

        Storage::fake();

        $payload = [
            'nome' => COMPANY_NAME,
            'image' => UploadedFile::fake()->image('logo.jpg', WIDTH, HEIGHT),
            'status' => true,
        ];

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('POST', '/api/health_insurance_companies', $payload, $headers)
            ->assertStatus(201)
            ->assertJson(['nome' => COMPANY_NAME, 'status' => true,]);

        $hic = HealthInsuranceCompany::where('nome', COMPANY_NAME)->first();

        Storage::disk()->assertExists($hic->logo);
    }

    public function testSingleHealthInsuranceCompanyIsListedCorrectly()
    {     
        $user = Auth::user();
        $token = $user->generateToken();

        $hic = HealthInsuranceCompany::inRandomOrder()->first();

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/health_insurance_companies/' . $hic->id, [], $headers)
            ->assertStatus(201)
            ->assertJson(['nome' => $hic->nome, 'status' => $hic->status, 'logo' => $hic->logo]);
    }

    public function testHealthInsuranceCompanyNotFound()
    {     
        $user = Auth::user();
        $token = $user->generateToken();

        $hic = HealthInsuranceCompany::inRandomOrder()->first();
        $hic->delete();

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/health_insurance_companies/' . $hic->id, [], $headers)
            ->assertStatus(404)
            ->assertJson([ 'message'   => 'No query results for model [App\HealthInsuranceCompany] ' . $hic->id]);
    }

    public function testHealthInsuranceCompaniesAreUpdatedCorrectly()
    {     
        $user = Auth::user();
        $token = $user->generateToken();

        $hic = HealthInsuranceCompany::inRandomOrder()->first();

        Storage::fake();

        $payload = [
            'nome' => COMPANY_NAME,
            'image' => UploadedFile::fake()->image('logo.jpg', WIDTH, HEIGHT),
            'status' => true,
        ];

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('PUT', '/api/health_insurance_companies/' . $hic->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson(['nome' => COMPANY_NAME, 'status' => true,]);

        $hic->refresh();
        Storage::disk()->assertExists($hic->logo);
    }


    public function testHealthInsuranceCompaniesAreDeleteddCorrectly()
    {     
        $user = Auth::user();
        $token = $user->generateToken();

        $hic = HealthInsuranceCompany::inRandomOrder()->first();

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('DELETE', '/api/health_insurance_companies/' . $hic->id, [], $headers)
            ->assertStatus(200);

        Storage::disk()->assertMissing($hic->logo);
    }
}
