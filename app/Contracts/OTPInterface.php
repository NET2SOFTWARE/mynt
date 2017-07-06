<?php

namespace App\Contracts;

interface OTPInterface
{
    public function generate($accountNumber);
    public function validate($accountNumber, $transactionId, $token);
}