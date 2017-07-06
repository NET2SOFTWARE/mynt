<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $access_configurations = array(
            [
                'access_name'       => 'all transaction',
                'access_action'     => json_encode(['view' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'success transaction',
                'access_action'     => json_encode(['view' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'failed-transaction',
                'access_action'     => json_encode(['view' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'transaction reversal',
                'access_action'     => json_encode(['view' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'all company',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'company document',
                'access_action'     => json_encode(['upload' => true, 'download' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'deactivate company',
                'access_action'     => json_encode(['view' => true, 'deactivate' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'all merchant',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'merchant transaction',
                'access_action'     => json_encode(['view' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'all member',
                'access_action'     => json_encode(['view' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'registration approval',
                'access_action'     => json_encode(['view' => true, 'confirm' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'pending upgrade',
                'access_action'     => json_encode(['view' => true, 'approve' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'child account',
                'access_action'     => json_encode(['view' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'member document',
                'access_action'     => json_encode(['view' => true, 'upload' => true, 'download' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'deactivate member',
                'access_action'     => json_encode(['view' => true, 'deactivated' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'member transaction',
                'access_action'     => json_encode(['view' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'all service',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'setting charge',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'mapping charge',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'mapping charge',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'deactivate service',
                'access_action'     => json_encode(['view' => true, 'deactivate' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'all product',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'setting product price',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'mapping product price',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'setting tax and fee',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'mapping tax and fee',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'deactivate product',
                'access_action'     => json_encode(['view' => true, 'deactivate' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'all administrator',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'setting role',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'deactivate access',
                'access_action'     => json_encode(['view' => true, 'deactivate' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'all terminal',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'deactivate terminal',
                'access_action'     => json_encode(['view' => true, 'deactivate' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'management institution',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'management partnership',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'management country',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'management state',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'management city',
                'access_action'     => json_encode(['view' => true, 'create' => true, 'update' => true, 'delete' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'report general ledger',
                'access_action'     => json_encode(['view' => true, 'print' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'report company',
                'access_action'     => json_encode(['view' => true, 'print' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'report merchant',
                'access_action'     => json_encode(['view' => true, 'print' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'report member',
                'access_action'     => json_encode(['view' => true, 'print' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'report service',
                'access_action'     => json_encode(['view' => true, 'print' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'access_name'       => 'report transaction',
                'access_action'     => json_encode(['view' => true, 'print' => true]),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        );

        foreach ($access_configurations as $access_configuration) {
            DB::table('access_configurations')->insert($access_configuration);
        }
    }
}
