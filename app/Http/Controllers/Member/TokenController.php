<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Contracts\AccountInterface;
use App\Contracts\OTPInterface;
use App\Contracts\TokenInterface;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class TokenController
 * @package App\Http\Controllers\Member
 */
class TokenController extends Controller
{

    /**
     * @var TokenInterface
     */
    private $model;

    /**
     * @var
     */
    private $account;

    /**
     * @var OTPInterface
     */
    private $otp;

    /**
     * TokenController constructor.
     * @param TokenInterface $model
     * @param AccountInterface $account
     * @param OTPInterface $otp
     */
    public function __construct(
        TokenInterface      $model,
        AccountInterface    $account,
        OTPInterface        $otp
    )
    {
        $this->model    = $model;
        $this->account  = $account;
        $this->otp      = $otp;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showForm()
    {
        $member = Auth::user()->members()->first();

        return response()
            ->view('member.token-form', compact('member'), 200);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'account_number'    => 'required|exists:accounts,number',
            'amount'            => 'required|numeric',
            'captcha'           => 'required|captcha',
        ])->validate();

        if ($this->account->isBalanceOverLimit($request->input('account_number'), $request->input('amount')))
            return redirect()
                ->back()
                ->withInput($request->except('captcha'))
                ->withErrors(['amount' => 'Your balance is not enough to transact with this nominal amount.']);

        if ($this->account->isTransactionOverLimit($request->input('account_number'), $request->input('amount')))
            return redirect()
                ->back()
                ->withInput($request->except('captcha'))
                ->with('warning', 'Your transactions up to this period have exceeded the nominal transaction limit.');

        $reference_id = $this->otp->generate($request->input('account_number'));

        if (!$reference_id) {
            return redirect()
                ->route('member.transactions.account')
                ->with('warning', 'Internal system error, system can`t get OTP server');
        }

        $token = $this->model->save([
            'account_number'    => $request->input('account_number'),
            'amount'            => $request->input('amount'),
            'reference_id'      => $reference_id
        ]);

        if (!$token) {
            return redirect()
                ->back()
                ->with('warning', 'Internal system error, system can`t get OTP server');
        }

        return redirect()
            ->back()
            ->with('success', 'We have sent the token to your mobile phone ');
    }

    /**
     * @param $account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requestToken($account, Request $request)
    {
        /**
         * Freeze generate token if user attempts (in the same page) is more than 3 times
         */
        $key = request()->headers->get('referer');
        
        $attempt = $request->session()->get($key);

        if (! $attempt) $attempt = 0;

        $attempt++;
        
        $request->session()->put($key, $attempt);

        if ((int) $attempt > 2 && ! $request->session()->has('freeze-' . $key . '-until'))
        {
            $freezeUntil = Carbon::now()->addMinute(5);
            $request->session()->put('freeze-' . $key . '-until', $freezeUntil);
        }

        if ($request->session()->has('freeze-' . $key . '-until'))
        {
            $now = Carbon::now();
            $freezeTime = $request->session()->get('freeze-' . $key . '-until');
        
            if ($now->gt($freezeTime))
            {
                $request->session()->forget($key);
                $request->session()->forget('freeze-' . $key . '-until');
            } else {
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->with('warning', 'Maximum attempt (3 time) for generating token exceed. Please wait '. $now->diffForHumans($freezeTime) .' before generating new token.');
            }
        }

        $acc = $this->account->getAccountByNumber($account);

        if (count($account) < 1)
            return redirect()
                // ->route('member.transactions.account')
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Account number unknown');

        $reference_id = $this->otp->generate($acc->number);

        if (!$reference_id) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Internal system error, system can not get OTP server');
        }

        $token = $this->model->save([
            'account_number'    => $account,
            'amount'            => 0,
            'reference_id'      => $reference_id
        ]);

        if (!$token) {
            return redirect()
                // ->route('member.transactions.account')
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Internal system error, system can`t get OTP server');
        }

        return redirect()
            // ->route('member.transactions.account')
            ->back()
            ->withInput($request->all())
            ->with('success', 'Success, token has been sent.');
    }
}