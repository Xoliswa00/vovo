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
        Schema::create('property_details', function (Blueprint $table) {
            $table->id();
                       $table->string('title');
    $table->text('description')->nullable();
    $table->decimal('price', 12, 2);
    $table->string('address');
    $table->string('city');
    $table->string('state')->nullable();
    $table->string('country')->default('South Africa');
    $table->integer('bedrooms')->default(0);
    $table->integer('bathrooms')->default(0);
    $table->integer('garage')->default(0);
     $table->integer('size')->default(0);
    $table->integer('parking_spaces')->default(0);
    $table->string('property_type')->default('House'); // e.g., House, Apartment
    $table->string('status')->default('Available'); // Available, Sold, Rented
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_details');
    }
};
