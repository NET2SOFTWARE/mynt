<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyAccountRelationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyAccountRelations = array([
            [
                'account_id'    => 1,
                'company_id'    => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]
        ]);

        foreach ($companyAccountRelations as $companyAccountRelation) {
            DB::table('company_accounts')->insert($companyAccountRelation);
        }
    }
}
