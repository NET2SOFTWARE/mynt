<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnershipRequest extends FormRequest
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
                    'name'          => 'required|string|max:40|unique:partnerships,name',
                    'description'   => 'nullable|max:120',

                ];
            }

            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'          => 'required|string|max:40',
                    'description'   => 'max:120',
                ];
            }

            default:break;
        }
    }
}
