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
        Schema::create('patientlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dentalclinic_id')->constrained('dentalclinics')->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->string('name');
            $table->string('gender');
            $table->date('birthday');
            $table->integer('age');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patientlists');
    }
};
