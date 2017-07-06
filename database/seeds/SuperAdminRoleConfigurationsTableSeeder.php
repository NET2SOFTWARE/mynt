<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminRoleConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAttachments = array([
            [
                'role_id' => 1,
                'access_configuration_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        foreach ($roleAttachments as $roleAttachment) {
            DB::table('role_access_configurations')->insert($roleAttachment);
        }
    }
}
