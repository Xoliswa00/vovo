<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('propert_imgs');
        Schema::dropIfExists('property_details');
    }

    public function down(): void
    {
        // Property module removed — no rollback
    }
};
