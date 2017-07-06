<?php

namespace App\Contracts;


interface TokenInterface extends AppInterface
{
    public function attribute(array $attributes);

    public function generateToken();

    public function regenerateToken($accountNumber);

    public function isTokenExist($no_token);
    public function isTokenAmountMatch($no_token, $amount);
    public function isExpiredToken($no_token);

    public function save(array $data);
    public function destroy($account_number);
    public function getUserToken($account_number);
    public function getLastUserReferenceToken($account_number);
}