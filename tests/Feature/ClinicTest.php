<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Clinic;
use App\User;

class ClinicTest extends TestCase
{
    public function testClinicsAreListedCorrectly()
    {     
        $user = Auth::user();
        $token = $user->generateToken();

        DB::statement('TRUNCATE clinics CASCADE');

        factory(Clinic::class)->create([
            'nome' => 'First Clinic',
            'cnpj' => '988965'
        ]);

        factory(Clinic::class)->create([
            'nome' => 'Second Clinic',
            'cnpj' => '78984966'
        ]);

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/clinics', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 'nome' => 'First Clinic', 'cnpj' => '988965' ],
                [ 'nome' => 'Second Clinic', 'cnpj' => '78984966' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'cnpj', 'nome', 'created_at', 'updated_at'],
            ]);
    }

    public function testsClinicsAreCreatedCorrectly()
    {

        $user = Auth::user();
        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'nome' => 'Lorem',
            'cnpj' => '123456',
        ];

        $this->json('POST', '/api/clinics', $payload, $headers)
            ->assertStatus(201)
            ->assertJson(['user_id' => $user->id, 'nome' => 'Lorem', 'cnpj' => '123456']);
    }

    public function testsClinicsCreationConflicts()
    {

        $user = Auth::user();

        $token = $user->generateToken();

        $clinic = factory(Clinic::class)->create();

        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'nome' => $clinic->nome,
            'cnpj' => $clinic->cnpj,
        ];

        $this->json('POST', '/api/clinics', $payload, $headers)
            ->assertStatus(409)
            ->assertJson(['message' => 'This cnpj already exists in the database.' ]);
    }

    public function testSingleClinicsIsListedCorrectly()
    {     
        $user = Auth::user();
        $token = $user->generateToken();

        $clinic = Clinic::inRandomOrder()->first();

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/clinics/' . $clinic->id, [], $headers)
            ->assertStatus(200)
            ->assertJson([ 'nome' => $clinic->nome, 'cnpj' => $clinic->cnpj]);
    }    

    public function testsClinicsAreUpdatedCorrectly()
    {
        $clinic = Clinic::inRandomOrder()->first();

        $user = Auth::loginUsingId($clinic->user_id);
        $token = $user->generateToken();
        
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'nome' => 'Lorem',
            'cnpj' => '12345678',
        ];

        $response = $this->json('PUT', '/api/clinics/' . $clinic->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'user_id' => $user->id, 
                'nome' => 'Lorem', 
                'cnpj' => '12345678' 
            ]);
    }

    public function testsClinicsCantBeUpdatedByDifferentUser()
    {
        $clinic = Clinic::inRandomOrder()->first();

        $user = User::inRandomOrder()->where('id','!=', $clinic->user_id)->first();
        Auth::logout();

        Auth::login($user);
        $token = $user->generateToken();
        
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'nome' => 'Lorem',
            'cnpj' => '12345678',
        ];

        $response = $this->json('PUT', '/api/clinics/' . $clinic->id, $payload, $headers)
            ->assertStatus(403)
            ->assertJson(['message'   => 'User does not have authority to edit this clinic.',]);
    }

    public function testsClinicsUpdateConflicts()
    {
        $clinics = Clinic::orderBy('cnpj', 'asc');
        $first_clinic = $clinics->first();
        $second_clinic = $clinics->where('cnpj','!=', $first_clinic->cnpj)->first();

        $user = Auth::user();
        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'nome' => $first_clinic->nome,
            'cnpj' => $second_clinic->cnpj,
        ];

        $response = $this->json('PUT', '/api/clinics/' . $first_clinic->id, $payload, $headers)
            ->assertStatus(409)
            ->assertJson(['message' => 'This cnpj already exists in the database.' ]);
    }

    public function testsClinicsAreDeletedCorrectly()
    {
        $clinic = Clinic::inRandomOrder()->first();

        $user = Auth::loginUsingId($clinic->user_id);

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        $this->json('DELETE', '/api/clinics/' . $clinic->id, [], $headers)
            ->assertStatus(204);
    }
}
