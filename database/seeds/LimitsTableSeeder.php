<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LimitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limits = array(
            [
                'name'                      => 'un-register',
                'balance_limit'             => 1000000,
                'transaction_limit'         => 500000,
                'transaction_limit_monthly' => 5000000,
                'created_at'                => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'                => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'                      => 'register',
                'balance_limit'             => 10000000,
                'transaction_limit'         => 5000000,
                'transaction_limit_monthly' => 25000000,
                'created_at'                => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'                => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );

        foreach ($limits as $limit) {
            DB::table('limits')->insert($limit);
        }
    }
}
