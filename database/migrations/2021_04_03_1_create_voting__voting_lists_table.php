<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotingVotingListsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-voting')->create('voting_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voting_day_id')->nullable()->constrained('public.voting_days');
            $table->string('name');
            $table->string('color');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-voting')->dropIfExists('voting_lists');
    }
}
