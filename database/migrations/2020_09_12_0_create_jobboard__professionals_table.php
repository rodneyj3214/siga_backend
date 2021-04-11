<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardProfessionalsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-job-board')->create('professionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('authentication.users');
            $table->boolean('has_travel')->default(false);
            $table->boolean('has_disability')->default(false);
            $table->boolean('has_familiar_disability')->default(false);
            $table->boolean('identification_familiar_disability')->default(false);
            $table->boolean('has_catastrophic_illness')->default(false);
            $table->boolean('has_familiar_catastrophic_illness')->default(false);
            $table->text('about_me')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('professionals');
    }
}
