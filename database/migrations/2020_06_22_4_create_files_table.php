<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('files', function (Blueprint $table) {
            $table->id();
            $table->morphs('fileable');
            $table->string('name');
            $table->text('description');
            $table->text('uri');
            $table->string('extension');
            $table->string('type');
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('files');
    }
}
