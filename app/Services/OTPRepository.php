<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Contracts\OTPInterface;

class OTPRepository implements OTPInterface
{

    /**
     * @param $accountNumber
     * @return bool
     */
    public function generate($accountNumber)
    {
        $client = new Client();

        $res = $client->request('GET', 'http://202.53.254.35:5001/validate/check?user='.$accountNumber.'&pass=j4r1n9aj', []);

        $body = json_decode((string) $res->getBody(), true);

        if (!array_has($body, ['detail'])) return false;

        $transactionId  = $body['detail']['transactionid'];
        $status         = $body['result']['status'];

        return ($status == 'true') ? $transactionId : false;
    }

    /**
     * @param $accountNumber
     * @param $transactionId
     * @param $token
     * @return bool
     */
    public function validate($accountNumber, $transactionId, $token)
    {
        $client = new Client();

        $res = $client->request('GET', 'http://202.53.254.35:5001/validate/check?user='.$accountNumber.'&transactionid='.$transactionId.'&pass='.$token, []);

        $body = json_decode((string) $res->getBody(), true);

        $value          = $body['result']['value'];

        return ($value == 'true') ? true : false;
    }
}