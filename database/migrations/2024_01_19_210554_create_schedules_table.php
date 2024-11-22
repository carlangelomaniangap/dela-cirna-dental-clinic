<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dentalclinic_id')->constrained('dentalclinics')->onDelete('cascade');
            $table->string('startweek');
            $table->string('endweek');
            $table->time('startmorningtime');
            $table->time('endmorningtime');
            $table->time('startafternoontime');
            $table->time('endafternoontime');
            $table->string('closedday');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};