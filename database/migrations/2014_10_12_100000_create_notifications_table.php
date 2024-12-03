<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Use UUIDs for the primary key
            $table->morphs('notifiable'); // This will create notifiable_id and notifiable_type columns
            $table->string('type'); // Type of notification
            $table->text('data'); // Data to store the notification's content
            $table->timestamp('read_at')->nullable(); // Timestamp to track if the notification is read
            $table->timestamps(); // Laravel's default created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
