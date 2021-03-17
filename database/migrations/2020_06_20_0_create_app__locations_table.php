<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppLocationsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->nullable()->constrained('app.catalogues');
            $table->foreignId('parent_id')->nullable()->constrained('app.locations');
            $table->string('code');
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->boolean('state')->default(true);
            $table->unique(['code','name']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('locations');
    }
}
