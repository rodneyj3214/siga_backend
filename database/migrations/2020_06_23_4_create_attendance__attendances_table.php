<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceAttendancesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-attendance')->create('attendances', function (Blueprint $table) {
            $table->id();
            $table->morphs('attendanceable');
            $table->foreignId('institution_id')->constrained('app.institutions');
            $table->boolean('state')->default(true);
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-attendance')->dropIfExists('attendances');
    }
}
