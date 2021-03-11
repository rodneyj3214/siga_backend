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
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('short_name')->unique();
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('locations');
    }
}
