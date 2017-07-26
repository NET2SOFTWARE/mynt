<?php

namespace App\Http\Controllers\Api;

use App\Contracts\EncryptInterface;
use App\Contracts\RemittanceInterface;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

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
     * RemittanceController constructor.
     * @param RemittanceInterface $remittance
     * @param EncryptInterface $encrypt
     */
    public function __construct(
        RemittanceInterface $remittance,
        EncryptInterface $encrypt
    )
    {
        $this->remittance = $remittance;
        $this->encrypt = $encrypt;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $remittances = Auth::user()->remittances;

        return response()
            ->json([
                'status'    => false,
                'code'      => 200,
                'message'   => config('code.200'),
                'text'      => 'Bank registration successfully.',
                'data'      => compact('remittances')
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $tempDateTime = Carbon::now()->toDayDateTimeString();
        $dateSend = date('YmdHis', strtotime($tempDateTime));
        $birthDay = date('Y-m-d', strtotime($request->input('birthdate')));

        $bank = Bank::where('bank_code', $request->input('bank'))->first();

        $data = (array) [
            'stan'          => $this->remittance->getNewId(),
            'transdatetime' => $dateSend,
            'instid'        => $request->input('referral'),
            'accountid'     => $request->input('mynt_account_number'),
            'name'          => $request->input('name'),
            'address'       => $request->input('address'),
            'countrycode'   => 'ID',
            'birthdate'     => str_replace('-', '', $birthDay),
            'birthplace'    => $request->input('birthplace'),
            'phonenumber'   => $request->input('phone'),
            'email'         => $request->input('email'),
            'occupation'    => $request->input('occupation'),
            'citizenship'   => $request->input('regency'),
            'idnumber'      => $request->input('identitynumber'),
            'fundresource'  => $request->input('fundresource'),

            'accountid1'    => $request->input('account_number'),
            'instid1'       => $request->input('bank'),
            'relationship1' => $request->input('relationship'),
            'regencycode1'  => $request->input('regency'),
            'address1'      => $request->input('address'),
            'provcode1'     => $request->input('province'),
            'idnumber1'     => $request->input('identitynumber')
        ];

        $dataMustHashed = $this->remittance->getHashCreateData((array) $data);

        $dataSend = array_add($data, 'sign', $this->encrypt->encrypt($this->encrypt->hashMD5($dataMustHashed)));

        $this->remittance->create((array) $dataSend);

        $savedData = array_set($dataSend, 'transdatetime', date('Y-m-d H:i:s', strtotime($tempDateTime)));
        $savedData = array_set($savedData, 'birthdate', $birthDay);
        $savedData = array_add($savedData, 'bank_id', $bank->id);

        $remittance = $this->remittance->save($savedData);

        Auth::user()->remittances()->attach($remittance->id);

        $remittance = Auth::user()->remittances;

        return response()
            ->json([
                'status'    => false,
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

        $data = (array) [
            'transdatetime' => date('Ymd',strtotime( Carbon::now()->toDateString())),
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

            'accountid2'    => '',
            'instid2'       => '',
            'relationship2' => '',
            'regencycode2'  => '',
            'address2'      => '',
            'provcode2'     => '',
            'idnumber2'     => '',

            'accountid3'    => '',
            'instid3'       => '',
            'relationship3' => '',
            'regencycode3'  => '',
            'address3'      => '',
            'provcode3'     => '',
            'idnumber3'     => '',

            'accountid4'    => '',
            'instid4'       => '',
            'relationship4' => '',
            'regencycode4'  => '',
            'address4'      => '',
            'provcode4'     => '',
            'idnumber4'     => '',

            'accountid5'    => '',
            'instid5'       => '',
            'relationship5' => '',
            'regencycode5'  => '',
            'address5'      => '',
            'provcode5'     => '',
            'idnumber5'     => '',
        ];

        $dataSend = array_add($data, 'sign', $this->encrypt->encrypt($this->remittance->getHashDeleteData((array) $data)));

        $this->remittance->delete((array) $dataSend);

        Auth::user()->remittances()->detach($remittance->id);

        $this->remittance->deleteFromDB($remittance->id);

        return response()
            ->json([
                'status'    => false,
                'code'      => 200,
                'message'   => config('code.200'),
                'text'      => 'Bank registration successfully deleted.',
                'data'      => null
            ]);
    }

    /**
     * @param Request $request
     */
    public function inquiry_status(Request $request)
    {
        //
    }

    /**
     * @param Request $request
     */
    public function inquiry(Request $request)
    {
        //
    }

    /**
     * @param Request $request
     */
    public function transfer(Request $request)
    {
        //
    }
}
