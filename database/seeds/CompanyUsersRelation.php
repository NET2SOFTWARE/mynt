<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyUsersRelation extends Seeder
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
                'company_id'    => 1,
                'user_id'       => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]
        );

        foreach ($company_users as $company_user) {
            DB::table('user_companies')->insert($company_user);
        }
    }
}
