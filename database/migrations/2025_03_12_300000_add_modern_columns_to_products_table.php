<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->unique()->after('slug');
            $table->text('short_description')->nullable()->after('description');
            $table->string('meta_title')->nullable()->after('short_description');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
            $table->boolean('featured')->default(false)->after('active');
            $table->decimal('weight_kg', 8, 2)->nullable()->after('stock');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku', 'short_description', 'meta_title', 'meta_description', 'featured', 'weight_kg']);
        });
    }
};
