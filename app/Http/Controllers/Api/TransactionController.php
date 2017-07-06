<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Contracts\OTPInterface;
use App\Contracts\TokenInterface;
use App\Contracts\AccountInterface;
use App\Contracts\PassbookInterface;
use App\Http\Controllers\Controller;
use App\Contracts\TransactionInterface;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\Validator;

/**
 * Class TransactionController
 * @package App\Http\Controllers\Api
 */
class TransactionController extends Controller
{

    /**
     * @var TransactionInterface
     */
    private $transaction;

    /**
     * @var OTPInterface
     */
    private $otp;

    /**
     * @var TokenInterface
     */
    private $token;

    /**
     * @var AccountInterface
     */
    private $account;

    /**
     * @var
     */
    private $passbook;

    /**
     * TransactionController constructor.
     * @param TransactionInterface $transaction
     * @param OTPInterface $otp
     * @param TokenInterface $token
     * @param AccountInterface $account
     * @param PassbookInterface $passbook
     */
    public function __construct(
        TransactionInterface    $transaction,
        OTPInterface            $otp,
        TokenInterface          $token,
        AccountInterface        $account,
        PassbookInterface       $passbook
    )
    {
        $this->transaction  = $transaction;
        $this->otp          = $otp;
        $this->token        = $token;
        $this->account      = $account;
        $this->passbook     = $passbook;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = $this->transaction->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('transactions'), 200)
            : response()->view('pages.transaction', compact('transactions'), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        $transactions = $this->transaction->transactionSuccess();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('transactions'), 200)
            : response()->view('pages.transaction-success', compact('transactions'), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function refund(Request $request)
    {
        $transactions = $this->transaction->transactionRefund();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('transactions'), 200)
            : response()->view('pages.transaction-refund', compact('transactions'), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function failed(Request $request)
    {
        $transactions = $this->transaction->transactionFailed();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('transactions'), 200)
            : response()->view('pages.transaction-failed', compact('transactions'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.transaction-create', compact(null), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $transaction = $this->transaction->insert($this->transaction->attribute($request->only(
            ['sender', 'receiver', 'provider', 'amount']
        )));

        abort_unless($transaction, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('transaction'), 201)
            : redirect()->back()
                ->with(compact('transaction'))
                ->with('message', 'Transaction has added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $transaction = $this->transaction->get($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('transaction'), 200)
            : response()->view('pages.transaction-show', compact('transaction'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $transaction = $this->transaction->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.transaction-edit', compact('transaction'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransactionRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, $id)
    {
        $transaction = $this->transaction->update($id, $request->all());

        abort_unless($transaction, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('transaction'), 204)
            : redirect()->back()
                ->with(compact('transaction'))
                ->with('success', 'Transaction data was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $transaction = $this->transaction->delete($id);

        abort_unless($transaction, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Transaction data was updated successfully');
    }

    /**
     * @param $accountNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function history($accountNumber)
    {
        $transaction_history = Transaction::where('sender_account_number', '=', $accountNumber)
                                            ->orWhere('receiver_account_number', '=', $accountNumber)
                                            ->with('service')
                                            ->paginate(10);

        return response()
            ->json([
                'status'    => true,
                'code'      => 200,
                'message'   => config('code.200'),
                'data'      => compact('transaction_history')
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function request_token(Request $request)
    {
        if ( !$request->has('account_number') or !$request->has('amount'))
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 400,
                    'message'   => config('code.400'),
                    'data'      => null
                ]);

        $validator = Validator::make($request->all(), [
            'account_number'    => 'required',
            'amount'            => 'required'
        ]);

        if ($validator->fails()) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 400,
                    'message'   => config('code.400'),
                    'data'      => null
                ]);
        }

        $account = Account::where('number', '=', $request->input('account_number'));

        if (count($account) < 1)
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 404,
                    'message'   => config('code.404'),
                    'data'      => null
                ]);

        $referenceid = $this->otp->generate($request->input('account_number'));

        if (!$referenceid)
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'data'      => null
                ]);

        $token = $this->token->save([
            'account_number'    => $request->input('account_number'),
            'amount'            => $request->input('amount'),
            'reference_id'      => $referenceid
        ]);

        if (!$token)
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'data'      => null
                ]);

        return response()
            ->json([
                'status'    => true,
                'code'      => 200,
                'message'   => config('code.200'),
                'data'      => ['referenceid' => $referenceid]
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transaction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'sender'    => 'required',
            'recipient' => 'required',
            'amount'    => 'required',
            'token'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 400,
                    'message'   => config('code.400'),
                    'data'      => null
                ]);
        }


        if ( !$sender = $this->account->checkExistingAccount($request->input('sender'))  or !$recipient = $this->account->checkExistingAccount($request->input('recipient')) )
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 404,
                    'message'   => config('code.404'),
                    'data'      => null
                ], 404);


        if ( !$transactionId = $this->token->getLastUserReferenceToken($sender->number) )
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'data'      => null
                ], 500);

        if ( !$this->otp->validate($sender->number, $transactionId, $request->input('token')))
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 401,
                    'message'   => config('code.401'),
                    'data'      => null
                ], 401);

        if ($request->input('sender') == $request->input('recipient'))
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 409,
                    'message'   => config('code.409'),
                    'data'      => null
                ], 409);

        if ( !$this->account->isBalanceEnough($sender->number, $request->input('amount')) )
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 406,
                    'message'   => 'Insufficient balance',
                    'data'      => null
                ], 406);

        if ( $this->account->isBalanceOverLimit($recipient->number, $request->input('amount')) )
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 406,
                    'message'   => 'The recipient account balance exceeds the limit.',
                    'data'      => null
                ], 406);

        if ( $this->account->isTransactionOverLimit($sender->number, $request->input('amount')) )
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 406,
                    'message'   => 'The monthly transaction period exceeds the limit.',
                    'data'      => null
                ], 406);

        $transaction = $this->transaction->save([
            'sender_account_number'     => $sender->number,
            'receiver_account_number'   => $recipient->number,
            'terminal_id'               => 000000001,
            'amount'                    => $request->input('amount'),
            'status'                    => false,
            'service_id'                => 1
        ]);

        if (!$transaction)
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'data'      => null
                ], 500);

        $sender_passbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => 0,
            'debit'             => $request->input('amount'),
            'balance'           => ((int) $this->account->getLastBalance($sender->number)) - ((int) $request->input('amount'))
        ]);

        if (!$sender_passbook)
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'data'      => null
                ], 500);

        $recipient_passbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => $request->input('amount'),
            'debit'             => 0,
            'balance'           => ((int) $this->account->getLastBalance($recipient->number)) + ((int) $request->input('amount'))
        ]);

        if (!$recipient_passbook)
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'data'      => null
                ], 500);

        if (!$transaction->update(['status' => true]))
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'data'      => null
                ], 500);

        $sender->passbooks()->attach($sender_passbook->id);
        $recipient->passbooks()->attach($recipient_passbook->id);

        $sender->transactions()->attach($transaction->id);
        $recipient->transactions()->attach($transaction->id);

        return response()
            ->json([
                'status'    => true,
                'code'      => 201,
                'message'   => config('code.201'),
                'data'      => compact('transaction')
            ], 201);
    }

    /**
     * @param $trx_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_status($trx_id)
    {
        $transaction = Transaction::where('trx_id', '=', $trx_id)->with('service')->first();

        if (count($transaction) < 1)
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 404,
                    'message'   => config('code.404'),
                    'data'      => null
                ]);

        return response()
            ->json([
                'status'    => true,
                'code'      => 200,
                'message'   => config('code.200'),
                'data'      => compact('transaction')
            ]);
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route($request->input('route'));

        $transactions = Transaction::where('sender_account_number', 'LIKE', '%'.$request->input('search').'%')
            ->orWhere('receiver_account_number', 'LIKE', '%'.$request->input('search').'%')
            ->orWhereHas('service', function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%'.$request->input('search').'%');
            });

        switch ($request->input('route')) {
            case 'transaction.success.index':
                $transactions = $transactions->orWhere('status', true);
            break;

            case 'transaction.failed.index':
                $transactions = $transactions->orWhere('status', false);
            break;

            default:
            break;
        }

        $transactions = $transactions->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('transactions'), 200)
            : response()->view('pages.'.$request->input('page'), compact('transactions'), 200);
    }
}