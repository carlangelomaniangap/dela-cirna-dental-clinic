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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->enum('type', ['Equipment', 'Consumable']);
            $table->enum('unit', ['Each', 'Box', 'Pack', 'Tube', 'Bottle', 'Bag', 'Kit', 'Set']);
            $table->integer('stocks');
            $table->integer('issuance')->default(0);
            $table->integer('disposed')->default(0);
            $table->integer('remaining_stocks');
            $table->date('expiration_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
