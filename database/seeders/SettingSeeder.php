<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'app_name',           'value' => 'ODOT ERP',       'group' => 'general'],
            ['key' => 'currency',           'value' => 'IDR',            'group' => 'general'],
            ['key' => 'currency_symbol',    'value' => 'Rp',             'group' => 'general'],
            ['key' => 'timezone',           'value' => 'Asia/Jakarta',   'group' => 'general'],

            // POS
            ['key' => 'default_payment',    'value' => 'cash',           'group' => 'pos'],
            ['key' => 'tax_percentage',     'value' => '0',              'group' => 'pos'],
            ['key' => 'enable_discount',    'value' => '1',              'group' => 'pos'],

            // Receipt / Struk
            ['key' => 'receipt_printer',    'value' => 'pdf',            'group' => 'receipt'], // pdf, thermal_58mm, thermal_80mm
            ['key' => 'receipt_header',     'value' => 'ODOT STORE',     'group' => 'receipt'],
            ['key' => 'receipt_footer',     'value' => 'Terima kasih atas kunjungan Anda!', 'group' => 'receipt'],
            ['key' => 'receipt_show_logo',  'value' => '1',              'group' => 'receipt'],
        ];

        foreach ($settings as $setting) {
            Setting::setValue($setting['key'], $setting['value'], null, $setting['group']);
        }
    }
}
