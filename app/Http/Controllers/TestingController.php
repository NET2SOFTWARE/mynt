<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpseclib\Crypt\RSA;
use App\Contracts\EncryptInterface;


class TestingController extends Controller
{
    private $encrytp;

    public function __construct(EncryptInterface $encrypt)
    {
        $this->encrytp = $encrypt;
    }

    public function testing(Request $request)
    {
//
//        $param = md5('000001201712131212000016000001201712131212000016001001001aritestID20001212jakarta021021comengineerindonesia123456fund001001001688benef1partnerTNAtest300123');
//
//        $der = '3020300C06082A86F70D020505000410';
//
//        $allCombine = $der . $param;
//
//        $length = 128 - ((int) strlen($allCombine) / 2) - 3;
//
//        $temp = '';
//
//        for ($i = 0; $i < (int) $length; $i++) {
//            $temp = $temp . 'ff';
//        }
//
//        $hashedText = '00'. '01' . $temp. '00'. $allCombine;
//
//        $private = file_get_contents(storage_path('jaringajremittance.key')); //PAKE PRIVATE KEY JARING
//
//        $plaintext = $hashedText;
//
//        $keyprivate = openssl_pkey_get_private ($private);
//
//        $cipher_result = null;
//
//        openssl_private_encrypt(hex2bin($plaintext), $cipher_result, $keyprivate, OPENSSL_NO_PADDING);
//
////        return (string) 'Hasil = '. bin2hex($cipher_result);
//
//        echo 'Hasil Encrypt = ';
//
//
//        echo "\n".bin2hex($cipher_result);
////
////        //END OF ENCRYPTION
////
////        echo "\n\n";
////
////        //DECRYPTION
////        $public = file_get_contents(storage_path('AJRemittanceDev.pem'));
////
////        $cipher_text = bin2hex($cipher_result);
////
////        $keypublic = openssl_pkey_get_public($public);
////        $decrypt_result = null;
////
////        echo 'Hasil Decrypt = ';
////        var_dump(openssl_public_decrypt(hex2bin($cipher_text), $decrypt_result, $keypublic, OPENSSL_NO_PADDING));
////
////        echo "\n".bin2hex($decrypt_result);
//
//
////ENCRYPTION
//        $private = file_get_contents(storage_path('jaringajremittance.key')); //PAKE PRIVATE KEY JARING
//
//        $plaintext = '0001ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff003020300c06082a864886f70d020505000410a3c720eaaa2ffee6d7314ab5200b250d';
//
////openssl
//        $keyprivate = openssl_pkey_get_private ($private);
//        $cipher_result = null;
//
//        echo 'Hasil Encrypt = ';
//        openssl_private_encrypt(hex2bin($plaintext), $cipher_result, $keyprivate, OPENSSL_NO_PADDING);
//
//        echo "\n".bin2hex($cipher_result);
//
////END OF ENCRYPTION
//
//        echo "\n\n";
//
////DECRYPTION
//        $public = file_get_contents(storage_path('AJRemittanceDev.pem')); //PAKE PUBLIC KEY ARTAJASA
//
//        $cipher_text = '13560b00c0523a04eb994e769af9e0c812514f471f6b56725b5de2ac56c91de08d543a6f413ce1b771c0d07728ba9ea2ac0f17b60b8d1ea65c3d47d9f99fe2f0aeece9d23037843d3dc695bfda189a17788e696ac88959ab8a1683060a61c7c9b99ca07b464199f3028c822ce1cf50714975b88c111dfacc087c2e9e73430922';
//
//        $keypublic = openssl_pkey_get_public($public);
//        $decrypt_result = null;
//
//        echo 'Hasil Decrypt = ';
//        var_dump(openssl_public_decrypt(hex2bin($cipher_text), $decrypt_result, $keypublic, OPENSSL_NO_PADDING));
//
//        echo "\n".bin2hex($decrypt_result);
        // ----------------------------------

        $res = $this->encrytp->hashMD5('000006201712131212000016000170000001Rudi BatubaraAnggrek Cendrawasih VIII082124122266100030861100000038001001034688');

        return (string) $this->encrytp->encrypt($res);
    }
}
