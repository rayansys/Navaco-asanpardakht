<?php

use Illuminate\Database\Seeder;
use App\Config;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create([
            'key' => 'payment_api_key',
            'value' => '',
            'label' => 'کد پذیرندگی ( Merchant )'
        ]);
        Config::create([
            'key' => 'payment_username',
            'value' => '',
            'label' => 'نام کاربری ( Username )'
        ]);
        Config::create([
            'key' => 'payment_password',
            'value' => '',
            'label' => 'گذرواژه ( Password )'
        ]);
        Config::create([
            'key' => 'live_stats',
            'value' => false,
            'label' => trans('lang.live_stats'),
            'visible' => 0
        ]);
    }
}
