<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('compare_at_price', 12, 2)->nullable()->after('price');
            $table->string('meta_keywords', 500)->nullable()->after('meta_description');
            $table->string('og_image', 500)->nullable()->after('meta_keywords');
            $table->string('barcode', 100)->nullable()->after('sku');
            $table->string('tags', 500)->nullable()->after('short_description');
            $table->unsignedTinyInteger('min_order_qty')->default(1)->after('stock');
            $table->unsignedInteger('max_order_qty')->nullable()->after('min_order_qty');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'compare_at_price',
                'meta_keywords',
                'og_image',
                'barcode',
                'tags',
                'min_order_qty',
                'max_order_qty',
            ]);
        });
    }
};
