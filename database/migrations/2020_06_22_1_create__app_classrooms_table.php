<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppClassroomsTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-app')->create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->string('name', 500);
            $table->foreignId('type_id')->constrained('catalogues');
            $table->string('icon', 200)->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('classrooms');
    }
}
