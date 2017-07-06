<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdministratorRequest extends FormRequest
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

            case 'POST':
            {
                return [
                    'name' => 'required|string|max:40',
                    'email' => 'required|string|email|max:40|unique:admins',

                ];
            }

            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:40',
                    'email' => [
                        'required','max:40',
                        Rule::unique('admins')->where(function ($query) {
                            $query->where('id', '=', $this->get('id'));
                        })
                    ],
                    'password' => 'required|string|min:6|confirmed'
                ];
            }

            default:break;
        }
    }
}
