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
        Schema::create('paymentinfos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dentalclinic_id')->constrained('dentalclinics')->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->string('name');
            $table->string('concern');
            $table->integer('amount');
            $table->integer('balance');
            $table->date('date');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentinfos');
    }
};
