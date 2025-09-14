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
        Schema::create('logistics_details', function (Blueprint $table) {
            $table->id();
              $table->string('name'); // Vehicle/item name
    $table->string('type'); // Vehicle type (van, truck, etc.)
    $table->integer('capacity')->nullable(); // Capacity in units/tons
    $table->string('origin'); // Starting point
    $table->string('destination'); // End point
    $table->string('status')->default('available'); // Status: available, in-use, maintenance
    $table->json('documents')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logistics_details');
    }
};
