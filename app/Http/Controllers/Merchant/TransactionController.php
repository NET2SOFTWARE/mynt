<?php

namespace App\Http\Controllers\Merchant;

use App\Contracts\AccountInterface;
use App\Contracts\OTPInterface;
use App\Contracts\PassbookInterface;
use App\Contracts\TokenInterface;
use App\Contracts\TransactionInterface;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class TransactionController
 * @package App\Http\Controllers\Merchant
 */
class TransactionController extends Controller
{

    /**
     * @var AccountInterface
     */
    protected $account;

    /**
     * @var
     */
    protected $recipient;

    /**
     * @var
     */
    protected $sender;

    /**
     * @var TransactionInterface
     */
    private $transaction;

    /**
     * @var PassbookInterface
     */
    private $passbook;

    private $token;

    private $otp;


    public function __construct(
        AccountInterface        $account,
        TransactionInterface    $transaction,
        PassbookInterface       $passbook,
        TokenInterface          $token,
        OTPInterface            $otp
    )
    {
        $this->account      = $account;
        $this->transaction  = $transaction;
        $this->passbook     = $passbook;
        $this->token        = $token;
        $this->otp          = $otp;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        return response()
            ->view('merchant.transaction-account', compact(null), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function bank()
    {
        $remittances = Auth::user()->remittances;

        return response()
            ->view('merchant.transaction-bank', compact('remittances'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function remittance()
    {
        return response()
            ->view('merchant.transaction-remittance', compact(null), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function redeem()
    {
        $remittances = Auth::user()->remittances;

        return response()
            ->view('merchant.transaction-redeem', compact('remittances'), 200);
    }

    public function store_account(Request $request)
    {
        Validator::make($request->all(), [
            'sender'    => 'required|exists:accounts,number',
            'recipient' => 'required',
            'amount'    => 'required',
            'captcha'   => 'required|captcha',
//            'token'     => 'required|numeric|digits:6'
        ])->validate();

//        $token          = $request->input('token');
        $no_sender      = $request->input('sender');
        $no_recipient   = $request->input('recipient');
        $amount         = $request->input('amount');
//
//
//        $checkToken = $this->token->getLastUserReferenceToken($no_sender);
//
//        if (!$checkToken)
//            return redirect()
//                ->back()
//                ->with('warning', 'Please generate new token')
//                ->withInput($request->except(['captcha']));
//
//
//        if ( !$this->otp->validate($no_sender, $checkToken, $token) )
//            return redirect()
//                ->back()
//                ->with('warning', 'Your token not valid, please generate new token again.')
//                ->withInput($request->except(['captcha']));
//
//        $this->token->destroy($no_sender);


        $sender = Account::where('number', '=', $no_sender)->first();

        $senderNumber = $sender->number;

        if (!$sender) {
            return redirect()
                ->back()
                ->with('warning', 'Account sender not valid')
                ->withInput($request->except(['captcha']));
        }

        if (((int) $amount + (int) $this->account->getCalculateTransactionMonthly($no_sender)) > (int) $sender->limit_balance_transaction) {
            return redirect()
                ->back()
                ->with('warning', 'Over limit sender monthly transaction')
                ->withInput($request->except(['captcha']));
        }

        if ($amount  > $this->account->getLastBalance($no_sender)) {
            if (!$this->recipient)
                return redirect()
                    ->back()
                    ->with('warning', 'Insufficient balance')
                    ->withInput($request->except(['captcha']));
        }


        $recipient = Account::where('mynt_id', '=', $no_recipient)->first();

        if (!$recipient)
            $recipient = Account::where('number', '=', $no_recipient)->first();

        $recipient_number = $recipient->number;
        $recipient_limit = $recipient->limit_balance;

        if ($senderNumber == $recipient_number) {
            return redirect()
                ->back()
                ->with('warning', 'Transactions can not be processed. You are trying to transfer to your own account. This is an illegal act')
                ->withInput($request->except(['captcha']));
        }

        if (((int) $amount + (int) $this->account->getLastBalance($recipient_number)) > (int) $recipient_limit) {
            return redirect()
                ->back()
                ->with('warning', 'Over limit recipient account`s balance')
                ->withInput($request->except(['captcha']));
        }

        $transaction = $this->transaction->save([
            'sender_account_number' => $no_sender,
            'receiver_account_number' => $recipient->number,
            'terminal_id' => null,
            'amount' => $amount,
            'status' => false,
            'service_id' => 1
        ]);

        if (!$transaction) {
            return redirect()
                ->back()
                ->with('warning', 'Our system is experiencing problems at this time, please try again later.')
                ->withInput($request->except(['captcha']));
        }

        $senderLasBalance = $this->account->getLastBalance($no_sender);

        $sender_passbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => 0,
            'debit'             => $amount,
            'balance'           => $senderLasBalance - $amount
        ]);

        if (!$sender_passbook) {
            return redirect()
                ->back()
                ->with('warning', 'Our system is experiencing problems at this time, please try again later.')
                ->withInput($request->except(['captcha']));
        }

        $recipientLastBalance = $this->account->getLastBalance($recipient_number);

        $recipient_passbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => $amount,
            'debit'             => 0,
            'balance'           => $recipientLastBalance + $amount
        ]);

        if (!$recipient_passbook) {
            $sender_passbook->delete();
            return redirect()
                ->back()
                ->with('warning', 'Our system is experiencing problems at this time, please try again later.')
                ->withInput($request->except(['captcha']));
        }

        $recipient_passbook->accounts()->attach($recipient->id);
        $transaction->accounts()->attach($recipient->id);

        $sender = Account::where('number', '=', $no_sender)->first();

        $transaction->accounts()->attach($sender->id);
        $sender_passbook->accounts()->attach($sender->id);

        $transaction->update(['status' => true]);

        return redirect()
            ->back()
            ->with('success', 'Transaction success.')
            ->withInput($request->except(['captcha']));
    }
}
