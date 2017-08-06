<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Remittance;
use App\Models\RemittanceLog;
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

        $res = $client->request('POST', 'dev.net2mart.com/testingaj/aj/remitcreate', [
            'form_params' => $data
        ]);

        RemittanceLog::create([
            'method' => 'create_account',
            'request' => json_encode($data),
            'response' => (string) $res->getBody(),
        ]);

        return json_decode((string) $res->getBody(), true);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function delete(array $data)
    {
        $client = new Client();

        $res = $client->request('POST', 'dev.net2mart.com/testingaj/aj/remitdelete', [
            'form_params' => $data
        ]);

        RemittanceLog::create([
            'method' => 'delete_account',
            'request' => json_encode($data),
            'response' => (string) $res->getBody(),
        ]);

        return json_decode((string) $res->getBody(), true);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function inquiry(array $data)
    {
        $client = new Client();

        $res = $client->request('POST', 'dev.net2mart.com/testingaj/aj/remitinq', [
            'form_params' => $data
        ]);

        RemittanceLog::create([
            'method' => 'inquiry',
            'request' => json_encode($data),
            'response' => (string) $res->getBody(),
        ]);

        return json_decode((string) $res->getBody(), true);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function inquiryStatus(array $data)
    {
        $client = new Client();

        $res = $client->request('POST', 'dev.net2mart.com/testingaj/aj/remitstat', [
            'form_params' => $data
        ]);

        RemittanceLog::create([
            'method' => 'inquiry_status',
            'request' => json_encode($data),
            'response' => (string) $res->getBody(),
        ]);

        return json_decode((string) $res->getBody(), true);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function transfer(array $data)
    {
        $client = new Client();

        $res = $client->request('POST', 'dev.net2mart.com/testingaj/aj/remittrx', [
            'form_params' => $data
        ]);

        RemittanceLog::create([
            'method' => 'transfer',
            'request' => json_encode($data),
            'response' => (string) $res->getBody(),
        ]);

        return json_decode((string) $res->getBody(), true);
    }

    /**
     * @return string
     */
    public function getNewId()
    {
        // return (string) $this->getNewStan();
        return (string) $this->getNewStanFromLog();
    }

    /**
     * @return string
     */
    public function getNewStanFromLog()
    {
        $log = RemittanceLog::orderBy('id', 'desc')->first();

        $last_id = 0;

        if ($log) $last_id = (int) $log->id;

        $last_id++;

        return (string) str_pad($last_id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    private function getNewStan()
    {
        $count = count(Remittance::all());

        $param = 1000000;

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