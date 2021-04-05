<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardProfessionalExperiencesTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-job-board')->create('professional_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('job_board.professionals');;
            $table->string('employer');
            $table->string('position');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('reason_leave')->nullable();
            $table->boolean('current_work')->default(false);
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('professional_experiences');
    }
}
