<?php

use Illuminate\Support\Facades\Auth;
use App\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(App\Clinic::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\pt_BR\Company($faker));

    $user = User::inRandomOrder()->first();
    Auth::login($user);

    return [
        'nome' => $faker->company,
        'cnpj' => $faker->unique()->cnpj(false),
        'user_id' => $user->id,
    ];
});