<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ChildAccountRequest
 * @package App\Http\Requests
 */
class ChildAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function allRequest($value)
    {
        return (array) $value;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|string|max:40|unique:users,name',
            'email'                 => 'required|string|email|max:40|unique:users,email',
            'password'              => 'required|string|min:6|confirmed',
            'phone'                 => 'required|numeric|digits_between:6,16',
            'limit.balance'         => 'required',
            'limit.transaction'     => 'required',
            'captcha'               => 'required|captcha',
            'term'                  => 'accepted'
        ];
    }
}