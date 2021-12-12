<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'code' => 'GHF545',
            'type' => 'fixed',
            'value' => 2500,
        ]);

        Coupon::create([
            'code' => 'POL574',
            'type' => 'percent',
            'percent_off' => 15,
        ]);
}
}
