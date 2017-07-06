<?php

namespace App\Http\Controllers\Member;

use App\Models\Bank;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::all();

        return response()
            ->view('member.management.bank', compact('banks'), 200);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'bank'  => 'required|exists:banks,id',
            'bank_account_name' => 'required|numeric'
        ])->validate();

        $bank = Bank::find($request->input('bank'));

        if (!$bank) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors(['bank', 'Bank unknown']);
        }

        $member = Member::whereHas('users', function ($query) {
            $query->where('users.id', Auth::id());
        })->first();

        if (!$member) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Internal system error.');
        }

        $member->banks()->save($bank, ['account_number' => $request->input('bank_account_name')]);

        if (!$member) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Internal system error.');
        }

        return redirect()
            ->back()
            ->withInput($request->all())
            ->with('success', 'Bank account has successfully added.');

    }
}
