<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('appointmentdate');
            $table->time('appointmenttime');
            $table->string('name');
            $table->string('gender');
            $table->date('birthday');
            $table->string('age');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('medicalhistory')->nullable();
            $table->string('emergencycontactname');
            $table->string('emergencycontactrelation');
            $table->string('emergencycontactphone');
            $table->string('relationname')->nullable();
            $table->string('relation')->nullable();
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
