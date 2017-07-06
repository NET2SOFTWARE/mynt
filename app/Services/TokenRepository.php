<?php

namespace App\Services;

use App\Contracts\AbstractInterface;
use App\Contracts\TokenInterface;
use App\Models\Token;
use Carbon\Carbon;

/**
 * Class TokenRepository
 * @package App\Services
 */
class TokenRepository extends AbstractInterface implements TokenInterface
{

    /**
     * @var
     */
    private $token;

    /**
     * TokenRepository constructor.
     * @param Token $model
     */
    public function __construct(Token $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function attribute(array $attributes)
    {
        return [
            'account_number'    => $attributes['account_number'],
            'amount'            => $attributes['amount'],
            'no_token'          => $attributes['no_token'],
            'expired_at'        => Carbon::now()->addMinute(15),
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }

    public function generateToken()
    {

        $rand_token = random_int(100000, 999999);

        $token = $this->model->all();

        if (count($token) > 0) {
            do {

                $this->token = $rand_token;

            } while (collect($token)->contains('no_token', $rand_token));
        } else {

            $this->token = $rand_token;
        }

        return $this->token;
    }

    /**
     * @param $accountNumber
     * @return bool
     */
    public function regenerateToken($accountNumber)
    {
        $token = $this->model->where('account_number', '=', $accountNumber)->update([
            'no_token'          => $this->generateToken(),
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);

        return (!$token) ? false : $token;
    }

    public function isTokenExist($no_token)
    {
        $token = $this->getBy('no_token', $no_token);

        return (count($token) > 0) ? 'true' : 'false';
    }

    public function isTokenAmountMatch($no_token, $amount)
    {
        $token = $this->model->where('no_token', '=', $no_token)
                            ->where('amount', '=', $amount)
                            ->get();

        return (count($token) > 0) ? 'true' : 'false';
    }

    public function isExpiredToken($no_token)
    {
        $token = $this->model->where('no_token', '=', $no_token)
                                ->where('expired_at', '<', Carbon::now()->toDateTimeString())
                                ->get();

        return (count($token) > 0) ? 'true' : 'false';
    }


    public function save(array $data)
    {
        $token = new Token;

        foreach ($data as $index => $value) { $token->$index = $value; }

        $token->expired_at = Carbon::now()->addMinute(3);

        $token->save();

        return (!$token) ? false : Token::find($token->id);
    }

    public function destroy($account_number)
    {
        $token = Token::where('account_number', '=', $account_number)->first();

        return $token->delete();
    }

    public function getUserToken($account_number)
    {
        $token = Token::where('account_number', '=', $account_number)->first();

        return (count($token) > 0) ? $token->no_token : null;
    }

    public function getLastUserReferenceToken($account_number)
    {
        $token = Token::where('account_number', '=', $account_number)->orderBy('created_at', 'DESC')->first();

        return (!$token) ? false : $token->reference_id;
    }
}