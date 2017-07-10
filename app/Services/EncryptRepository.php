<?php

namespace App\Services;

use phpseclib\Crypt\RSA;
use App\Contracts\EncryptInterface;

class EncryptRepository implements EncryptInterface
{
    /**
     * @param string $plainText
     * @return mixed
     */
    public function RsaEncrypt(string $plainText)
    {
        $rsa = new RSA();
        define('CRYPT_RSA_PKCS15_COMPAT', true);
        $rsa->loadKey(file_get_contents(storage_path('remittance-private.key')));
        return $rsa->encrypt($plainText);
    }

    /**
     * @param string $cipherText
     * @return mixed
     */
    public function RsaDecrypt(string $cipherText)
    {
        $rsa = new RSA();
        $rsa->loadKey(file_get_contents(storage_path('remittance-public.pem')));
        return $rsa->decrypt(base64_decode($cipherText));
    }
}