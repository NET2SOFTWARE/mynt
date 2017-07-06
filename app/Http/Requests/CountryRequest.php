<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
                    'name'      => 'required|string|max:40|unique:countries,name',
                    'iso'       => 'required|string|max:3|unique:countries,iso',
                    'currency'  => 'required|string|max:3|unique:countries,currency',
                ];
            }

            case 'PUT':
            case 'PATCH':
            {
                # FYI, `$this->get()` not working here
                return [
                    'name' => [
                        'required', 'max:40', 'string',
                        Rule::unique('countries', 'name')->ignore($this->route('id')),
                    ],
                    'iso' => [
                        'required', 'max:3', 'string',
                        Rule::unique('countries', 'iso')->ignore($this->route('id')),
                    ],
                    'currency' => [
                        'required', 'max:3', 'string',
                        Rule::unique('countries', 'currency')->ignore($this->route('id')),
                    ],
                ];
            }

            default:break;
        }
    }
}
