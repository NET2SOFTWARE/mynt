<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = (array) [
            [
                'name'          => 'Rudi Batubara',
                'email'         => 'rudi@net2software.com',
                'password'      => bcrypt('rudi123'),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'CS Administrator',
                'email'         => 'cs@net2software.com',
                'password'      => bcrypt('net2software'),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
        ];

        foreach ($admins as $admin) {
            DB::table('admins')->insert($admin);
        }
    }
}
