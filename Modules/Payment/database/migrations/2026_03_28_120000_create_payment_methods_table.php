<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->unique();
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->string('description_en')->nullable();
            $table->string('description_ar')->nullable();
            $table->text('instructions_en')->nullable();
            $table->text('instructions_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('requires_proof')->default(false);
            $table->boolean('requires_admin_approval')->default(false);
            $table->boolean('is_system')->default(false);
            $table->timestamps();
        });

        $now = now();
        DB::table('payment_methods')->insert([
            [
                'code' => 'cash',
                'name_en' => 'Cash on Delivery',
                'name_ar' => 'الدفع عند الاستلام',
                'description_en' => null,
                'description_ar' => null,
                'instructions_en' => null,
                'instructions_ar' => null,
                'is_active' => true,
                'sort_order' => 10,
                'requires_proof' => false,
                'requires_admin_approval' => false,
                'is_system' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'bank',
                'name_en' => 'Bank Transfer',
                'name_ar' => 'تحويل بنكي',
                'description_en' => 'Pay via bank transfer; upload your receipt for verification.',
                'description_ar' => 'الدفع عبر التحويل البنكي؛ ارفق إيصال التحويل للمراجعة.',
                'instructions_en' => null,
                'instructions_ar' => null,
                'is_active' => true,
                'sort_order' => 20,
                'requires_proof' => true,
                'requires_admin_approval' => true,
                'is_system' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
