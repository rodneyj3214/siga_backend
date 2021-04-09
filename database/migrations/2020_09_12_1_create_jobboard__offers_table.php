<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardOffersTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-job-board')->create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('job_board.companies');
            $table->foreignId('contract_type_id')->constrained('app.catalogues');
            $table->foreignId('location_id')->constrained('app.locations');
            $table->foreignId('position_id')->constrained('app.catalogues');
            $table->foreignId('sector_id')->constrained('app.catalogues');
            $table->foreignId('working_day_id')->constrained('app.catalogues');
            $table->foreignId('experience_time_id')->constrained('app.catalogues');
            $table->foreignId('training_hours_id')->constrained('app.catalogues');
            $table->foreignId('status_id')->constrained('app.status');
            $table->string('code');
            $table->string('description');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->string('contact_cell_phone')->nullable();
            $table->string('remuneration')->nullable();
            $table->integer('vacancies')->comment('total de puestos disponibles')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->json('activities');
            $table->json('requirements');
            $table->text('aditional_information')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('offers');
    }
}
