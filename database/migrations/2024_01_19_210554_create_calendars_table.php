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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('appointmentdate');
            $table->enum('appointmenttime', ['8:00 AM - 9:00 AM', '9:00 AM - 10:00 AM', '10:00 AM - 11:00 AM', '11:00 AM - 12:00 PM', '3:00 PM - 4:00 PM','4:00 PM - 5:00 PM', '5:00 PM - 6:00 PM', '6:00 PM - 7:00 PM', '7:00 PM - 8:00 PM']);
            $table->string('concern');
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
            $table->enum('status', ['Pending', 'PendingCancelled', 'Approved', 'Completed', 'ApprovedCancelled'])->default('Pending');
            $table->text('completion_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
