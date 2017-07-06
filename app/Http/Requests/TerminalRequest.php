<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerminalRequest extends FormRequest
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
                    'code'          => 'required|numeric|unique:terminals,code',
                    'merchant_id'   => 'required|numeric',
                ];
            }

            case 'PUT':
            case 'PATCH':
            {
                return [
                    'code'          => 'required|numeric',
                    'merchant_id'   => 'required|numeric',
                ];
            }

            default:break;
        }
    }
}
