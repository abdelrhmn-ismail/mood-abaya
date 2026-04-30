<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Ensure Tabby exists in payment_methods
        $exists = DB::table('payment_methods')->where('code', 'tabby')->exists();
        if (!$exists) {
            DB::table('payment_methods')->insert([
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
        }

        // Seed default Tabby API settings (only if not already set)
        $defaults = [
            'public_key'    => 'pk_test_019cdecf-0e2c-3349-17d7-e381f72b1276',
            'secret_key'    => 'sk_test_019cdecf-0e2c-3349-17d7-e382a788104a',
            'merchant_code' => 'MD',
        ];

        foreach ($defaults as $key => $value) {
            $settingExists = DB::table('payment_gateway_settings')
                ->where('gateway', 'tabby')
                ->where('key', $key)
                ->exists();

            if (!$settingExists) {
                DB::table('payment_gateway_settings')->insert([
                    'gateway'    => 'tabby',
                    'key'        => $key,
                    'value'      => $value,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
