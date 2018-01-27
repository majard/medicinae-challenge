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
    
    public function testsClinicsAreCreatedCorrectly()
    {

        $user = factory(User::class)->create();

        Auth::login($user);

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


    public function testsClinicsAreUpdatedCorrectly()
    {
        
        $user = Auth::user();

        $token = $user->generateToken();
        
        $headers = ['Authorization' => "Bearer $token"];
        $clinic = factory(Clinic::class)->create([
            'nome' => 'First Clinic',
            'cnpj' => '1234567',
        ]);

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

    public function testsClinicsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();

        Auth::login($user);
        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        $clinic = factory(Clinic::class)->create([
            'nome' => 'First Clinic',
            'cnpj' => '5489498',
        ]);

        $this->json('DELETE', '/api/clinics/' . $clinic->id, [], $headers)
            ->assertStatus(204);
    }
    
    public function testClinicsAreListedCorrectly()
    {

     
        $user = factory(User::class)->create();

        Auth::login($user);
        $token = $user->generateToken();
        
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
}
