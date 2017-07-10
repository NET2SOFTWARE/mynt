<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            [
                'name'          => 'kepala daerah province jawa barat',
                'code'          => 100,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'kab. bekasi',
                'code'          => 102,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'kab. purwakarta',
                'code'          => 103,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'kab. karawang',
                'code'          => 106,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'kab. bogor',
                'code'          => 108,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'kab. sukabumi',
                'code'          => 109,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'kab. cianjur',
                'code'          => 110,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'kab. bandung',
                'code'          => 111,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'kab. sumedang',
                'code'          => 112,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'kab. tasikmalaya',
                'code'          => 113,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'kab. garut',
                'code'          => 114,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
        ];

        foreach ($areas as $area) {
            DB::table('areas')->insert($area);
        }
    }
}
