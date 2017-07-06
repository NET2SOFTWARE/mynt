<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TerminalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $terminals = (array) [
            [
                'code'      => '1010101',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($terminals as $terminal) {
            DB::table('terminals')->insert($terminal);
        }
    }
}
