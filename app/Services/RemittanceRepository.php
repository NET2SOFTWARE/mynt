<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Remittance;
use App\Contracts\RemittanceInterface;


class RemittanceRepository implements RemittanceInterface
{

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $client = new Client();

        $res = $client->post('dev.net2mart.com/testingaj/aj/remitcreate', ['form_params' => $data]);

        $response = json_decode((string) $res->getBody(), true);

        return (($response['Response']['Code'] == '00')) ? true : false;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function delete(array $data)
    {
        $client = new Client();

        $res = $client->post('dev.net2mart.com/testingaj/aj/remitdelete', ['form_params' => $data]);

        $response = json_decode((string) $res->getBody(), true);

        return (($response['Response']['Code'] == '00')) ? true : false;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function inquiry(array $data)
    {
        $client = new Client();

        $res = $client->post('dev.net2mart.com/testingaj/aj/remitinq', ['form_params' => $data]);

        $response = json_decode((string) $res->getBody(), true);

        return (($response['Response']['Code'] == '00')) ? true : false;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function inquiryStatus(array $data)
    {
        $client = new Client();

        $res = $client->post('dev.net2mart.com/testingaj/aj/remitstat', ['form_params' => $data]);

        $response = json_decode((string) $res->getBody(), true);

        return (($response['Response']['Code'] == '00')) ? true : false;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function transfer(array $data)
    {
        $client = new Client();

        $res = $client->post('dev.net2mart.com/testingaj/aj/remittrx', ['body' => $param]);

        $response = json_decode((string) $res->getBody(), true);

        return (($response['Response']['Code'] == '00')) ? true : false;
    }

    /**
     * @param array $data
     * @return string
     */
    public function getHashCreateData(array $data)
    {
        $param = (array) [
            'stan',
            'transdatetime',
            'instid',
            'accountid',
            'name',
            'address',
            'phonenumber',
            'idnumber',
            'accountid1',
            'instid1'
        ];

        $result = null;

        foreach ($param as $index) {
            if (array_has($data, $index)) {
                $result .= $data[$index];
            } else {
                $result .= null;
            }
        }

        return ($result != null) ? $result : null;
    }

    /**
     * @param array $data
     * @return string
     */
    public function getHashDeleteData(array $data)
    {
        $param = (array) [
            'stan',
            'transdatetime',
            'instid',
            'accountid',
            'name',
            'address',
            'phonenumber',
            'idnumber',
            'accountid1',
            'instid1',
            'accountid2',
            'instid2',
            'accountid3',
            'instid3',
            'accountid4',
            'instid4',
            'accountid5',
            'instid5',
        ];

        $result = null;

        foreach ($param as $index) {
            if (array_has($data, $index)) {
                $result .= $data[$index];
            }
        }

        return ($result != null) ? $result : null;
    }

    /**
     * @param array $data
     * @return string
     */
    public function getHashInquiryData(array $data)
    {
        $param = (array) [
            'stan',
            'transdatetime',
            'instid',
            'refnumber',
            'terminalid',
            'localdatetime',
            'countrycode',
            'accountid',
            'amount',
            'instid1',
            'accountid1',
            'amount1',
            'custrefnumber'
        ];

        $result = null;

        foreach ($param as $index) {
            if (array_has($data, $index)) {
                $result .= $data[$index];
            }
        }

        return ($result != null) ? $result : null;
    }

    /**
     * @param array $data
     * @return string
     */
    public function getHashInquiryStatusData(array $data)
    {
        $param = (array) [
            'stan',
            'transdatetime',
            'instid',
            'localdatetime',
            'transdatetime'
        ];

        $result = null;

        foreach ($param as $index) {
            if (array_has($data, $index)) {
                $result .= $data[$index];
            }
        }

        return ($result != null) ? $result : null;
    }

    /**
     * @param array $data
     * @return string
     */
    public function getHashTransferData(array $data)
    {
        $param = (array) [
            'stan',
            'transdatetime',
            'instid',

            'refnumber',
            'terminalid',
            'localdatetime',
            'countrycode',

            'accountid',
            'amount',

            'instid1',
            'accountid1',
            'amount1',
            'custrefnumber'
        ];

        $result = null;

        foreach ($param as $index) {
            if (array_has($data, $index)) {
                $result .= $data[$index];
            }
        }

        return ($result != null) ? $result : null;
    }


    /**
     * @return string
     */
    public function getNewId()
    {
        return (string) $this->getNewStan();
    }


    /**
     * @return string
     */
    private function getNewStan()
    {
        $count = count(Remittance::all());

        $param = 100000;

        if ($count > 0) {
            $param = ($param + $count) + 1;
        } else {
            $param = $param + 1;
        }

        return (string) substr($param, 1);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createRemittanceDb(array $data)
    {
        $remittance = new Remittance;

        foreach ($data as $index => $value) {$remittance->$index = $value;}

        $remittance->created_at = Carbon::now();
        $remittance->updated_at = Carbon::now();

        return $remittance->save() ? false : Remittance::find($remittance->id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteRemittanceDb(int $id)
    {
        $remittance = Remittance::find($id);

        return $remittance->delete();
    }

    /**
     * @return mixed
     */
    public function get(int $id)
    {
        return Remittance::find($id);
    }

    /**
     * @return mixed
     */
    public function gets()
    {
        return Remittance::all();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $remittance = new Remittance;

        $remittance->stan               = $data['stan'];
        $remittance->transdatetime      = $data['transdatetime'];
        $remittance->instid             = $data['instid'];
        $remittance->accountid          = $data['accountid'];
        $remittance->name               = $data['name'];
        $remittance->address            = $data['address'];
        $remittance->countrycode        = $data['countrycode'];
        $remittance->birthdate          = $data['birthdate'];
        $remittance->birthplace         = $data['birthplace'];
        $remittance->phonenumber        = $data['phonenumber'];
        $remittance->email              = $data['email'];
        $remittance->occupation         = $data['occupation'];
        $remittance->citizenship        = $data['citizenship'];
        $remittance->idnumber           = $data['idnumber'];
        $remittance->fundresource       = $data['fundresource'];

        $remittance->instid1            = $data['instid1'];
        $remittance->accountid1         = $data['accountid1'];
        $remittance->name1              = $data['name1'];
        $remittance->relationship1      = $data['relationship1'];
        $remittance->regencycode1       = $data['regencycode1'];
        $remittance->address1           = $data['address1'];
        $remittance->provcode1          = $data['provcode1'];
        $remittance->idnumber1          = $data['idnumber1'];
        $remittance->sign               = $data['sign'];
        $remittance->bank_id            = $data['bank_id'];

        $remittance->created_at = Carbon::now();
        $remittance->updated_at = Carbon::now();

        return (!$remittance->save()) ? false : Remittance::find($remittance->id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteFromDB(int $id)
    {
        $remittance = Remittance::find($id);

        return $remittance->delete();
    }
}