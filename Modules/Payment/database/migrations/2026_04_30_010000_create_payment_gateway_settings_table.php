<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateway_settings', function (Blueprint $table) {
            $table->id();
            $table->string('gateway', 64);                     // e.g. 'tabby'
            $table->string('key', 128);                        // e.g. 'public_key'
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['gateway', 'key'], 'gateway_key_unique');
        });

        // Seed Tabby as a system payment method
        $now = now();
        DB::table('payment_methods')->insertOrIgnore([
            'code'                    => 'tabby',
            'name_en'                 => 'Tabby - Pay in Installments',
            'name_ar'                 => 'تابي - قسّمها على 4',
            'description_en'          => 'Split your purchase into 4 interest-free payments.',
            'description_ar'          => 'قسّم مشترياتك على 4 دفعات بدون فوائد.',
            'instructions_en'         => null,
            'instructions_ar'         => null,
            'is_active'               => false,
            'sort_order'              => 30,
            'requires_proof'          => false,
            'requires_admin_approval' => false,
            'is_system'               => true,
            'created_at'              => $now,
            'updated_at'              => $now,
        ]);

        // Seed default Tabby gateway settings
        $settings = [
            ['gateway' => 'tabby', 'key' => 'public_key',     'value' => 'pk_test_019cdecf-0e2c-3349-17d7-e381f72b1276', 'created_at' => $now, 'updated_at' => $now],
            ['gateway' => 'tabby', 'key' => 'secret_key',     'value' => 'sk_test_019cdecf-0e2c-3349-17d7-e382a788104a', 'created_at' => $now, 'updated_at' => $now],
            ['gateway' => 'tabby', 'key' => 'merchant_code',  'value' => 'MD',                                           'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('payment_gateway_settings')->insert($settings);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_settings');
        DB::table('payment_methods')->where('code', 'tabby')->delete();
    }
};
