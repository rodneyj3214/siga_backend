<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebSectionsTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-web')->create('sections', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description');
            $table->integer('order');
            $table->foreignId('status_id')->constrained('app.catalogues');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-web')->dropIfExists('sections');
    }
}
