<?php

namespace App\Services;

use App\User;
use App\Contracts\RegistrationInterface;

class RegistrationRepository implements RegistrationInterface
{

    public function isUserHasRegisterInReferral(array $request)
    {
        $user = User::where('email', $request['email'])
                    ->where('phone', $request['phone'])
                    ->whereHas('members', function ($query) use ($request) {
                        $query->whereHas('companies', function ($query) use ($request) {
                            $query->where('companies.code', $request['referral']);
                        });
                    })->with('members', 'members.companies')->first();

        return (count($user) >= 1) ? true : false;
    }
}