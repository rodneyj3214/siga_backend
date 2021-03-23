<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotingListParticipantsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-voting')->create('list_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voting_list_id')->constrained('public.voting_lists');
            $table->foreignId('user_id')->constrained('public.users');
            $table->foreignId('principal_id')->constrained('public.list_participants');
            $table->string('photo');
            $table->string('type')->comment('presidente tesorero, etc');
            $table->boolean('is_principal');
            $table->integer('order');
            $table->unique(['voting_list_id', 'order']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-voting')->dropIfExists('list_participants');
    }
}
