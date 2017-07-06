<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = array(
            [
                'bank_code' => '008',
                'bank_name' => 'mandiri',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '002',
                'bank_name' => 'bri',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '009',
                'bank_name' => 'bni',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '022',
                'bank_name' => 'niaga',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '019',
                'bank_name' => 'panin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '013',
                'bank_name' => 'permata',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '011',
                'bank_name' => 'danamon',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '016',
                'bank_name' => 'bii',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '200',
                'bank_name' => 'btn',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '028',
                'bank_name' => 'ocbc nisp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '425',
                'bank_name' => 'jabarsya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '426',
                'bank_name' => 'mega',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '441',
                'bank_name' => 'bukopin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '041',
                'bank_name' => 'hsbc',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '031',
                'bank_name' => 'citibank',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '023',
                'bank_name' => 'bank uob',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '213',
                'bank_name' => 'btpn',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '451',
                'bank_name' => 'bsm',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '050',
                'bank_name' => 'stanchrt',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '147',
                'bank_name' => 'muamalat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '046',
                'bank_name' => 'bank dbs',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '124',
                'bank_name' => 'bpd kaltim',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '114',
                'bank_name' => 'jatim',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '061',
                'bank_name' => 'anz',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '111',
                'bank_name' => 'bank dki',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '113',
                'bank_name' => 'jateng',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '087',
                'bank_name' => 'ekonomi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '117',
                'bank_name' => 'bpd sumut',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '119',
                'bank_name' => 'bank riau',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '097',
                'bank_name' => 'mayapada',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '120',
                'bank_name' => 'sumselbabel',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '095',
                'bank_name' => 'bjtrust',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '153',
                'bank_name' => 'sinarmas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '132',
                'bank_name' => 'bpd papua',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '950',
                'bank_name' => 'commbank',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '118',
                'bank_name' => 'nagari',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '422',
                'bank_name' => 'bris',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '089',
                'bank_name' => 'robobank',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '069',
                'bank_name' => 'bank of china',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '116',
                'bank_name' => 'bpd aceh',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '129',
                'bank_name' => 'bpd bali',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '122',
                'bank_name' => 'kalsel',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '123',
                'bank_name' => 'bpd kalbar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '145',
                'bank_name' => 'bnp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '506',
                'bank_name' => 'bsmi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '558',
                'bank_name' => 'pundi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '212',
                'bank_name' => 'woorisdr',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '126',
                'bank_name' => 'sulsel',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '164',
                'bank_name' => 'icbc ind',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '151',
                'bank_name' => 'mestika',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '130',
                'bank_name' => 'bank ntt',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '127',
                'bank_name' => 'sulut',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '054',
                'bank_name' => 'capital',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '112',
                'bank_name' => 'diy',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '121',
                'bank_name' => 'lampung',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '167',
                'bank_name' => 'bank qnb',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '131',
                'bank_name' => 'atmaluku',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '110',
                'bank_name' => 'bank bjb',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '555',
                'bank_name' => 'index',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '128',
                'bank_name' => 'bpd ntb',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '494',
                'bank_name' => 'briagro',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '125',
                'bank_name' => 'kalteng',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '115',
                'bank_name' => 'jambi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '535',
                'bank_name' => 'bke',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '135',
                'bank_name' => 'sultra',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '133',
                'bank_name' => 'bengkulu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '146',
                'bank_name' => 'boii',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '553',
                'bank_name' => 'mayora',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '161',
                'bank_name' => 'ganesha',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '513',
                'bank_name' => 'bank ina',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '134',
                'bank_name' => 'sulteng',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '503',
                'bank_name' => 'nobu bank',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '517',
                'bank_name' => 'panin sy',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '542',
                'bank_name' => 'bank artos',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '688',
                'bank_name' => 'bpr ks',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '558',
                'bank_name' => 'pundi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '485',
                'bank_name' => 'mnc bank',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '068',
                'bank_name' => 'bwi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '490',
                'bank_name' => 'bank byb',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '526',
                'bank_name' => 'dinar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '600',
                'bank_name' => 'bpr/lsb',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '699',
                'bank_name' => 'bank eka',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'bank_code' => '699',
                'bank_name' => 'bank eka',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        foreach ($banks as $bank) {
            DB::table('banks')->insert($bank);
        }
    }
}
