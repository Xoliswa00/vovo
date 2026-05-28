<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete()->after('status');
            $table->foreignId('vendor_id')->nullable()->constrained()->nullOnDelete()->after('category_id');
            $table->decimal('price', 10, 2)->nullable()->after('vendor_id');
            $table->string('location')->nullable()->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropConstrainedForeignId('vendor_id');
            $table->dropColumn(['price', 'location']);
        });
    }
};
