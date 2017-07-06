<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class IndustryRequest extends FormRequest
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
                    'name' => 'required|string|max:40|unique:industries,name',
                ];
            }

            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => [
                        'required','max:40', 'string',
                        Rule::unique('industries')->ignore($this->get('id')),
                    ]
                ];
            }

            default:break;
        }
    }
}
