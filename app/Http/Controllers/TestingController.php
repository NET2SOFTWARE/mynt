<?php

namespace App\Http\Controllers;

use App\Contracts\BankInterface;
use App\Contracts\EncryptInterface;


class TestingController extends Controller
{
    private $encrypt;

    private $bank;

    public function __construct(
        EncryptInterface $encrypt,
        BankInterface $bank
    )
    {
        $this->encrypt = $encrypt;
        $this->bank = $bank;
    }

    public function testing()
    {
       return (string) $this->encrypt->encrypt($this->encrypt->hashMD5('0000012017072716324500001661499305208510010010201707271632450001700000027500068800600600675000614993052085ID'));
    }
}