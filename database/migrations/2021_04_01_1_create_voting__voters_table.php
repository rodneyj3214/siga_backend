<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotingVotersTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-voting')->create('voters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('public.users');
            $table->string('type');
            $table->unique(['user_id', 'type']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-voting')->dropIfExists('voters');
    }
}
