<?php

namespace App\Services;

use App\User;
use Carbon\Carbon;
use App\Models\Member;
use App\Contracts\UserInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserInterface
{
    public function attribute(array $attributes)
    {
        return ['name' => $attributes['name'], 'phone' => $attributes['phone'], 'email' => $attributes['email'], 'password' => bcrypt($attributes['password']), 'isConfirmed' => bcrypt($attributes['isConfirmed'])];
    }

    public function attemptUniqueCredential($email, $password)
    {
        return Auth::attempt(['email' => $email, 'password' => $password]);
    }

    public function save(array $data)
    {
        $user = new User;
        foreach ($data as $index => $value) {
            $user->$index = $value;
        }
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();
        return (!$user) ? false : $this->get($user->id);
    }

    public function get(int $id)
    {
        return User::find($id);
    }

    public function gets()
    {
        return User::all();
    }

    public function countUserByEmail(string $email)
    {
        $user = User::where('email', $email)->get();
        $ids = array();
        foreach ($user as $item) {
            $ids[] = $item->id;
        }
        return $ids;
    }

    public function isUserExistsByReferral(string $email, string $referral)
    {
        return (!$user = Member::where(function ($query) use ($email, $referral) {
            $query->where('email', $email)->whereHas('companies', function ($query) use ($referral) {
                $query->where('companies.code', $referral);
            });
        })->first()) ? false : (int)$user->users->first()['id'];
    }

    public function isCompany(string $email)
    {
        return (count($user = User::has('companies', '>=', 1)->where('email', $email)->first()) >= 1) ? (int)$user->id : false;
    }

    public function isMerchant(string $email)
    {
        return (count($user = User::has('merchants', '>=', 1)->where('email', $email)->first()) >= 1) ? (int)$user->id : false;
    }

    public function checkUsernameExists(string $username)
    {
        $user = User::where('name', $username)->first();

        return (bool) (count($user) >= 1) ? true : false;
    }

    public function checkEmailExists(string $email)
    {
        $user = User::where('email', $email)->first();

        return (bool) (count($user) >= 1) ? true : false;
    }

    public function checkPhoneExists(string $phone)
    {
        $user = User::where('phone', $phone)->first();

        return (bool) (count($user) >= 1) ? true : false;
    }

    public function serializePhone(string $phone)
    {
        // if (starts_with($phone, '620')) {
        //     $number = '62'. substr($phone, 3);
        // } elseif (starts_with($phone, '0')) {
        //     $number = '62'. substr($phone, 1);
        // } else {
        //     $number = $phone;
        // }

        $number = trim($phone);

        if ('+' == substr($number, 0, 1))    $number = substr($number, 1);
        if ('6208' == substr($number, 0, 4)) $number = '62' . substr($number, 3);
        if ('08' == substr($number, 0, 2))   $number = '62' . substr($number, 1);
        if ('8' == substr($number, 0, 1))    $number = '62' . $number;

        return $number;
    }

    public function checkingIsLinePhoneNumber(string $phone)
    {
        return (starts_with($phone, '6202') or starts_with($phone, '622') or starts_with($phone, '02'));
    }
}