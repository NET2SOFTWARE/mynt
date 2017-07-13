<?php

namespace App\Http\Controllers;

use phpseclib\Crypt\RSA;
use App\Contracts\EncryptInterface;


class TestingController extends Controller
{
    private $encrytp;

    public function __construct(EncryptInterface $encrypt)
    {
        $this->encrytp = $encrypt;
    }

    public function testing()
    {
        $rsa = new RSA();
        $rsa->loadKey(file_get_contents(storage_path('remittance-private.key')));

        $param = md5('000001201712131212000016000001201712131212000016001001001aritestID20001212jakarta021021comengineerindonesia123456fund001001001688benef1partnerTNAtest300123');
        $der = '3020300C06082A86F70D020505000410';
        $concet = $der . $param;
        $length = 128 - ((int) strlen($concet)/2) - 3;

        $temp = '';
        for ($i=0; $i<strlen($concet);$i++) {
            $temp .= 'ff';
        }

        $hashed = '0001'.$temp.'00'.$concet;

        $cipherText = $rsa->encrypt('abcdefghijklmnopqrstuvwxyz');

        echo $cipherText;

        $rsa->loadKey(file_get_contents(storage_path('remittance-public.pem')));

        echo $rsa->decrypt($cipherText);
    }
}
