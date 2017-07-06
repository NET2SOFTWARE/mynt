<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpgradeRequest extends FormRequest
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
        return [
            'born_place'        => 'required',
            'born_date'         => 'required',
            'gender'            => 'required',
            'identity.type'     => 'required',
            'identity.number'   => 'required|numeric',
            'identity.date'     => 'required',
            'document'          => 'required|image|mimes:jpeg,bmp,png,jpg,gif|dimensions:min_width=320,min_height=320',
            'captcha'           => 'required|captcha'
        ];
    }
}
