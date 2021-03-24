<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotingVotingDaysTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-voting')->create('voting_days', function (Blueprint $table) {
            $table->id();
            $table->morphs('voting_dayable');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('type')->comment('ESTUDIANTE','DOCENTE');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-voting')->dropIfExists('voting_days');
    }
}
