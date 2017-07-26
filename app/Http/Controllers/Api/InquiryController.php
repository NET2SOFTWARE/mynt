<?php

namespace App\Http\Controllers\Api;

use App\Contracts\AccountInterface;
use App\Contracts\GlobalPassbookInterface;
use App\Contracts\PassbookInterface;
use App\Contracts\TransactionInterface;
use App\Models\Account;
use App\Models\Inquiry;
use App\Models\Passbook;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Contracts\InquiryInterface;
use App\Http\Controllers\Controller;

class InquiryController extends Controller
{
    protected $account;
    protected $inquiry;
    protected $passbook;
    protected $transaction;
    private $global;

    public function __construct(
        InquiryInterface $inquiry,
        AccountInterface $account,
        PassbookInterface $passbook,
        TransactionInterface $transaction,
        GlobalPassbookInterface $global
    )
    {
        $this->inquiry  = $inquiry;
        $this->account  = $account;
        $this->passbook = $passbook;
        $this->transaction = $transaction;
        $this->global = $global;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->has('vaid') || !$request->has('account_number') || !$request->has('username') || !$request->has('signature'))
            return response()->json([
                'status'    => false,
                'code'      => '11',
                'text'      => 'Error-11',
                'message'   => 'Invalid parameter',
                'data'      => null
            ]);

        $account = Account::where('number', '=', $request->input('account_number'))
                            ->first();

        if (!$account)
            return response()->json([
                            'status'    => 'true',
                            'code'      => '02',
                            'text'      => 'Error-02',
                            'message'   => 'Unknown account',
                            'data'      => null
                        ]);

        $inquiry = $this->inquiry->save([
            'vaid'              => $request->input('vaid'),
            'account_number'    => $request->input('account_number'),
            'username'          => $request->input('username'),
            'signature'         => $request->input('signature'),
        ]);

        if (!$inquiry)
            return response()->json([
                'status'    => false,
                'code'      => '17',
                'text'      => 'Error-17',
                'message'   => 'System error',
                'data'      => null
            ]);

        if (count($account->members) > 0) {
            $name = $account->members->first()['name'];
        } elseif (count($account->merchants) > 0) {
            $name = $account->merchants->first()['name'];
        } else {
            $name = $account->companies->first()['name'];
        }

        $lastBalance = $this->account->getLastBalance($account->number);
        $limitBalance = $account->limit_balance;
        $maxAmount = (int) $limitBalance - (int) $lastBalance;

		if ((int) $maxAmount > (int) $limitBalance) $maxAmount = $limitBalance;
		elseif ((int) $maxAmount < 0) $maxAmount = 0;

        return response()
            ->json([
                'status'    => 'true',
                'code'      => '00',
                'text'      => 'Success-00',
                'message'   => 'success',
                'data'      => [
                    'reference_id'  => $inquiry->reference_id,
                    'username'      => $name,
                    'max_amount'    => $maxAmount
                ]
            ]);
    }



    public function settle(Request $request)
    {
        if (!($request->has('reference_id') && $request->has('amount')))
            return response()->json([
                'status'    => false,
                'code'      => '11',
                'text'      => 'Error-11',
                'message'   => 'Invalid parameter',
                'data'      => null
            ]);

        $amount             = $request->input('amount');
        $reference_id       = $request->input('reference_id');

        $inquiry = Inquiry::where('reference_id', '=', $reference_id)->first();

        if (!$inquiry)
            return response()->json([
                'status'    => false,
                'code'      => '16',
                'text'      => 'Error-16',
                'message'   => 'Invalid transaction ID',
                'data'      => null
            ]);

        $paid = Inquiry::where('reference_id', '=', $reference_id)
                            ->where('status', '=', true)
                            ->first();
        if ($paid)
            return response()->json([
                'status'    => false,
                'code'      => '19',
                'text'      => 'Error-19',
                'message'   => 'Already paid',
                'data'      => null
            ]);

        $account = Account::where('number', '=', $inquiry->account_number)
                            ->with('members', 'passbooks', 'transactions')->first();

        if (!$account)
            return response()->json([
                'status'    => false,
                'code'      => '01',
                'text'      => 'Error-01',
                'message'   => 'Account receiver not valid.',
                'data'      => null
            ]);

        $balance            = $account->passbooks->last()['balance'];
        $limitBalance       = $account->limit_balance;
        $limitTransaction   = $account->limit_balance_transaction;

        if (((int) $balance) + ((int) $amount) > $limitBalance)
            return response()->json([
                'status'    => false,
                'code'      => '04',
                'text'      => 'Error-04',
                'message'   => 'Over limit ',
                'data'      => null
            ]);

        if ($amount > $limitTransaction)
            return response()->json([
                'status'    => false,
                'code'      => '05',
                'text'      => 'Error-05',
                'message'   => 'Over limit monthly transaction',
                'data'      => null
            ]);

        $transaction = $this->transaction->save([
            'sender_account_number'         => config('configuration.default.account'),
            'receiver_account_number'       => $account->number,
            'terminal_id'                   => null,
            'amount'                        => $amount,
            'status'                        => false,
            'service_id'                    => 9
        ]);

        if (!$transaction)
            return response()->json([
                'status'    => false,
                'code'      => '17',
                'text'      => 'Error-17',
                'message'   => 'System error',
                'data'      => null
            ], 500);


        $lastBalance = $this->account->getLastBalance($account->number);

        $passbook = $this->passbook->save([
            'transaction_id'=> $transaction->id,
            'credit'        => $amount,
            'debit'         => 0,
            'balance'       => $lastBalance + $amount,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        if (!$passbook)
            return response()->json([
                'status'    => false,
                'code'      => '17',
                'text'      => 'Error-17',
                'message'   => 'System error',
                'data'      => null
            ], 500);

        $account->passbooks()->attach($passbook->id);

        $account->transactions()->attach($transaction->id);

        $global = $this->global->save([
            'debit'     => $amount,
            'credit'    => 0,
            'balance'   => $this->global->lastBalance() + $amount
        ]);

        if (!$global) {
            $account->passbooks()->detach($passbook->id);
            $account->transactions()->detach($transaction->id);
            $passbook->delete();
            return response()->json([
                'status'    => false,
                'code'      => '17',
                'text'      => 'Error-17',
                'message'   => 'System error',
                'data'      => null
            ], 500);
        }

        $transaction->update(['status' => true]);
        $inquiry->update(['status' => true]);

        return response()->json([
            'status'    => true,
            'code'      => '00',
            'text'      => 'Success-00',
            'message'   => 'Transaction success',
            'data'      => compact('transaction')
        ], 201);

    }
}
