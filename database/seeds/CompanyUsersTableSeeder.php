<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_users = array(
            [
                'name'          => 'pt. artajasa pembayaran elektronik',
                'email'         => 'info@artajasa.co.id',
                'phone'         => '622129706789',
                'password'      => bcrypt('artajasa123'),
                'isConfirmed'   => true,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]
        );

        foreach ($company_users as $company_user) {
            DB::table('users')->insert($company_user);
        }
    }
}
