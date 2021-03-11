<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareersTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('careers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id');
            $table->string('code')->nullable();;
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('short_name');
            $table->foreignId('modality_id')->constrained('catalogues');
            $table->string('resolution_number')->nullable();
            $table->string('title');
            $table->string('acronym');
            $table->string('logo');
            $table->foreignId('type_id')->constrained('catalogues');
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('careers');
    }
}
