<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebMenusTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-web')->create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('menus');
            $table->text('name');
            $table->text('url');
            $table->text('icon');
            $table->text('description')->nullable();
            $table->integer('order');
            $table->foreignId('type_id')->constrained('catalogues'); /*para ver si esta arriba o abajo */
            $table->foreignId('status_id')->constrained('app.catalogues');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-web')->dropIfExists('main_menu');
    }
}
