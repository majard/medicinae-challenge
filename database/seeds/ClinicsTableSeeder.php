<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Clinic;

class ClinicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE clinics CASCADE');

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 42; $i++) {
            factory(Clinic::class)->create();
        }

    }
}
