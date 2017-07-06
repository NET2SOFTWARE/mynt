<?php

namespace App\Http\Controllers\Merchant;

use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function profile()
    {
        $merchant = Auth::user();

        $cities = City::all(['id', 'name']);

        return response()
            ->view('merchant.profile', compact('merchant', 'cities'), 200);
    }
}
