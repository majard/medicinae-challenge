<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsSoftDeleteToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('clinics', function ($table) {
            $table->softDeletes();
        });
        Schema::table('health_insurance_companies', function ($table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('clinics', function ($table) {
            $table->dropSoftDeletes();
        });

        Schema::table('
        health_insurance_companies', function ($table) {
            $table->dropSoftDeletes();
        });
    }
}
