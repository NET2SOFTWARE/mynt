<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyAcccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_accounts = array([
            [
                'number'                    => '000'. date('y'),
                'account_type_id'           => 3,
                'mynt_id'                   => null,
                'limit_balance'             => null,
                'limit_balance_transaction' => null,
                'created_at'                => Carbon::now(),
                'updated_at'                => Carbon::now()
            ]
        ]);

        foreach ($company_accounts as $company_account) {
            DB::table('accounts')->insert($company_account);
        }
    }
}
