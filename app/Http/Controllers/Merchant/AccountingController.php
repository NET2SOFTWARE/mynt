<?php

namespace App\Http\Controllers\Merchant;

use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Models\Passbook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accounting()
    {
        $user = Auth::user();

        $merchant = $user->merchants->first();

        $account = $merchant->accounts->first();

        $passbooks = Passbook::whereHas('accounts', function ($query) use ($account) {
            $query->where('accounts.id', '=', $account->id);
        })->paginate((int) 15);

        return response()
            ->view('merchant.accounting', compact('passbooks'), 200);
    }

    public function sort_accounting(Request $request)
    {
        if (is_null($request->input('start_date')) && is_null($request->input('end_date'))) {
            return redirect()
                ->route('company.accounting');
        }

        $from   = date('Y-m-d H:i:s', strtotime($request->input('start_date')));
        $to     = date('Y-m-d H:i:s', strtotime($request->input('end_date')));

        $merchant = Auth::user()->merchants->first();

        $account_id = $merchant->accounts->first()['id'];

        $passbooks = Passbook::whereHas('accounts', function ($query) use ($account_id) {
                                $query->where('accounts.id', '=', $account_id);
                            })
                            ->where('created_at', '>=', $from)
                            ->where('created_at', '<=', $to)
                            ->orderBy('created_at')->paginate(15);

        $merchant = Auth::user()->merchants->first();

        return response()
            ->view('merchant.accounting', compact('passbooks', 'merchant'), 200);
    }
}
