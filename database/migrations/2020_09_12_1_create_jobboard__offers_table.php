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
            $table->foreignId('address_id')->constrained('app.address');
            $table->string('code');
            $table->string('contact');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('position');
            $table->string('training_hours')->nullable();
            $table->string('experience_time')->nullable();
            $table->string('remuneration')->nullable();
            $table->string('working_day')->nullable();
            $table->string('number_jobs')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->json('activities');
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
