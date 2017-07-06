<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'          => 'required',
                    'brand'         => 'required',
                    'email'         => 'required|email',
                    'website'       => 'required',
                    'industry_id'   => 'required',
                    # 'photo'         => 'required',
                ];
            }

            # case 'PUT':
            # case 'PATCH':
            # {
            #     return [
            #         'name' => [
            #             'required', 'max:40', 'string',
            #             Rule::unique('countries', 'name')->ignore($this->get('id')),
            #         ],
            #         'iso' => [
            #             'required', 'max:3', 'string',
            #             Rule::unique('countries', 'iso')->ignore($this->get('id')),
            #         ],
            #         'currency' => [
            #             'required', 'max:3', 'string',
            #             Rule::unique('countries', 'currency')->ignore($this->get('id')),
            #         ],
            #     ];
            # }

            default:break;
        }
    }
}
