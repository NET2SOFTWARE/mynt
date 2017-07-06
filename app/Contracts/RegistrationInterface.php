<?php

namespace App\Contracts;


interface RegistrationInterface
{
    public function isUserHasRegisterInReferral(array $request);
}