<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyUserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_roles = array([
            [
                'user_id'    => 1,
                'role_id'    => 6,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]
        ]);

        foreach ($user_roles as $user_role) {
            DB::table('user_roles')->insert($user_role);
        }
    }
}
