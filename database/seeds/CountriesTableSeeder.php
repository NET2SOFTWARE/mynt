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
                'iso'       => 'af',
                'name'      => 'afgahanistan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],

            [
                'iso'       => 'ax',
                'name'      => 'aland islands',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'al',
                'name'      => 'albania',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'dz',
                'name'      => 'algeria',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'as',
                'name'      => 'american samoa',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ad',
                'name'      => 'andorra',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ao',
                'name'      => 'angola',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'ai',
                'name'      => 'anguilla',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'aq',
                'name'      => 'antartica',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ag',
                'name'      => 'antigua and barbuda',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ar',
                'name'      => 'argentina',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'am',
                'name'      => 'armenia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'aw',
                'name'      => 'aruba',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'au',
                'name'      => 'australia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'at',
                'name'      => 'austria',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'az',
                'name'      => 'azerbaijan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'bs',
                'name'      => 'bahamas',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'bh',
                'name'      => 'bahrain',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'bd',
                'name'      => 'bangladesh',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'bb',
                'name'      => 'barbados',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'by',
                'name'      => 'belarus',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'be',
                'name'      => 'belgium',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'bz',
                'name'      => 'belize',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bj',
                'name'      => 'benin',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bm',
                'name'      => 'bermuda',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bt',
                'name'      => 'bhutan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bo',
                'name'      => 'bolivia, plurinational state of',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bq',
                'name'      => 'bonaire, sint eustatius and saba',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'ba',
                'name'      => 'bosnia and herzegovin',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bw',
                'name'      => 'botswana',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bv',
                'name'      => 'bouvet island',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'br',
                'name'      => 'brazil',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'io',
                'name'      => 'british indian ocean territory',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bn',
                'name'      => 'brunei darussalam',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bg',
                'name'      => 'bulgaria',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bf',
                'name'      => 'burkina faso',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'bi',
                'name'      => 'burundi',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'kh',
                'name'      => 'cambodia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cm',
                'name'      => 'cameroon',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'ca',
                'name'      => 'canada',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cv',
                'name'      => 'cape verde',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'ky',
                'name'      => 'cayman islands',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cf',
                'name'      => 'central african republic',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'td',
                'name'      => 'chad',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cl',
                'name'      => 'chile',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cn',
                'name'      => 'china',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cx',
                'name'      => 'christmas island',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cc',
                'name'      => 'cocos (keeling) islands',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'co',
                'name'      => 'colombia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'km',
                'name'      => 'comoros',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cg',
                'name'      => 'congo',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cd',
                'name'      => 'congo,the democratic republic of the',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'ck',
                'name'      => 'cok island',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cr',
                'name'      => 'costa rica',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'ci',
                'name'      => 'cote d`ivoire',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'hr',
                'name'      => 'croatia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cu',
                'name'      => 'cuba',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cw',
                'name'      => 'curacao',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cy',
                'name'      => 'cyprus',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'cz',
                'name'      => 'czech republic',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'dk',
                'name'      => 'denmark',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'dj',
                'name'      => 'djibouti',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'dm',
                'name'      => 'dominica',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'do',
                'name'      => 'dominica republic',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'ec',
                'name'      => 'ecuador',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'eg',
                'name'      => 'egypt',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'sv',
                'name'      => 'el salvador',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'gq',
                'name'      => 'equatorial guinea',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'er',
                'name'      => 'eritrea',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'ee',
                'name'      => 'estonia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'et',
                'name'      => 'ethiophia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'fk',
                'name'      => 'falkland island (malvinas)',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'fo',
                'name'      => 'faroe island',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'fj',
                'name'      => 'fiji',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'fi',
                'name'      => 'finland',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'fr',
                'name'      => 'france',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'gf',
                'name'      => 'french guiana',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'pf',
                'name'      => 'french polynesia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'tf',
                'name'      => 'french southern territories',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'ga',
                'name'      => 'gabon',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'gm',
                'name'      => 'gambia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'ge',
                'name'      => 'georgia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'de',
                'name'      => 'germany',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'gh',
                'name'      => 'ghana',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'gi',
                'name'      => 'gibraltar',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'gr',
                'name'      => 'greece',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'gl',
                'name'      => 'greenland',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'gd',
                'name'      => 'grenada',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'gp',
                'name'      => 'guadeloupe',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'gu',
                'name'      => 'guam',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'gt',
                'name'      => 'guatemala',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'gg',
                'name'      => 'guernsey',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'gn',
                'name'      => 'guinea',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'gw',
                'name'      => 'guinea-bissau',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'gy',
                'name'      => 'guyana',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ht',
                'name'      => 'haiti',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'hm',
                'name'      => 'heard island and mcdonald islands',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'va',
                'name'      => 'holy see (vatican city state)',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'hn',
                'name'      => 'honduras',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'hk',
                'name'      => 'hong kong',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'hu',
                'name'      => 'hungary',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'is',
                'name'      => 'iceland',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'in',
                'name'      => 'india',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'id',
                'name'      => 'indonesia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ir',
                'name'      => 'iran, islamic republic of',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'iq',
                'name'      => 'iraq',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ie',
                'name'      => 'ireland',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'im',
                'name'      => 'isle of man',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'il',
                'name'      => 'israel',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'it',
                'name'      => 'italy',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'jm',
                'name'      => 'jamaica',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'jp',
                'name'      => 'japan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'je',
                'name'      => 'jersey',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'jo',
                'name'      => 'jordan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'kz',
                'name'      => 'kazakhstan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ke',
                'name'      => 'kenya',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ki',
                'name'      => 'kiribati',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'kp',
                'name'      => 'korea, democratic people`s republic of',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            
            ],
            
            [
                'iso'       => 'kr',
                'name'      => 'korea, republic of',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            
            ],
            
            [
                'iso'       => 'kw',
                'name'      => 'kuwait',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            
            ],
            
            [
                'iso'       => 'kg',
                'name'      => 'kyrgyzstan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            
            ],
            [
                'iso'       => 'la',
                'name'      => 'lao people`s democratic republic',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'lv',
                'name'      => 'latvia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'lb',
                'name'      => 'lebanon',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ls',
                'name'      => 'lesotho',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'lr',
                'name'      => 'liberia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ly',
                'name'      => 'libya',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'li',
                'name'      => 'liechtenstein',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'lt',
                'name'      => 'lithuania',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'lu',
                'name'      => 'luxembourg',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mo',
                'name'      => 'macao',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mk',
                'name'      => 'macedonia, the former yugoslav republic of',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mg',
                'name'      => 'madagascar',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mw',
                'name'      => 'malawi',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'my',
                'name'      => 'malaysia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mv',
                'name'      => 'maldives',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ml',
                'name'      => 'mali',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mt',
                'name'      => 'malta',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],


            [
                'iso'       => 'mh',
                'name'      => 'marshall islands',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mq',
                'name'      => 'martinique',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mr',
                'name'      => 'mauritania',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mu',
                'name'      => 'mauritius',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'yt',
                'name'      => 'mayotte',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mx',
                'name'      => 'mexico',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'fm',
                'name'      => 'micronesia, federated states of',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'md',
                'name'      => 'moldova, republic of',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mc',
                'name'      => 'monaco',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mn',
                'name'      => 'mongolia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'me',
                'name'      => 'montenegro',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ms',
                'name'      => 'montserrat',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ma',
                'name'      => 'morocco',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mz',
                'name'      => 'mozambique',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mm',
                'name'      => 'myanmar',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'na',
                'name'      => 'namibia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'nr',
                'name'      => 'nauru',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'np',
                'name'      => 'nepal',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'nl',
                'name'      => 'netherlands',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'nc',
                'name'      => 'new caledonia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'nz',
                'name'      => 'new zealand',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ni',
                'name'      => 'nicaragua',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ne',
                'name'      => 'niger',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ng',
                'name'      => 'nigeria',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'nu',
                'name'      => 'niue',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'nf',
                'name'      => 'norfolk island',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mp',
                'name'      => 'northern mariana islands',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'no',
                'name'      => 'norway',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'om',
                'name'      => 'om',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'pk',
                'name'      => 'pakistan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'pw',
                'name'      => 'palau',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ps',
                'name'      => 'palestine, state of',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'pa',
                'name'      => 'panama',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'pg',
                'name'      => 'papua new guinea    ',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'py',
                'name'      => 'paraguay',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'pe',
                'name'      => 'peru',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ph',
                'name'      => 'philippines',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'pn',
                'name'      => 'pitcairn',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'pl',
                'name'      => 'poland',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'pt',
                'name'      => 'portugal',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'pr',
                'name'      => 'puerto rico',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'qa',
                'name'      => 'qatar',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 're',
                'name'      => 'reunion',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ru',
                'name'      => 'russian federation',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'rw',
                'name'      => 'rwanda',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'bl',
                'name'      => 'saint barthelemy',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sh',
                'name'      => 'saint helena, ascension and tristan da cunha',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'kn',
                'name'      => 'saint kitts and nevis',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'lc',
                'name'      => 'saint lucia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'mf',
                'name'      => 'saint martin (french part)',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'pm',
                'name'      => 'saint pierre and miquelon',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'vc',
                'name'      => 'saint vincent and the grenadines',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ws',
                'name'      => 'samoa',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sm',
                'name'      => 'san marino',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'st',
                'name'      => 'sao tome and principe',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sa',
                'name'      => 'saudi arabia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],


            [
                'iso'       => 'sn',
                'name'      => 'senegal',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'rs',
                'name'      => 'serbia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sc',
                'name'      => 'seychelles',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sl',
                'name'      => 'sierra leone',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sg',
                'name'      => 'singapore',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sx',
                'name'      => 'sint maarten (dutch part)',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sk',
                'name'      => 'slovakia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'si',
                'name'      => 'slovenia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sb',
                'name'      => 'solomon island',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'za',
                'name'      => 'saouth africa',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'gs',
                'name'      => 'south georgia and the south sandwich islands',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ss',
                'name'      => 'south sudan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'es',
                'name'      => 'spain',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'lk',
                'name'      => 'sri lanka',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sd',
                'name'      => 'sudan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sr',
                'name'      => 'suriname',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sj',
                'name'      => 'svalbard and jan mayen',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sz',
                'name'      => 'swaziland',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'se',
                'name'      => 'swden',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ch',
                'name'      => 'switzerland',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'sy',
                'name'      => 'syarian arab republic',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tw',
                'name'      => 'taiwan, province of china',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tj',
                'name'      => 'tajikistan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tz',
                'name'      => 'tanzania, united republic of',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'th',
                'name'      => 'thailand',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tl',
                'name'      => 'timor-leste',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tg',
                'name'      => 'togo',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tk',
                'name'      => 'tokelau',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'to',
                'name'      => 'tonga',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tt',
                'name'      => 'trinidad and tobago',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tn',
                'name'      => 'tunisia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tr',
                'name'      => 'turkey',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tm',
                'name'      => 'turkmenistan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'tc',
                'name'      => 'turks and caicos islands',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],


            [
                'iso'       => 'tv',
                'name'      => 'tuvalu',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ug',
                'name'      => 'uganda',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ua',
                'name'      => 'ukraine',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ae',
                'name'      => 'united arab emirate',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'gb',
                'name'      => 'united kingdom',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'us',
                'name'      => 'united state',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'um',
                'name'      => 'united states minor outlying islands',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'uy',
                'name'      => 'uruguay',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'uz',
                'name'      => 'uzbekistan',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'vu',
                'name'      => 'vanuatu',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 've',
                'name'      => 'venezuela, bolivarian republic of',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'vn',
                'name'      => 'vietnam',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'vg',
                'name'      => 'virgin island, british',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],
            [
                'iso'       => 'vi',
                'name'      => 'virgin island, u.s.',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],


            [
                'iso'       => 'wf',
                'name'      => 'wallis and sahara',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'eh',
                'name'      => 'western',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'ye',
                'name'      => 'yemen',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'zm',
                'name'      => 'zambia',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ],

            [
                'iso'       => 'zw',
                'name'      => 'zimbabwe',
                'currency'      => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ]
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert($country);
        }
    }
}
