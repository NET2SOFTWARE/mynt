<?php

namespace App\Http\Controllers;

use App\Contracts\AccountInterface;
use App\Contracts\BankInterface;
use App\Contracts\EncryptInterface;
use App\Contracts\GlobalPassbookInterface;
use App\Contracts\PassbookInterface;
use App\Contracts\RemittanceInterface;
use App\Contracts\RemittanceInquiryInterface;
use App\Contracts\TransactionInterface;
use App\Contracts\TokenInterface;
use App\Contracts\OTPInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RemittanceController extends Controller
{
    /**
     * @var RemittanceInterface
     */
    private $remittance;

    /**
     * @var AccountInterface
     */
    private $account;

    /**
     * @var PassbookInterface
     */
    private $passbook;

    /**
     * @var TransactionInterface
     */
    private $transaction;

    /**
     * @var GlobalPassbookInterface
     */
    private $global;

    /**
     * @var EncryptInterface
     */
    private $encrypt;

    /**
     * @var RemittanceInquiryInterface
     */
    private $remittanceInquiry;

    /**
     * @var BankInterface
     */
    private $bank;

    /**
     * @var
     */
    private $token;

    /**
     * @var
     */
    private $otp;

    /**
     * RemittanceController constructor.
     * @param RemittanceInterface $remittance
     * @param TransactionInterface $transaction
     * @param AccountInterface $account
     * @param PassbookInterface $passbook
     * @param GlobalPassbookInterface $global
     * @param EncryptInterface $encrypt
     * @param RemittanceInquiryInterface $remittanceInquiry
     * @param BankInterface $bank
     * @param TokenInterface $token
     * @param OTPInterface $otp
     */
    public function __construct(
        RemittanceInterface $remittance,
        TransactionInterface $transaction,
        AccountInterface $account,
        PassbookInterface $passbook,
        GlobalPassbookInterface $global,
        EncryptInterface $encrypt,
        RemittanceInquiryInterface $remittanceInquiry,
        BankInterface $bank,
        TokenInterface $token,
        OTPInterface $otp
    )
    {
        $this->remittance = $remittance;
        $this->transaction = $transaction;
        $this->account = $account;
        $this->passbook = $passbook;
        $this->global = $global;
        $this->encrypt = $encrypt;
        $this->remittanceInquiry = $remittanceInquiry;
        $this->bank = $bank;
        $this->token = $token;
        $this->otp = $otp;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        Validator::make($request->all(), [
            'referral' => 'required',
            'mynt_account_number' => 'required',
            'name' => 'required|string|max:30',
            'phone' => 'required|numeric',
            'email' => 'required',
            'address' => 'required|string|max:100',
            'country' => 'required|string|max:2',
            'birthdate' => 'required',
            'birthplace' => 'required|string|max:30',
            'occupation' => 'required|string|max:50',
            'citizenship' => 'required|string|max:30',
            'idnumber' => 'required|numeric',
            'bank' => 'required',
            'bank_account_name' => 'required|string|max:30',
            'account_number' => 'required|numeric',
            'relationship' => 'required',
            'regency' => 'required|string|max:3',
            'fundresource' => 'required|string|max:50',
            'captcha' => 'required|captcha'
        ])->validate();

        if (!$bank = $this->bank->getByCode((string) $request->input('bank'))) {
            return redirect()
                ->back()
                ->with('warning', 'Internal server error, bank code is not valid');
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

        $res = $this->remittance->create($data);

        if ($res['Response']['Code'] != '00' or $res['Response']['Description'] != 'success') {
            return redirect()
                ->back()
                ->with('warning', ucfirst($res['Response']['Description']));
            // return response()
            //     ->json(compact('res'));
        }

        $db = array_add($data, 'bank_id', $bank->id);

        if (!$remittance = $this->remittance->save($db)) {
            return redirect()
                ->back()
                ->with('warning', 'Internal server error, system could not create remittance data to database.');
        }

        Auth::user()->remittances()->attach($remittance->id);

        return redirect()
            ->back()
            ->with('success', 'Bank account was successfully registered.');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $remittance = $this->remittance->get($id);

        $stan = $this->remittance->getNewId();
        $date = Carbon::now()->toDateTimeString();
        $dateTime = date('YmdHis', strtotime($date));

        $hash = $stan.
                $dateTime.
                $remittance->instid.
                $remittance->accountid.
                $remittance->name.
                $remittance->address.
                $remittance->phonenumber.
                $remittance->idnumber.
                $remittance->accountid1.
                $remittance->instid1;

        $sign = $this->encrypt->encrypt($this->encrypt->hashMD5($hash));

        $data = (array) [
            'stan'          => $stan,
            'transdatetime' => $dateTime,
            'instid'        => $remittance->instid,
            'accountid'     => $remittance->accountid,
            'name'          => $remittance->name,
            'address'       => $remittance->address,
            'countrycode'   => $remittance->countrycode,
            'birthdate'     => str_replace('-', '', $remittance->birthdate),
            'birthplace'    => $remittance->birthplace,
            'phonenumber'   => $remittance->phonenumber,
            'email'         => $remittance->email,
            'occupation'    => $remittance->occupation,
            'citizenship'   => $remittance->citizenship,
            'idnumber'      => $remittance->idnumber,
            'fundresource'  => $remittance->fundresource,

            'accountid1'    => $remittance->accountid1,
            'instid1'       => $remittance->instid1,
            'relationship1' => $remittance->relationship1,
            'regencycode1'  => $remittance->regencycode1,
            'address1'      => $remittance->address1,
            'provcode1'     => $remittance->provcode1,
            'idnumber1'     => $remittance->idnumber1,
            'sign'          => $sign
        ];

        $this->remittance->delete((array) $data);

        Auth::user()->remittances()->detach($remittance->id);

        $this->remittance->deleteFromDB($remittance->id);

        return redirect()
            ->route('home')
            ->with('success', 'Bank account was successfully deleted.');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer(Request $request)
    {
        /**
         * UAT Remittance Inquiry Status
         */
        
        // return dd($this->inquiryStatus(31, '000062'));

        Validator::make($request->all(), [
            'sender' => 'required',
            'bank'  => 'required',
            'amount' => 'required|numeric|min:500',
            'token' => 'required',
            'captcha' => 'required|captcha'
        ])->validate();

        if ($this->account->isBalanceNull($request->input('sender'))) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors(['amount', 'Your balance amount is 0, you can not do this process.']);
        }

        if (!$this->account->isBalanceEnough($request->input('sender'), $request->input('amount'))) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Insufficient balance');
        }

        if ($this->account->isTransactionOverLimit($request->input('sender'), $request->input('amount'))) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Your transaction nominal amount exceeds the maximum limit.');
        }

        if (!$checkToken = $this->token->getLastUserReferenceToken($request->input('sender'))) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Please generate new token');
        }

        if (!$this->otp->validate($request->input('sender'), $checkToken, $request->input('token'))) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Your token not valid, please generate new token again.');
        }

        // $this->token->destroy($request->input('sender'));

        /**
         * Reset max. generate token attempt session, if OTP valid
         */
        $key = request()->headers->get('referer');
        $request->session()->forget($key);
        $request->session()->forget('freeze-' . $key . '-until');

        /**
         * UAT Remittance Inquiry Testing
         */
        
        $id = $this->inquiry($request->only(['sender', 'bank', 'amount']));

        if (is_array($id)) {
            return redirect()
                ->back()
                ->with('warning', ucfirst($id['message']));
        }

        if (!$id) {
            return redirect()
                ->back()
                ->with('warning', 'The inquiry process not clear.');
        }

        $inq = $this->remittanceInquiry->get((int) $id);
        
        // return dd($inq);

        /**
         * UAT Remittance Transfer Testing
         */

        // $inq = $this->remittanceInquiry->get(33);

        $stan = $this->remittance->getNewId();

        $sign = $stan.
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

        $signData = $this->encrypt->encrypt($this->encrypt->hashMD5($sign));

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
            'name2' => $inq->aj_name,
            'regencycode' => $inq->regencycode,
            'purposecode' => $inq->purposecode,
            'purposedesc' => $inq->purposedesc,
            'sign' => $signData,
        ];

        if (!$sender = $this->account->checkExistingAccount($inq->accountid)) {
            return redirect()
                ->back()
                ->with('warning', 'The remittance process can not be done temporarily.');
        }

        $transferRes = $this->remittance->transfer($transferData);

        if ($transferRes['Response']['Code'] != '00') {
            return redirect()
                ->back()
                ->with('warning', ucfirst($transferRes['Response']['Description']));
                // ->with('warning', 'Internal system error, Remittance transfer process error.');
        }

        if ( !$transaction = $this->transaction->save([
            'sender_account_number'     => $inq->accountid,
            'receiver_account_number'   => '000170000000',
            'terminal_id'               => '000000001',
            'amount'                    => $inq->amount,
            'status'                    => false,
            'service_id'                => 7
        ]) ) {
            return redirect()
                ->back()
                ->with('warning', 'Internal system error, transaction data could not created to db.');
        }

        if (!$senderPassbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => 0,
            'debit'             => $transaction->amount,
            'balance'           => ((int) $this->account->getLastBalance($sender->number)) - ((int) $transaction->amount)
        ])) {
            return redirect()
                ->back()
                ->with('warning', 'Internal system error, sender passbook could not created.');
        }

        $recipient = $this->account->checkExistingAccount('000170000000');

        if (!$recipientPassbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => $transaction->amount,
            'debit'             => 0,
            'balance'           => ((int) $this->account->getLastBalance($recipient->number)) + ((int) $transaction->amount)
        ])) {
            return redirect()
                ->back()
                ->with('warning', 'Internal system error, recipient passbook could not created.');
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

            return redirect()
                ->back()
                ->with('warning', 'Internal system error, recipient passbook could not created.');
        }

        /**
         * UAT Remittance, skip Inquiry Status
         */

        $inqStatus = $this->inquiryStatus($inq->id, $stan);

        if (is_array($inqStatus)) {
            return redirect()
                ->back()
                ->with('warning', ucfirst($inqStatus['message']));
                // ->with('warning', 'Internal system error, please check your account bank to validate this proses.');
        }

        return redirect()
            ->back()
            ->with('success', 'Transfer process success.');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redeem(Request $request)
    {
        Validator::make($request->all(), [
            'sender' => 'required',
            'bank'  => 'required',
            'token' => 'required',
            'captcha' => 'required|captcha'
        ])->validate();

        if ($this->account->isBalanceNull($request->input('sender'))) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors(['amount', 'Your balance amount is 0, you can not do this process.']);
        }

        if (!$checkToken = $this->token->getLastUserReferenceToken($request->input('sender'))) {
           return redirect()
               ->back()
               ->withInput($request->all())
               ->with('warning', 'Please generate new token');
        }

        if (!$this->otp->validate($request->input('sender'), $checkToken, $request->input('token'))) {
           return redirect()
               ->back()
               ->withInput($request->all())
               ->with('warning', 'Your token not valid, please generate new token again.');
        }

        $this->token->destroy($request->input('sender'));

        /**
         * Reset max. generate token attempt session, if OTP valid
         */
        $key = request()->headers->get('referer');
        $request->session()->forget($key);
        $request->session()->forget('freeze-' . $key . '-until');

        $amount = $this->account->getLastBalance($request->input('sender'));

        $params = $request->only(['sender', 'bank']);

        $dataSend = array_add($params, 'amount', $amount);

        $id = $this->inquiry($dataSend);

        if (is_array($id)) {
            return redirect()
                ->back()
                ->with('warning', ucfirst($id['message']));
        }

        if (!$id) {
            return redirect()
                ->back()
                ->with('warning', 'The inquiry process not clear.');
        }

        $inq = $this->remittanceInquiry->get((int) $id);

        $stan = $this->remittance->getNewId();

        $sign = $stan.
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

        $signData = $this->encrypt->encrypt($this->encrypt->hashMD5($sign));

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
            'name2' => $inq->name1,
            'regencycode' => $inq->regencycode,
            'purposecode' => $inq->purposecode,
            'purposedesc' => $inq->purposedesc,
            'sign' => $signData,
        ];

        if (!$sender = $this->account->checkExistingAccount($inq->accountid)) {
            return redirect()
                ->back()
                ->with('warning', 'The remittance process can not be done temporarily.');
        }

        $transferRes = $this->remittance->transfer($transferData);

        if ($transferRes['Response']['Code'] != '00') {
            return redirect()
                ->back()
                ->with('warning', ucfirst($transferRes['Response']['Description']));
                // ->with('warning', 'Internal system error, Remittance transfer process error.');
        }

        if ( !$transaction = $this->transaction->save([
            'sender_account_number'     => $inq->accountid,
            'receiver_account_number'   => '000170000000',
            'terminal_id'               => '000000001',
            'amount'                    => $inq->amount,
            'status'                    => false,
            'service_id'                => 7
        ]) ) {
            return redirect()
                ->back()
                ->with('warning', 'Internal system error, transaction data could not created to db.');
        }

        if (!$senderPassbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => 0,
            'debit'             => $transaction->amount,
            'balance'           => ((int) $this->account->getLastBalance($sender->number)) - ((int) $transaction->amount)
        ])) {
            return redirect()
                ->back()
                ->with('warning', 'Internal system error, sender passbook could not created.');
        }

        $recipient = $this->account->checkExistingAccount('000170000000');

        if (!$recipientPassbook = $this->passbook->save([
            'transaction_id'    => $transaction->id,
            'credit'            => $transaction->amount,
            'debit'             => 0,
            'balance'           => ((int) $this->account->getLastBalance($recipient->number)) + ((int) $transaction->amount)
        ])) {
            return redirect()
                ->back()
                ->with('warning', 'Internal system error, recipient passbook could not created.');
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

            return redirect()
                ->back()
                ->with('warning', 'Internal system error, recipient passbook could not created.');
        }

        $inqStatus = $this->inquiryStatus($inq->id, $stan);

        if (is_array($inqStatus)) {
            return redirect()
                ->back()
                ->with('warning', ucfirst($inqStatus['message']));
                // ->with('warning', 'Internal system error, please check your account bank to validate this proses.');
        }

        return redirect()
            ->back()
            ->with('success', 'Transfer process success.');
    }


    /**
     * @param $id
     * @return bool
     */
    private function inquiryStatus($id, $transferSTAN = null)
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

        $sign = $stan1.
                $inq->transdatetime.
                $inq->instid.
                $inq->localdatetime.
                $stan2.
                $inq->transdatetime;

        $signData = $this->encrypt->encrypt($this->encrypt->hashMD5($sign));

        $data = [
            'stan' => $stan1,
            'transdatetime' => $inq->transdatetime,
            'instid' => $inq->instid,
            'countrycode' => $inq->countrycode,
            'localdatetime' => $inq->localdatetime,
            'stan2' => $stan2,
            'transdatetime2' => $inq->transdatetime,
            'sign' => $signData
        ];

        // return $this->remittance->inquiryStatus($data);

        $res = $this->remittance->inquiryStatus($data);

        if ($res['Response']['Code'] != '00') {
            return ['status' => false, 'message' => ucfirst($res['Response']['Description'])];
            // return false;
        }

        return true;
    }

    /**
     * @param array $request
     * @return bool
     */
    private function inquiry(array $request)
    {
        $reRegister = $this->reRegister($request['bank']);

        if (is_array($reRegister)) return ['message' => ucfirst($reRegister['message'])];

        $remittance = $this->remittance->get($request['bank']);

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
            return ['message' => ucfirst($res['Response']['Description'])];
            // return false;
        }

        $data['aj_name'] = $res['BeneficiaryData']['Name'];

        if ( !$inquiry = $this->remittanceInquiry->save($data) ){
            return false;
        }

        return $inquiry->id;
    }

    public function reRegister(int $remittanceId)
    {
        $remittance = $this->remittance->get($remittanceId);

        $stan = $this->remittance->getNewId();
        $date = Carbon::now()->toDateTimeString();
        $dateTime = date('YmdHis', strtotime($date));

        $hash = $stan.
                $dateTime.
                $remittance->instid.
                $remittance->accountid.
                strtolower($remittance->name).
                strtolower($remittance->address).
                $remittance->phonenumber.
                $remittance->idnumber.
                $remittance->accountid1.
                $remittance->instid1;

        $sign = $this->encrypt->encrypt($this->encrypt->hashMD5($hash));

        $data = [
            'stan'              => $stan,
            'transdatetime'     => $dateTime,
            'instid'            => $remittance->instid,
            'accountid'         => $remittance->accountid,
            'name'              => strtolower($remittance->name),
            'address'           => strtolower($remittance->address),
            'countrycode'       => strtoupper($remittance->countrycode),
            'birthdate'         => $remittance->birthdate,
            'birthplace'        => strtolower($remittance->birthplace),
            'phonenumber'       => $remittance->phonenumber,
            'email'             => strtolower($remittance->email),
            'occupation'        => strtolower($remittance->occupation),
            'citizenship'       => strtolower($remittance->citizenship),
            'idnumber'          => $remittance->idnumber,
            'fundresource'      => strtolower($remittance->fundresource),
            'accountid1'        => $remittance->accountid1,
            'instid1'           => $remittance->instid1,
            'name1'             => strtolower($remittance->name1),
            'relationship1'     => strtolower($remittance->relationship1),
            'regencycode1'      => strtoupper($remittance->regencycode1),
            'address1'          => '',
            'provcode1'         => '',
            'idnumber1'         => '',
            'sign'              => $sign,
        ];

        $res = $this->remittance->create($data);

        if ($res['Response']['Code'] != '00' or $res['Response']['Description'] != 'success')
        {
            return ['message' => ucfirst($res['Response']['Description'])];
        }

        $remittance->stan = $stan;
        $remittance->transdatetime = $dateTime;
        $remittance->sign = $sign;
        $remittance->updated_at = Carbon::now();

        if (!$remittance->save())
        {
            return ['message' => 'Internal server error, system could not update remittance data to database.'];
        }

        return true;
    }
}
