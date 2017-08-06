<?php

namespace App\Http\Controllers\Company;

use App\Models\Passbook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $company = $user->companies->first();

        $account = $company->accounts->first();

        $passbooks = Passbook::whereHas('accounts', function ($query) use ($account) {
            $query->where('accounts.id', '=', $account->id);
        })->paginate((int) 15);

        return response()
            ->view('company.accounting', compact('passbooks', 'account'), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        $from   = date('Y-m-d', strtotime($request->input('start_date')));
        $to     = date('Y-m-d', strtotime($request->input('end_date')));

        $company = Auth::user()->companies->first();

        $account_id = $company->accounts->first()['id'];

        $passbooks = Passbook::whereHas('accounts', function ($query) use ($account_id) {
            $query->where('accounts.id', '=', $account_id);
        })
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->orderBy('created_at')->paginate(15);

        return response()
            ->view('company.accounting', compact('passbooks'), 200);
    }
}
