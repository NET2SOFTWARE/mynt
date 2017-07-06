<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = array([
            [
                'trx_id'                => '0000000000000',
                'service_id'            => 5,
                'sender_account_number'   => 1,
                'receiver_account_number' => 1,
                'terminal'              => 1,
                'amount'                => 9000000000000,
                'status'                => true,
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now(),
            ]
        ]);

        foreach ($transactions as $transaction) {
            DB::table('transactions')->insert($transaction);
        }
    }
}
