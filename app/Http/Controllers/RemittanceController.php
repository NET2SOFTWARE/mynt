<?php

namespace App\Http\Controllers;

use App\Contracts\EncryptInterface;
use App\Contracts\RemittanceInquiryInterface;
use App\Models\Bank;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Remittance;
use Illuminate\Http\Request;
use App\Contracts\AccountInterface;
use App\Contracts\PassbookInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use App\Contracts\RemittanceInterface;
use App\Contracts\TransactionInterface;
use App\Contracts\GlobalPassbookInterface;
use App\Http\Requests\RemittanceCreateRequest;

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

    private $inquiry;

    /**
     * RemittanceController constructor.
     * @param RemittanceInterface $remittance
     * @param TransactionInterface $transaction
     * @param AccountInterface $account
     * @param PassbookInterface $passbook
     * @param GlobalPassbookInterface $global
     * @param EncryptInterface $encrypt
     * @param RemittanceInquiryInterface $inquiry
     */
    public function __construct(
        RemittanceInterface $remittance,
        TransactionInterface $transaction,
        AccountInterface $account,
        PassbookInterface $passbook,
        GlobalPassbookInterface $global,
        EncryptInterface $encrypt,
        RemittanceInquiryInterface $inquiry
    )
    {
        $this->remittance = $remittance;
        $this->transaction = $transaction;
        $this->account = $account;
        $this->passbook = $passbook;
        $this->global = $global;
        $this->encrypt = $encrypt;
        $this->inquiry = $inquiry;
    }

    /**
     * @param RemittanceCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RemittanceCreateRequest $request)
    {
        $tempDate = Carbon::now()->toDateTimeString();
        $transdatetime = date('Y-m-d H:i:s', strtotime($tempDate));
        $birthdate = date('Y-m-d', strtotime($request->input('birthdate')));

        $bank = Bank::where('bank_code', $request->input('bank'))->first();
        $stan = $this->remittance->getNewId();

        $data = [
            'stan'          => $stan,
            'transdatetime' => $transdatetime,
            'instid'        => $request->input('referral'),
            'accountid'     => $request->input('mynt_account_number'),
            'name'          => $request->input('name'),
            'address'       => $request->input('address'),
            'countrycode'   => $request->input('country'),
            'birthdate'     => $birthdate,
            'birthplace'    => $request->input('birthplace'),
            'phonenumber'   => $request->input('phone'),
            'email'         => $request->input('email'),
            'occupation'    => $request->input('occupation'),
            'citizenship'   => $request->input('citizenship'),
            'idnumber'      => $request->input('idnumber'),
            'fundresource'  => $request->input('fundresource'),

            'accountid1'    => $request->input('account_number'),
            'instid1'       => $request->input('bank'),
            'name1'         => $request->input('bank_account_name'),
            'relationship1' => $request->input('relationship'),
            'regencycode1'  => $request->input('regency'),
            'address1'      => null,
            'provcode1'     => null,
            'idnumber1'     => null,
            'bank_id'       => $bank->id,
        ];

        $savedData = array_add($data, 'sign', $this->encrypt->encrypt($this->encrypt->hashMD5($this->remittance->getHashCreateData($data))));

        if (!$remittance = $this->remittance->save($savedData)) {
            return redirect()
                ->back()
                ->with('warning', 'Internal server error, system could not create remittance data to database.');
        }

        $dataSend1 = array_set($savedData, 'transdatetime', date('YmdHis', strtotime($tempDate)));
        $dataSend2 = array_set($dataSend1, 'birthdate', date('Ymd', strtotime($birthdate)));
        $dataSend3 = array_except($dataSend2, ['bank_id']);

//        if (!$this->remittance->create((array) $dataSend3)) {
//            $remittance->delete();
//            return redirect()
//                ->back()
//                ->with('success', 'Internal server error, remittance registration error');
//        }

        $this->remittance->create((array) $dataSend3);

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

        $data = (array) [
            'stan'          => $remittance->stan,
            'transdatetime' => date('YmdHis',strtotime( Carbon::now()->toDateString())),
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
            'sign'          => $remittance->sign
        ];

        $this->remittance->delete((array) $data);

        Auth::user()->remittances()->detach($remittance->id);

        $this->remittance->deleteFromDB($remittance->id);

        return redirect()
            ->route('home')
            ->with('success', 'Bank account was successfully deleted.');
    }


    public function transfer(Request $request)
    {
        $inquiry = $this->inquiry->get($request->input('id'));

        $transferData = [
            'stan'          => $inquiry->stan,
            'transdatetime' => $inquiry->stan,
            'instid'        => '',
            'proccode'      => '',
            'channeltype'   => '',
            'refnumber'     => '',
            'terminalid'    => '',
            'countrycode'   => '',
            'localdatetime' => '',
            'accountid'     => '',
            'name'          => '',
            'currcode'      => '',
            'amount'        => '',
            'rate'          => '',
            'areacode'      => '',
            'instid2'       => '',
            'accountid2'    => '',
            'currcode2'     => '',
            'amount2'       => '',
            'custrefnumber' => '',
            'name2'         => '',
            'regencycode'   => '',
            'purposecode'   => '',
            'purposedesc'   => '',
            'sign'          => ''
        ];

        $sender = $this->account->checkExistingAccount($inquiry->accountid);

        if (!$transferRes = $this->remittance->transfer($transferData)) {
            return redirect()
                ->back()
                ->with('warning', 'Internal system error, transfer process error.');
        }

        if ( !$transaction = $this->transaction->save([
            'sender_account_number'     => $inquiry->accountid,
            'receiver_account_number'   => '000170000000',
            'terminal_id'               => '000000001',
            'amount'                    => '$inquiry->amount',
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

        return redirect()
            ->back()
            ->with('success', 'Transfer process success.');
    }


    public function redeem(Request $request)
    {
        $inquiry = $this->inquiry->get($request->input('id'));

        $transferData = [
            'stan'          => '',
            'transdatetime' => '',
            'instid'        => '',
            'proccode'      => '',
            'channeltype'   => '',
            'refnumber'     => '',
            'terminalid'    => '',
            'countrycode'   => '',
            'localdatetime' => '',
            'accountid'     => '',
            'name'          => '',
            'currcode'      => '',
            'amount'        => '',
            'rate'          => '',
            'areacode'      => '',
            'instid2'       => '',
            'accountid2'    => '',
            'currcode2'     => '',
            'amount2'       => '',
            'custrefnumber' => '',
            'name2'         => '',
            'regencycode'   => '',
            'purposecode'   => '',
            'purposedesc'   => '',
            'sign'          => ''
        ];

        $sender = $this->account->checkExistingAccount($inquiry->accountid);

        if (!$transferRes = $this->remittance->transfer($transferData)) {
            return redirect()
                ->back()
                ->with('warning', 'Internal system error, transfer process error.');
        }

        if ( !$transaction = $this->transaction->save([
            'sender_account_number'     => $inquiry->accountid,
            'receiver_account_number'   => '000170000000',
            'terminal_id'               => '000000001',
            'amount'                    => '$inquiry->amount',
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

        return redirect()
            ->back()
            ->with('success', 'Transfer process success.');
    }


    public function inquiryStatus(Request $request)
    {
        $data = [
            // Transaction ID
            'stan'              => $this->remittance->getNewId(),
            'transdatetime'     => date('Ymd', Carbon::now()),
            'instid'            => '',

            // Transaction info
            'countrycode'       => '',
            'localdatetime'     => '',

            // Query transaction ID
            'stan1'             => '',
            'transdatetime1'    => date('Ymd', Carbon::now()),
        ];
    }

    private function inquiry(Request $request)
    {

        $inquiryData = [
            'stan'          => '',
            'transdatetime' => '',
            'instid'        => '',
            'proccode'      => '',
            'channeltype'   => '',
            'refnumber'     => '',
            'terminalid'    => '',
            'countrycode'   => '',
            'localdatetime' => '',
            'accountid'     => '',
            'name'          => '',
            'currcode'      => '',
            'amount'        => '',
            'rate'          => '',
            'areacode'      => '',
            'instid2'       => '',
            'accountid2'    => '',
            'currcode2'     => '',
            'amount2'       => '',
            'custrefnumber' => '',
            'regencycode'   => '',
            'purposecode'   => '',
            'purposedesc'   => '',
            'sign'          => ''
        ];

        $remittance = $this->remittance->get($request->input('bank'));

        $date = Carbon::now()->toDateTimeString();

        $dateTemp = date('YmdHis', strtotime($date));

        $data = (array) [
            'stan'				=> $this->remittance->getNewId(),
            'transdatetime'		=> $dateTemp,
            'instid'			=> '',

            'proccode'			=> '',
            'channeltype'		=> '6014',
            'refnumber'			=> rand (100000000000, 999999999999),
            'terminalid'		=> str_replace('.', '', $request->ip()),
            'countrycode'		=> 'ID',
            'localdatetime'		=> $dateTemp,

            'accountid'			=> $remittance->accountid,
            'name'				=> $remittance->name,
            'currcode'			=> 'IDR',
            'amount'			=> $request->input('amount'),
            'rate'				=> 0,
            'areacode'			=> $remittance->citizenship,

            'instid1'           => $request->input('bank_code'),
            'accountid1'        => $remittance->accountid,
            'currcode1'			=> 'IDR',
            'amount1'			=> $request->input('amount'),
            'custrefnumber'		=> rand (100000000000, 999999999999),
            'regencycode'		=> $remittance->regencycode1,
            'purposecode'		=> $request->input('purposecode'),
            'purposedesc'		=> $request->input('purposedesc'),
        ];

        if (!$sign = $this->encrypt->encrypt((string) $this->encrypt->hashMD5((string) $this->remittance->getHashInquiryData((array) $data)))) {
            return false;
        }

        $dataSend = array_add($data, 'sign', $sign);

        if (!$resHttpInquiry = $this->remittance->inquiry((array) $dataSend)) {
            return false;
        }

        $dataDB = array_set($data, 'transdatetime', date('Y-m-d H:i:s', strtotime($date)));
        $dataDB = array_set($dataDB, 'localdatetime', date('Y-m-d', strtotime($date)));
        $dataDB = array_add($dataDB, 'sign', $sign);

        $resDB = $this->inquiry->save($dataDB);

        return (bool) (!$resDB) ? false : $resDB->id;
    }
}
