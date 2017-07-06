<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class MyntController
 * @package App\Http\Controllers
 */
class MyntController extends Controller
{

    /**
     * MyntController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showForm()
    {
        $email = Auth::user()->email;

        return response()
            ->view('create-pin', compact('email'), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'mynt_id' => 'required|min:6|max:16|alpha_num|unique:accounts,mynt_id'
        ], [
            'mynt_id.unique' => 'MYTN ID has taken, please insert another MYNT ID'
        ])->validate();

        $member = null;

        if (Auth::user()->roles->first()['id'] == 3 || Auth::user()->roles->first()['id'] == 4) {
            $member =  Auth::user()->members->first();
        } elseif (Auth::user()->roles->first()['id'] == 5) {
            $member =  Auth::user()->merchants->first();
        } elseif (Auth::user()->roles->first()['id'] == 6) {
            $member =  Auth::user()->companies->first();
        }

        $account = $member->accounts->first();

        $account->update([
            'mynt_id' => $request->input('mynt_id')
        ]);


        if (!$account)
            return redirect()
                ->back()
                ->with('warning', 'System can not save your MYNT-ID, please contact our administrator for this error.');

        return redirect()->intended('/home');
    }
}
