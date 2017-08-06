<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PassbookInterface;
use App\Contracts\TransactionInterface;
use Carbon\Carbon;
use App\Services\BankRepository;
use App\Contracts\EncryptInterface;
use App\Contracts\AccountInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Contracts\RemittanceInterface;
use Illuminate\Support\Facades\Validator;
use App\Contracts\RemittanceInquiryInterface;
use App\Contracts\OTPInterface;
use App\Contracts\TokenInterface;

class RemittanceController extends Controller
{
    /**
     * @var RemittanceInterface
     */
    private $remittance;

    /**
     * @var EncryptInterface
     */
    private $encrypt;

    /**
     * @var
     */
    private $bank;

    /**
     * @var
     */
    private $account;

    /**
     * @var RemittanceInquiryInterface
     */
    private $remittanceInquiry;

    /**
     * @var
     */
    private $transaction;

    private $passbook;

    private $token;

    private $otp;

    /**
     * RemittanceController constructor.
     * @param RemittanceInterface $remittance
     * @param EncryptInterface $encrypt
     * @param BankRepository $bank
     * @param RemittanceInquiryInterface $remittanceInquiry
     * @param AccountInterface $account
     * @param TransactionInterface $transaction
     * @param RemittanceInquiryInterface $inquiry
     * @param PassbookInterface $passbook
     */
    public function __construct(
        RemittanceInterface $remittance,
        EncryptInterface $encrypt,
        BankRepository $bank,
        RemittanceInquiryInterface $remittanceInquiry,
        AccountInterface $account,
        TransactionInterface $transaction,
        RemittanceInquiryInterface $inquiry,
        PassbookInterface $passbook,
        TokenInterface $token,
        OTPInterface $otp
    )
    {
        $this->remittance = $remittance;
        $this->encrypt = $encrypt;
        $this->bank = $bank;
        $this->remittanceInquiry = $remittanceInquiry;
        $this->account = $account;
        $this->transaction = $transaction;
        $this->passbook = $passbook;
        $this->token = $token;
        $this->otp = $otp;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $remittances = Auth::user()->remittances;

        return response()
            ->json([
                'status'    => true,
                'code'      => 200,
                'message'   => config('code.200'),
                'text'      => 'List of registered bank accounts.',
                'data'      => compact('remittances')
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mynt_account_number' => 'required',
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'birthdate' => 'required',
            'birthplace' => 'required',
            'email' => 'required',
            'occupation' => 'required',
            'citizenship' => 'required',
            'idnumber' => 'required',
            'fundresource' => 'required',
            'account_number' => 'required',
            'bank' => 'required',
            'bank_account_name' => 'required',
            'relationship' => 'required',
            'regency' => 'required',
            'phone' => 'required'
        ]);

        if ($validator->fails())
        {
            $errors = $validator->errors();

            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Invalid parameter. ' . implode(' ', $errors->all()),
                    'data'      => compact(null)
                ], 200);
        }

        if (!$bank = $this->bank->getByCode((string) $request->input('bank'))) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Bank registration error, your bank ID not valid.',
                    'data'      => compact('remittance')
                ]);
        }

        $date = Carbon::now()->toDateTimeString();
        $dateTime = date('YmdHis', strtotime($date));
        $phone = '62'. $request->input('phone');
        $id = $this->remittance->getNewId();

        $hash = $id.
            $dateTime.
            '000016'.
            $request->input('mynt_account_number').
            strtolower($request->input('name')).
            strtolower($request->input('address')).
            $phone.
            $request->input('idnumber').
            $request->input('account_number').
            $request->input('bank');

        $rsa = $this->encrypt->encrypt($this->encrypt->hashMD5($hash));

        $data = [
            'stan'              => $id,
            'transdatetime'     => $dateTime,
            'instid'            => '000016',
            'accountid'         => $request->input('mynt_account_number'),
            'name'              => strtolower($request->input('name')),
            'address'           => strtolower($request->input('address')),
            'countrycode'       => strtoupper($request->input('country')),
            'birthdate'         => date('Ymd', strtotime($request->input('birthdate'))),
            'birthplace'        => strtolower($request->input('birthplace')),
            'phonenumber'       => $phone,
            'email'             => strtolower($request->input('email')),
            'occupation'        => strtolower($request->input('occupation')),
            'citizenship'       => strtolower($request->input('citizenship')),
            'idnumber'          => $request->input('idnumber'),
            'fundresource'      => strtolower($request->input('fundresource')),
            'accountid1'        => $request->input('account_number'),
            'instid1'           => $request->input('bank'),
            'name1'             => strtolower($request->input('bank_account_name')),
            'relationship1'     => strtolower($request->input('relationship')),
            'regencycode1'      => strtoupper($request->input('regency')),
            'address1'          => '',
            'provcode1'         => '',
            'idnumber1'         => '',
            'sign'              => $rsa,
        ];

        if (!$this->remittance->create((array) $data)) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.200'),
                    'text'      => 'Bank registration error, please check again your date.',
                    'data'      => compact('remittance')
                ]);
        }

        $data = array_add($data, 'bank_id', $bank->id);

        if (!$remittance = $this->remittance->save($data)) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Bank registration error, remittance data could not saved, please check your data.',
                    'data'      => null
                ]);
        }

        $remittance->users()->attach(Auth::id());

        return response()
            ->json([
                'status'    => true,
                'code'      => 200,
                'message'   => config('code.200'),
                'text'      => 'Bank registration successfully.',
                'data'      => compact('remittance')
            ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_account($id)
    {
        $remittance = $this->remittance->get($id);

        $remittance->users()->detach(Auth::id());

//        if (!$this->remittance->deleteRemittanceDb($remittance->id)) {
//            return response()
//                ->json([
//                    'status'    => false,
//                    'code'      => 500,
//                    'message'   => config('code.500'),
//                    'text'      => 'Process delete bank`s account error, please check your data.',
//                    'data'      => compact('remittance')
//                ]);
//        }

        return response()
            ->json([
                'status'    => true,
                'code'      => 200,
                'message'   => config('code.200'),
                'text'      => 'Delete bank`s account success.',
                'data'      => null
            ]);
    }


    /**
     * @param Request $request
     * @return bool
     */
    public function redeem(Request $request)
    {
        Validator::make($request->all(), [
            'sender' => 'required',
            'bank'  => 'required',
            'token' => 'required'
        ])->validate();

        if ($this->account->isBalanceNull($request->input('sender'))) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Your balance amount is 0, you can not do this process.',
                    'data'      => null
                ]);
        }

        if (!$checkToken = $this->token->getLastUserReferenceToken($request->input('sender'))) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Please generate new token.',
                    'data'      => null
                ]);
        }

        if (!$this->otp->validate($request->input('sender'), $checkToken, $request->input('token'))) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Your token not valid, please generate new token again.',
                    'data'      => null
                ]);
        }

        $this->token->destroy($request->input('sender'));

        // if (!$request->ajax() || !$request->isJson())
        // {
        //     /**
        //      * Reset max. generate token attempt session, if OTP valid
        //      */
        //     $key = request()->headers->get('referer');
        //     $request->session()->forget($key);
        //     $request->session()->forget('freeze-' . $key . '-until');
        // }

        $amount = $this->account->getLastBalance($request->input('sender'));

        $params = $request->only(['sender', 'bank']);

        $dataSend = array_add($params, 'amount', $amount);

        if (!$id = $this->inquiry($dataSend)) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'The inquiry process not clear.',
                    'data'      => null
                ]);
        }

        $inq = $this->remittanceInquiry->get((int) $id);

        $stan = $this->remittance->getNewId();

        $hash = $stan.
                $inq->transdatetime.
                $inq->instid.
                $inq->refnumber.
                $inq->terminalid.
                $inq->localdatetime.
                $inq->accountid.
                $inq->amount.
                $inq->instid2.
                $inq->accountid2.
                $inq->amount2.
                $inq->custrefnumber.
                $inq->countrycode;

        $sign = $this->encrypt->encrypt($this->encrypt->hashMD5($hash));

        $transferData = [
            'stan' => $stan,
            'transdatetime' => $inq->transdatetime,
            'instid' => $inq->instid,
            'proccode' => $inq->proccode,
            'channeltype' => $inq->channeltype,
            'refnumber' => $inq->refnumber,
            'terminalid' => $inq->terminalid,
            'countrycode' => $inq->countrycode,
            'localdatetime' => $inq->localdatetime,
            'accountid' => $inq->accountid,
            'name' => $inq->name,
            'currcode' => $inq->currcode,
            'amount' => $inq->amount,
            'rate' => $inq->rate,
            'areacode' => $inq->areacode,
            'instid2' => $inq->instid2,
            'accountid2' => $inq->accountid2,
            'currcode2' => $inq->currcode2,
            'amount2' => $inq->amount2,
            'custrefnumber' => $inq->custrefnumber,
            'name2' => 'YUSAK TIADA TARA',
            'regencycode' => $inq->regencycode,
            'purposecode' => $inq->purposecode,
            'purposedesc' => $inq->purposedesc,
            'sign' => $sign,
        ];

        if (!$sender = $this->account->checkExistingAccount($inq->accountid)) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'The remittance process can not be done temporarily.',
                    'data'      => null
                ]);
        }

        $transferRes = $this->remittance->transfer($transferData);

        if ($transferRes['Response']['Code'] != '00') {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, Remittance transfer process error.',
                    'data'      => null
                ]);
        }

        if ( !$transaction = $this->transaction->save([
            'sender_account_number'     => $inq->accountid,
            'receiver_account_number'   => '000170000000',
            'terminal_id'               => '000000001',
            'amount'                    => $inq->amount,
            'status'                    => false,
            'service_id'                => 7
        ]) ) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, transaction data could not created to db.',
                    'data'      => null
                ]);
        }

        if (!$senderPassbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => 0,
            'debit'             => $transaction->amount,
            'balance'           => ((int) $this->account->getLastBalance($sender->number)) - ((int) $transaction->amount)
        ])) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, sender passbook could not created.',
                    'data'      => null
                ]);
        }

        $recipient = $this->account->checkExistingAccount('000170000000');

        if (!$recipientPassbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => $transaction->amount,
            'debit'             => 0,
            'balance'           => ((int) $this->account->getLastBalance($recipient->number)) + ((int) $transaction->amount)
        ])) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, recipient passbook could not created.',
                    'data'      => null
                ]);
        }

        $sender->passbooks()->attach($senderPassbook->id);
        $recipient->passbooks()->attach($recipientPassbook->id);

        $sender->transactions()->attach($transaction->id);
        $recipient->transactions()->attach($transaction->id);

        if (!$transaction->update(['status' => true])) {
            $sender->passbooks()->detach($senderPassbook->id);
            $recipient->passbooks()->detach($recipientPassbook->id);
            $sender->transactions()->detach($transaction->id);
            $recipient->transactions()->detach($transaction->id);
            $recipientPassbook->delete();
            $senderPassbook->delete();

            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, recipient passbook could not created.',
                    'data'      => null
                ]);
        }

        if (!$this->inquiry_status($inq->id, $stan)) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, please check your account bank to validate this proses.',
                    'data'      => null
                ]);
        }

        return response()
            ->json([
                'status'    => true,
                'code'      => 200,
                'message'   => config('code.200'),
                'text'      => 'Redeem process success.',
                'data'      => compact('transferData')
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer(Request $request)
    {
        Validator::make($request->all(), [
            'sender' => 'required',
            'bank'  => 'required',
            'amount' => 'required|numeric|min:500',
            'token' => 'required',
        ])->validate();

        if ($this->account->isBalanceNull($request->input('sender'))) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Your balance amount is 0, you can not do this process.',
                    'data'      => null
                ]);
        }

        if (!$this->account->isBalanceEnough($request->input('sender'), $request->input('amount'))) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Insufficient balance',
                    'data'      => null
                ]);
        }

        if ($this->account->isTransactionOverLimit($request->input('sender'), $request->input('amount'))) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Your transaction nominal amount exceeds the maximum limit.',
                    'data'      => null
                ]);
        }

        if (!$checkToken = $this->token->getLastUserReferenceToken($request->input('sender'))) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Please generate new token.',
                    'data'      => null
                ]);
        }

        if (!$this->otp->validate($request->input('sender'), $checkToken, $request->input('token'))) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Your token not valid, please generate new token again.',
                    'data'      => null
                ]);
        }

        $this->token->destroy($request->input('sender'));

        // if (!$request->ajax() || !$request->isJson())
        // {
        //     /**
        //      * Reset max. generate token attempt session, if OTP valid
        //      */
        //     $key = request()->headers->get('referer');
        //     $request->session()->forget($key);
        //     $request->session()->forget('freeze-' . $key . '-until');
        // }

        if (!$id = $this->inquiry($request->only(['sender', 'bank', 'amount']))) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'The inquiry process not clear.',
                    'data'      => null
                ]);
        }

        $inq = $this->remittanceInquiry->get((int) $id);

        $stan = $this->remittance->getNewId();

        $hash = $stan.
                $inq->transdatetime.
                $inq->instid.
                $inq->refnumber.
                $inq->terminalid.
                $inq->localdatetime.
                $inq->accountid.
                $inq->amount.
                $inq->instid2.
                $inq->accountid2.
                $inq->amount2.
                $inq->custrefnumber.
                $inq->countrycode;

        $sign = $this->encrypt->encrypt($this->encrypt->hashMD5($hash));

        $transferData = [
            'stan' => $stan,
            'transdatetime' => $inq->transdatetime,
            'instid' => $inq->instid,
            'proccode' => $inq->proccode,
            'channeltype' => $inq->channeltype,
            'refnumber' => $inq->refnumber,
            'terminalid' => $inq->terminalid,
            'countrycode' => $inq->countrycode,
            'localdatetime' => $inq->localdatetime,
            'accountid' => $inq->accountid,
            'name' => $inq->name,
            'currcode' => $inq->currcode,
            'amount' => $inq->amount,
            'rate' => $inq->rate,
            'areacode' => $inq->areacode,
            'instid2' => $inq->instid2,
            'accountid2' => $inq->accountid2,
            'currcode2' => $inq->currcode2,
            'amount2' => $inq->amount2,
            'custrefnumber' => $inq->custrefnumber,
            'name2' => 'YUSAK TIADA TARA',
            'regencycode' => $inq->regencycode,
            'purposecode' => $inq->purposecode,
            'purposedesc' => $inq->purposedesc,
            'sign' => $sign,
        ];

        if (!$sender = $this->account->checkExistingAccount($inq->accountid)) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'The remittance process can not be done temporarily.',
                    'data'      => null
                ]);
        }

        $transferRes = $this->remittance->transfer($transferData);

        if ($transferRes['Response']['Code'] != '00') {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, Remittance transfer process error.',
                    'data'      => null
                ]);
        }

        if ( !$transaction = $this->transaction->save([
            'sender_account_number'     => $inq->accountid,
            'receiver_account_number'   => '000170000000',
            'terminal_id'               => '000000001',
            'amount'                    => $inq->amount,
            'status'                    => false,
            'service_id'                => 7
        ]) ) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, transaction data could not created to db.',
                    'data'      => null
                ]);
        }

        if (!$senderPassbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => 0,
            'debit'             => $transaction->amount,
            'balance'           => ((int) $this->account->getLastBalance($sender->number)) - ((int) $transaction->amount)
        ])) {
            return response()
            ->json([
                'status'    => false,
                'code'      => 500,
                'message'   => config('code.500'),
                'text'      => 'Internal system error, sender passbook could not created.',
                'data'      => null
            ]);
        }

        $recipient = $this->account->checkExistingAccount('000170000000');

        if (!$recipientPassbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => $transaction->amount,
            'debit'             => 0,
            'balance'           => ((int) $this->account->getLastBalance($recipient->number)) + ((int) $transaction->amount)
        ])) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, recipient passbook could not created.',
                    'data'      => null
                ]);
        }

        $sender->passbooks()->attach($senderPassbook->id);
        $recipient->passbooks()->attach($recipientPassbook->id);

        $sender->transactions()->attach($transaction->id);
        $recipient->transactions()->attach($transaction->id);

        if (!$transaction->update(['status' => true])) {
            $sender->passbooks()->detach($senderPassbook->id);
            $recipient->passbooks()->detach($recipientPassbook->id);
            $sender->transactions()->detach($transaction->id);
            $recipient->transactions()->detach($transaction->id);
            $recipientPassbook->delete();
            $senderPassbook->delete();

            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, recipient passbook could not created.',
                    'data'      => null
                ]);
        }

        if (!$this->inquiry_status($inq->id, $stan)) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 500,
                    'message'   => config('code.500'),
                    'text'      => 'Internal system error, please check your account bank to validate this proses.',
                    'data'      => null
                ]);
        }

        return response()
            ->json([
                'status'    => true,
                'code'      => 200,
                'message'   => config('code.200'),
                'text'      => 'Transfer process success.',
                'data'      => compact('transferData')
            ]);
    }

    /**
     * @param array $request
     * @return bool
     */
    private function inquiry(array $request)
    {
        $remittance = $this->remittance->get($request['bank']);

        // $stan = $this->remittanceInquiry->getLastKey();
        $stan = $this->remittance->getNewId();
        $refNumber = random_int(100000000000, 999999999999);
        $transDate = date('YmdHis', strtotime(Carbon::now()->toDateTimeString()));
        $amount = $request['amount'];

        $encrypt = $stan.
            $transDate.
            '000016'.
            $refNumber.
            '10010010'.
            $transDate.
            $remittance->accountid.
            $amount.
            $remittance->instid1.
            $remittance->accountid1.
            $amount.
            $refNumber.
            'ID';

        $sign = $this->encrypt->encrypt($this->encrypt->hashMD5($encrypt));

        $data = [
            'stan'              => $stan,
            'transdatetime'     => $transDate,
            'instid'            => '000016',
            'proccode'          => '390000',
            'channeltype'       => '6014',
            'refnumber'         => $refNumber,
            'terminalid'        => '10010010',
            'countrycode'       => 'ID',
            'localdatetime'     => $transDate,
            'accountid'         => $remittance->accountid,
            'name'              => $remittance->name,
            'currcode'          => '360',
            'amount'            => $amount,
            'rate'              => '1',
            'areacode'          => '391',
            'instid2'           => $remittance->instid1,
            'accountid2'        => $remittance->accountid1,
            'currcode2'         => '360',
            'amount2'           => $amount,
            'custrefnumber'     => $refNumber,
            'regencycode'       => $remittance->regencycode1,
            'purposecode'       => '3',
            'purposedesc'       => 'other',
            'sign'              => $sign
        ];

        $res = $this->remittance->inquiry($data);

        if ($res['Response']['Code'] != '00') {
            return false;
        }

        if ( !$inquiry = $this->remittanceInquiry->save($data) ){
            return false;
        }

        return $inquiry->id;
    }

    /**
     * @param $id
     * @return bool
     */
    public function inquiry_status($id, $transferSTAN = null)
    {
        $inq = $this->remittanceInquiry->get((int) $id);

        $stan1 = $this->remittance->getNewId();

        $stan2 = $transferSTAN;

        if (!$transferSTAN)
        {
            $stan2 = (int) $inq->stan;
            $stan2 = $stan2 + 1;
            $stan2 = str_pad($stan2, 6, '0', STR_PAD_LEFT);
        }

        $hash = $stan1.
                $inq->transdatetime.
                $inq->instid.
                $inq->localdatetime.
                $stan2.
                $inq->transdatetime;

        $sign = $this->encrypt->encrypt($this->encrypt->hashMD5($hash));

        $data = [
            'stan' => $stan1,
            'transdatetime' => $inq->transdatetime,
            'instid' => $inq->instid,
            'countrycode' => $inq->countrycode,
            'localdatetime' => $inq->localdatetime,
            'stan2' => $stan2,
            'transdatetime2' => $inq->transdatetime,
            'sign' => $sign
        ];

        if (!$this->remittance->inquiryStatus($data)) {
            return false;
        }

        return true;
    }
}
