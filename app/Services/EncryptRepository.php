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
    public function encrypt(string $plainText)
    {
        $rsa = new RSA();
        $rsa->loadKey(file_get_contents(storage_path('remittance-private.key')));
        return bin2hex($rsa->encrypt($plainText));
    }

    /**
     * @param string $cipherText
     * @return mixed
     */
    public function decrypt(string $cipherText)
    {
        $rsa = new RSA();
        $rsa->loadKey(file_get_contents(storage_path('remittance-public.pem')));
        return bin2hex($rsa->decrypt($cipherText));
    }
}