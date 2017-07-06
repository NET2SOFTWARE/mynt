<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = (array) [
            [
                'iso'       => 'id',
                'name'      => 'indonesia',
                'currency'  => 'idr',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert($country);
        }
    }
}
