<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotingVotesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-voting')->create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('public.users');
            $table->foreignId('voting_day_id')->constrained('public.voting_days');
            $table->integer('answer');
            $table->time('time');
            $table->unique(['user_id', 'time']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-voting')->dropIfExists('votes');
    }
}
