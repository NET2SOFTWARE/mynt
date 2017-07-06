<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
                    'name' => 'required|string|max:40|unique:cities,name',
                    'state_id' => 'required|exists:cities,id',

                ];
            }

            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => [
                        'required','max:40',
                        Rule::unique('cities')->ignore($this->get('id')),
                    ],
                    'state_id' => 'required|exists:cities,id',
                ];
            }

            default:break;
        }
    }
}
