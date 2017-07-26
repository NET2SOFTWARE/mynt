<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = array([
            [
                'code' => '000',
                'name' => 'PT. Artajasa Pembayaran Elektronis',
                'phone' => '622129706789',
                'email' => 'info@artajasa.co.id',
                'brand' => 'Layanan switching per-bankan di indonesia.',
                'website' => 'https://www.artajasa.co.id',
                'industry_id' => 9,
                'image' => 'company.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        foreach ($companies as $company) {
            DB::table('companies')->insert($company);
        }
    }
}