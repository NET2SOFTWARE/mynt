<?php

namespace App\Http\Controllers;



use App\Contracts\EncryptInterface;
use phpseclib\Crypt\RSA;

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

        $temp = $rsa->encrypt($hashed);

//        var_dump(bin2hex($temp));

        $rsa->loadKey(file_get_contents(storage_path('remittance-public.pem')));

        var_dump($rsa->decrypt('13560b00c0523a04eb994e769af9e0c812514f471f6b56725b5de2ac56c91de08d543a6f413ce1b771c0d07728ba9ea2ac0f17b60b8d1ea65c3d47d9f99fe2f0aeece9d23037843d3dc695bfda189a17788e696ac88959ab8a1683060a61c7c9b99ca07b464199f3028c822ce1cf50714975b88c111dfacc087c2e9e73430922'));
    }
}
