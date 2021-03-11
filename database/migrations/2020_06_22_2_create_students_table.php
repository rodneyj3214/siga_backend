<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-app')->create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('authentication.users');
            $table->foreignId('location_id')->constrained('address');
            $table->foreignId('school_type_id')->constrained('catalogues');
            $table->date('career_start_date')->nullable();
            $table->year('graduation_year')->nullable();
            $table->string('cohort')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('students');
    }
}
