<?php

namespace App\Contracts;


/**
 * Interface EncryptInterface
 * @package App\Contracts
 */
interface EncryptInterface
{

    /**
     * @param string $plainText
     * @return mixed
     */
    public function encrypt(string $plainText);

    /**
     * @param string $cipherText
     * @return mixed
     */
    public function decrypt(string $cipherText);

    /**
     * @param string $data
     * @return mixed
     */
    public function hashMD5(string $data);
}