<?php

namespace App\Http\Controllers\Member;

use App\Models\Account;
use App\Models\Area;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Contracts\OTPInterface;
use App\Contracts\TokenInterface;
use App\Contracts\AccountInterface;
use App\Http\Controllers\Controller;
use App\Contracts\PassbookInterface;
use App\Contracts\TransactionInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class TransactionController
 * @package App\Http\Controllers\Member
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

    /**
     * TransactionController constructor.
     * @param AccountInterface $account
     * @param TransactionInterface $transaction
     * @param PassbookInterface $passbook
     * @param TokenInterface $token
     * @param OTPInterface $otp
     */
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

    public function account()
    {
        return response()
            ->view('member.transaction.account', compact(null), 200);
    }

    public function bank()
    {
        $remittances = Auth::user()->remittances;

        $areas = Area::all(['name', 'code']);

        return response()
            ->view('member.transaction.bank', compact('remittances', 'areas'), 200);
    }

    public function remittance()
    {
        return response()
            ->view('member.transaction.remittance', compact(null), 200);
    }

    public function redeem()
    {
        $remittances = Auth::user()->remittances;

        return response()
            ->view('member.transaction.redeem', compact('remittances'), 200);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    public function transferToAccount(Request $request)
    {
        Validator::make($request->all(), [
            'sender'    => 'required|exists:accounts,number',
            'recipient' => 'required',
            'amount'    => 'required|numeric|min:5000',
            'captcha'   => 'required|captcha',
            'token'     => 'required|numeric|digits:6'
        ])->validate();

        $token          = $request->input('token');
        $no_sender      = $request->input('sender');
        $no_recipient   = $request->input('recipient');
        $amount         = $request->input('amount');

        if (!$checkToken = $this->token->getLastUserReferenceToken($no_sender))
            return redirect()
                ->back()
                ->with('warning', 'Please generate new token')
                ->withInput($request->except(['captcha']));

        if ( !$this->otp->validate($no_sender, $checkToken, $token) ) {
            return redirect()
                ->back()
                ->with('warning', 'Your token not valid, please generate new token again.')
                ->withInput($request->except(['captcha']));
        }

        $this->token->destroy($no_sender);

        if (!$sender = $this->account->getAccountByNumber($no_sender)) {
            return redirect()
                ->back()
                ->with('warning', 'Account sender not valid.')
                ->withInput($request->except(['captcha']));
        }

        if (!$recipient = $this->account->getAccountByMyntId($no_recipient)) {
            if (!$recipient = $this->account->getAccountByNumber($no_recipient)) {
                return redirect()
                    ->back()
                    ->with('warning', 'Account recipient not valid.')
                    ->withInput($request->except(['captcha']));
            }
        }

        if ($sender->number == $recipient->number) {
            return redirect()
                ->back()
                ->with('warning', 'Transactions can not be processed. You are trying to transfer to your own account. This is an illegal act')
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

        if (((int) $amount + (int) $this->account->getLastBalance($recipient->number)) > (int) $recipient->limit_balance) {
            return redirect()
                ->back()
                ->with('warning', 'Over limit recipient account`s balance')
                ->withInput($request->except(['captcha']));
        }

        $transaction = $this->transaction->save([
            'sender_account_number' => $no_sender,
            'receiver_account_number' => $recipient->number,
            'terminal_id' => str_replace('.', '', $request->getClientIp()),
            'amount' => $amount,
            'status' => false,
            'service_id' => 6
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

        $recipientLastBalance = $this->account->getLastBalance($recipient->number);

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