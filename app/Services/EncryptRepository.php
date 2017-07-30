<?php

namespace App\Services;

use App\Contracts\EncryptInterface;

class EncryptRepository implements EncryptInterface
{
    /**
     * @var null
     */
    private $return;

    /**
     * EncryptRepository constructor.
     */
    public function __construct()
    {
        $this->return = null;
    }

    /**
     * @param string $plainText
     * @return mixed
     */
    public function encrypt(string $plainText)
    {
        $key = openssl_pkey_get_private(file_get_contents(storage_path('jaringajremittance.key')));

        openssl_private_encrypt(hex2bin($plainText), $this->return, $key, OPENSSL_NO_PADDING);

        return (string) bin2hex($this->return);
    }

    /**
     * @param string $cipherText
     * @return mixed
     */
    public function decrypt(string $cipherText)
    {
        $key = openssl_pkey_get_public(file_get_contents(storage_path('AJRemittanceDev.pem')));

        openssl_public_decrypt(hex2bin($cipherText), $this->return, $key, OPENSSL_NO_PADDING);

        return (string) bin2hex($this->return);
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function hashMD5(string $data)
    {
        $param = md5((string) $data);

        $der = (string) '3020300C06082A864886F70D020505000410';

        $dataAll = (string) $der . $param;

        $length = (int) 128 - ((int) strlen($dataAll)/2) - 3;

        $temp = '';

        for ($i = 0; $i < $length; $i++) {
            $temp .= 'FF';
        }

        $hashed = (string) '0001' . $temp. '00' . $dataAll;

        return (string) $hashed;
    }
}