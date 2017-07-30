<?php

namespace App\Http\Controllers\Member;

use App\Models\Area;
use App\Models\Country;
use App\User;
use App\Models\Bank;
use App\Models\Children;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function personal()
    {
        return response()
            ->view('member.management.personal', compact(null), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function bank()
    {
        $remittance = Auth::user()->remittances;

        return response()
            ->view('member.management.bank', compact('remittance'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function child()
    {
        $confirmation = Children::whereHas('users', function ($query) {
            $query->where('users.id', '=', Auth::id());
        })->get();

        $ids = array();

        foreach ($confirmation as $index) {
            $ids[] = $index->user_id;
        }

        $children = User::whereIn('users.id', $ids)->get();

        return response()
            ->view('member.management.child', compact('children'), 200);
    }


    public function showFormRegisterBank()
    {
        $banks = Bank::all();

        $regencies = Area::all();

        $countries = Country::all();

        $referral = Auth::user()->members->first()['companies'][0]['code'];

        $mynt_acc_num = Auth::user()->members->first()['accounts'][0]['number'];

        return view('member.management.bank-create', compact('banks', 'regencies', 'provinces', 'countries', 'mynt_acc_num', 'referral'));
    }

    public function showFormEditAccount()
    {
        return view('member.management.personal-edit-account');
    }

    public function showFormEditPassword()
    {
        return view('member.management.personal-edit-password');
    }

    public function showFormEditPhoto()
    {
        return view('member.management.personal-edit-photo');
    }

    public function editAccount($id, Request $request)
    {
        //
    }

    public function editPassword($id, Request $request)
    {
        //
    }

    public function editPhoto($id, Request $request)
    {
        //
    }
}
