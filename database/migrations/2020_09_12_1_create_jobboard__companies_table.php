<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardCompaniesTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-job-board')->create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('authentication.users');
            $table->foreignId('type_id')->constrained('app.catalogues');
            $table->string('trade_name');
            $table->text('comercial_activity');
            $table->string('web_page');
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('companies');
    }
}
