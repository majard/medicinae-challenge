<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicHealthInsuranceCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('clinic_health_insurance_company', function (Blueprint $table) {

            $table->integer('clinic_id')->unsigned();
            $table->foreign('clinic_id')
            ->references('id')->on('clinics')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->integer('health_insurance_company_id')->unsigned();
            $table->foreign('health_insurance_company_id')
            ->references('id')->on('health_insurance_companies')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
        Schema::dropIfExists('clinic_health_insurance_company');
    }
}
