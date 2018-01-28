<?php

use Illuminate\Database\Seeder;

use App\HealthInsuranceCompany;

class HealthInsuranceCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE health_insurance_companies CASCADE');

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 16; $i++) {
            factory(HealthInsuranceCompany::class)->create();
        }

    }
}
