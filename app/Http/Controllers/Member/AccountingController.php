<?php

namespace App\Http\Controllers\Member;

use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Models\Passbook;
use Illuminate\Support\Facades\Auth;

class AccountingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $member = $user->members->first();

        $account = $member->accounts->first();

        $passbooks = Passbook::whereHas('accounts', function ($query) use ($account) {
            $query->where('accounts.id', '=', $account->id);
        })->paginate((int) 15);

        return response()
            ->view('member.accounting.index', compact('passbooks', 'account'), 200);
    }

    public function show($id)
    {
        $account = Account::find($id);

        return response()
            ->view('member.accounting.show', compact('account'), 200);
    }
}
