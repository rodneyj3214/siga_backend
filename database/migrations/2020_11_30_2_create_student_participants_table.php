<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('student_participants', function (Blueprint $table) {
            $table->id();
            $table->boolean('state')->default(true);
            $table->foreignId('student_id')->connstrained('app.student');
            $table->foreignId('project_id')->connstrained();
            //$table->string('degree',100); //titulo va en la fk
            $table->text('funtion_id')->constrained('app.catalogues');//fk de catalogues
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_participants');
    }
}
