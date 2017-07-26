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
                'code'		=> '100',
                'name'		=> 'jawa barat',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '102',
                'name'		=> 'kab. bekasi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '103',
                'name'		=> 'kab. purwakarta',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '106',
                'name'		=> 'kab.karawang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '108',
                'name'		=> 'kab.bogor',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '109',
                'name'		=> 'kab.sukabumi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '110',
                'name'		=> 'kab. cianjur',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '111',
                'name'		=> 'kab. bandung',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '112',
                'name'		=> 'kab. sumedang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '113',
                'name'		=> 'kab. tasikmalaya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '114',
                'name'		=> 'kab. garut',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '115',
                'name'		=> 'kab. ciamis',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '116',
                'name'		=> 'kab. cirebon',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '117',
                'name'		=> 'kab. kuningan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '118',
                'name'		=> 'kab. indramayu',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '119',
                'name'		=> 'kab. majalengka',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '121',
                'name'		=> 'kab. subang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '122',
                'name'		=> 'kab. bandung barat',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '191',
                'name'		=> 'kab. bandung',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '192',
                'name'		=> 'kab. bogor',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '193',
                'name'		=> 'kab. sukabumi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '194',
                'name'		=> 'kab. cirebon',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '195',
                'name'		=> 'kab. tasikmalaya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '196',
                'name'		=> 'kab. cimahi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '197',
                'name'		=> 'kab. depok',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '198',
                'name'		=> 'kab. bekasi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '180',
                'name'		=> 'kab. banjar',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '188',
                'name'		=> 'kab. /kota lainya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '200',
                'name'		=> 'banten',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '201',
                'name'		=> 'kab. lebak',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '202',
                'name'		=> 'kab. pandeglang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '203',
                'name'		=> 'kab.serang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '204',
                'name'		=> 'kab tangerang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '291',
                'name'		=> 'kota.cilegon',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '292',
                'name'		=> 'kota.tangerang ',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '293',
                'name'		=> 'kota. serang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '294',
                'name'		=> 'tangerang selatan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '288',
                'name'		=> 'kab. /kota lainya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '300',
                'name'		=> 'dki jakarta',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '391',
                'name'		=> 'jakarta pusat',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '392',
                'name'		=> 'jakarta utara',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '393',
                'name'		=> 'jakarta barat',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '394',
                'name'		=> 'jakarta selatan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '395',
                'name'		=> 'jakarta timur',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '396',
                'name'		=> 'kepulauan seribu',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '500',
                'name'		=> 'yogyakarta',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '501',
                'name'		=> 'kab. bantul',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '502',
                'name'		=> 'kab. sleman',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '503',
                'name'		=> 'kab. gunung kidul',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '504',
                'name'		=> 'kab. kulon progo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '591',
                'name'		=> 'kota. yogyakarta',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '588',
                'name'		=> 'kab./kota lainya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '900',
                'name'		=> 'jawa tengah',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '901',
                'name'		=> 'kab. semarang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '902',
                'name'		=> 'kab. kendal',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '903',
                'name'		=> 'kab. demak',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '904',
                'name'		=> 'kab. grobogan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '905',
                'name'		=> 'kab. pekalongan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '906',
                'name'		=> 'kab. tegal',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '907',
                'name'		=> 'kab.brebes',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '908',
                'name'		=> 'kab. pati',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '909',
                'name'		=> 'kab. kudus',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '910',
                'name'		=> 'kab. pemalang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '911',
                'name'		=> 'kab. jepara',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '912',
                'name'		=> 'kab. rembang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '913',
                'name'		=> 'kab. blora',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '914',
                'name'		=> 'kab. banyumas',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '915',
                'name'		=> 'kab. cilacap',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '916',
                'name'		=> 'kab. purbalingga',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '917',
                'name'		=> 'kab. banjarnegara',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '918',
                'name'		=> 'kab. magelang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '919',
                'name'		=> 'kab. temanggung',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '920',
                'name'		=> 'kab. wonosobo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '921',
                'name'		=> 'kab. purworejo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '922',
                'name'		=> 'kab. kebumen',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '923',
                'name'		=> 'kab. klaten',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '924',
                'name'		=> 'kab. boyolali',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '925',
                'name'		=> 'kab. sragen',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '926',
                'name'		=> 'kab. sukoharjo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '927',
                'name'		=> 'kab. karanganyar',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '928',
                'name'		=> 'kab. wonogiri',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '929',
                'name'		=> 'kab. batang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '991',
                'name'		=> 'kota. semarang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '992',
                'name'		=> 'kota. salatiga',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '993',
                'name'		=> 'kota. pekalongan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '994',
                'name'		=> 'kota. tegal',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '995',
                'name'		=> 'kota. magelang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '996',
                'name'		=> 'kota. surakarta/solo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1200',
                'name'		=> 'jawa timur',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1201',
                'name'		=> 'kab gresik',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1202',
                'name'		=> 'kab. sidoarjo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1203',
                'name'		=> 'kab. mojokerto',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1204',
                'name'		=> 'kab.jombang ',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1205',
                'name'		=> 'kab. sampang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1206',
                'name'		=> 'kab. pamekasan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1207',
                'name'		=> 'kab. sumenep',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1208',
                'name'		=> 'kab. bangkalan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1209',
                'name'		=> 'kab. bondowoso',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1211',
                'name'		=> 'kab. banyuwangi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1212',
                'name'		=> 'kab. jember',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1213',
                'name'		=> 'kab. malang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1214',
                'name'		=> 'kab. pasuruan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1215',
                'name'		=> 'kab. probolinggo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1216',
                'name'		=> 'kab. lumajang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1217',
                'name'		=> 'kab. kediri',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1218',
                'name'		=> 'kab. nganjuk',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1219',
                'name'		=> 'kab. tulungagung',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1220',
                'name'		=> 'kab. trenggalek',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1221',
                'name'		=> 'kab. blitar',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1222',
                'name'		=> 'kab. madiun',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1223',
                'name'		=> 'kab. ngawi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1224',
                'name'		=> 'kab. magetan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1225',
                'name'		=> 'kab. ponorogo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1226',
                'name'		=> 'kab. pacitan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1227',
                'name'		=> 'kab. bojonegoro',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1228',
                'name'		=> 'kab. tuban',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1229',
                'name'		=> 'kab. lamongan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1230',
                'name'		=> 'kab. situbondo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1291',
                'name'		=> 'kota. surabaya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1292',
                'name'		=> 'kota. malang ',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1293',
                'name'		=> 'kota. pasuruan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1294',
                'name'		=> 'kota. pasuruan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1295',
                'name'		=> 'kota. probolinggo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1296',
                'name'		=> 'kota. blitar',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1297',
                'name'		=> 'kota. madiun',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1298',
                'name'		=> 'kota. batu',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '1271',
                'name'		=> 'kab./kota lainya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2300',
                'name'		=> 'bengkulu',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2301',
                'name'		=> 'kab. bengkulu selatan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2302',
                'name'		=> 'kab. bengkulu utara',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2303',
                'name'		=> 'kab. rejang lebong',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2304',
                'name'		=> 'kab. lebong',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2305',
                'name'		=> 'kab. kepahiang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2306',
                'name'		=> 'kab. mukomuko',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2307',
                'name'		=> 'kab. seluma',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2308',
                'name'		=> 'kab. kaur',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2309',
                'name'		=> 'kab. bengkulu tengah',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2391',
                'name'		=> 'kab. bengkulu',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '2388',
                'name'		=> 'kab./kota lainya  ',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],

            [
                'code'		=> '3100',
                'name'		=> 'jambi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3101',
                'name'		=> 'kab. batanghari',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3104',
                'name'		=> 'kab. sarolangun',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3105',
                'name'		=> 'kab. kerinci',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3106',
                'name'		=> 'kab. muaro jambi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3107',
                'name'		=> 'kab. tanjung jabung barat',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3108',
                'name'		=> 'kab. tanjung jabung timur',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3109',
                'name'		=> 'kab. tebo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3111',
                'name'		=> 'kab. merangin',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3112',
                'name'		=> 'kab. bungo ',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3191',
                'name'		=> 'kota. jambi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3192',
                'name'		=> 'kota. sungai penuh',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3188',
                'name'		=> 'kota./kota lainya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3200',
                'name'		=> 'nad',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3201',
                'name'		=> 'kab. aceh besar',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3202',
                'name'		=> 'kota. pidie',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3203',
                'name'		=> 'kab.aceh utara',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3204',
                'name'		=> 'kab. aceh timur',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3205',
                'name'		=> 'kab. aceh selatan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3206',
                'name'		=> 'kab. aceh barat',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3207',
                'name'		=> 'kab. aceh tengah',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3208',
                'name'		=> 'kab. aceh tenggara',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3209',
                'name'		=> 'kab. aceh singkil',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3210',
                'name'		=> 'kab. aceh jeumpa/bireun',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3211',
                'name'		=> 'kab. aceh tamiang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3212',
                'name'		=> 'kab. aceh gayo lues',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3213',
                'name'		=> 'kab. aceh barat daya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3214',
                'name'		=> 'kab. aceh jaya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3215',
                'name'		=> 'kab. nagan raya  ',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3216',
                'name'		=> 'kab. simeuleu',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3217',
                'name'		=> 'kab. bener meriah',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3218',
                'name'		=> 'kab. pidie jaya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3219',
                'name'		=> 'kab. subulussalam',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3291',
                'name'		=> 'kota. banda aceh',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3292',
                'name'		=> 'kota. sabang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3293',
                'name'		=> 'kota.lhoksuemawe',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3288',
                'name'		=> 'kab./kota lainya',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3300',
                'name'		=> 'sumatra utara',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3301',
                'name'		=> 'kab. deli serdang',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3302',
                'name'		=> 'kab. langkat',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3303',
                'name'		=> 'kab. karo',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3304',
                'name'		=> 'kab. simalungun',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3305',
                'name'		=> 'kab. labuhan batu',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3306',
                'name'		=> 'kab. asahan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3307',
                'name'		=> 'kab.dairi',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3308',
                'name'		=> 'kab.tapanuli utara',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3309',
                'name'		=> 'kab. tapanuli tengah',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3310',
                'name'		=> 'kab. tapanuli selatan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3311',
                'name'		=> 'kab. nias',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3313',
                'name'		=> 'kab. toba samosir',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3314',
                'name'		=> 'kab. mandailing natal',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3315',
                'name'		=> 'kab. nias selatan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3316',
                'name'		=> 'kab. humbang hasundutan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3317',
                'name'		=> 'kab. pakpak bharat',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3318',
                'name'		=> 'kab. samosir',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3319',
                'name'		=> 'kab. serdang bedagai',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3321',
                'name'		=> 'kab. batu bara',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3322',
                'name'		=> 'kab.padang lawas',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            
            [
                'code'		=> '3323',
                'name'		=> 'kab. padang lawas utara',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'		=> '3324',
                'name'		=> 'kab. labuanbatu selatan',
                'created_at'	=> Carbon::now(),
                'updated_at'	=> Carbon::now()
            ],
            [
                'code'      => '3325',
                'name'      => 'kab. labuanbatu utara',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3326',
                'name'      => 'kab. nias barat',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3327',
                'name'      => 'kab. nias utara',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3377',
                'name'      => 'kota gunung sotoli',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3391',
                'name'      => 'kota tebing tinggi',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3392',
                'name'      => 'kota binjai',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3393',
                'name'      => 'kota pematang siantar',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3394',
                'name'      => 'kota tanjung balai',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3395',
                'name'      => 'kota sibolga',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3396',
                'name'      => 'kota medan',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3399',
                'name'      => 'kota padang sidempuan',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3388',
                'name'      => 'kab/kota lainnya',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3400',
                'name'      => 'sumatera barat',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3401',
                'name'      => 'kab. agam',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3402',
                'name'      => 'kab. pasaman',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3403',
                'name'      => 'kab. lima puluh kota',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3404',
                'name'      => 'kab. solok selatan',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3405',
                'name'      => 'kab. padang pariaman',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3406',
                'name'      => 'kab. pesisir selatan',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3407',
                'name'      => 'kab. tanah datar',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3408',
                'name'      => 'kab. sijunjung',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3409',
                'name'      => 'kab. kepulauan mentawai',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3410',
                'name'      => 'kab. pasaman barat',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3411',
                'name'      => 'kab. dharmasraya',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3412',
                'name'      => 'kab. solok',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3491',
                'name'      => 'kota bukit tingi',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3492',
                'name'      => 'kota padang',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3493',
                'name'      => 'kota sawah lunto',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3494',
                'name'      => 'kota padang panjang',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3495',
                'name'      => 'kota solok',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3496',
                'name'      => 'kota payahkumbuh',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3497',
                'name'      => 'kota pariaman',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3500',
                'name'      => 'riau',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3501',
                'name'      => 'kab. kampar',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3502',
                'name'      => 'kab. bengkalis',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3504',
                'name'      => 'kab. indragiri hulu',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3505',
                'name'      => 'kab. indragiri hilir',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3508',
                'name'      => 'kab. rokan hulu',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3509',
                'name'      => 'kab. rokan hilir',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3510',
                'name'      => 'kab. pelalawan',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3511',
                'name'      => 'kab. siak',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3512',
                'name'      => 'kab. kuantan singingi',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3513',
                'name'      => 'kab. kepulauan meranti',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3591',
                'name'      => 'kota pekanbaru',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3592',
                'name'      => 'kota dumai',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],

            [
                'code'      => '3600',
                'name'      => 'sumatera selatan',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3606',
                'name'      => 'kab. musi banyuasin',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3607',
                'name'      => 'kab. ogan komering ulu',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3608',
                'name'      => 'kab. lematang ilir ogan tengah (muara enim)',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3609',
                'name'      => 'kab. lahat',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3610',
                'name'      => 'kab. musi rawas',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3611',
                'name'      => 'kab. ogan komering ilir',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3613',
                'name'      => 'kab. banyuasin',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'code'      => '3614',
                'name'      => 'kab. ogan komering ilir',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]
        ];

        foreach ($areas as $area) {
            DB::table('areas')->insert($area);
        }
    }
}
