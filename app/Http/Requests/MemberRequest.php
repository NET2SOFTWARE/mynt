<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {

            case 'POST': {
                return [
                    'name'          => 'required|string|max:40',
                    'email'         => 'required|string|email|max:40',
                    'password'      => 'required|string|min:6|confirmed',
                    'phone'         => 'required|numeric|digits_between:6,16',
                    'referral'      => 'nullable|exists:companies,code'
                ];
            }

            case 'PUT':
            case 'PATCH': {
                return [
                    'name' => [
                        'required', 'max:40', 'string',
                        Rule::unique('industries')->ignore($this->get('id')),
                    ]
                ];
            }

            default:
                break;
        }
    }
}
