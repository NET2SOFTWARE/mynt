<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
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
            'name'                  => 'required|string|max:20',
            'brand'                 => 'nullable|string|max:100',
            'email'                 => 'required|email|max:40',
            'website'               => 'nullable|max:40',
            'merchant.type'         => 'required',
            'merchant.company'      => 'nullable|max:40',
            'photo'                 => 'nullable|image|mimes:jpeg,jpg,bmp,png,gif|dimensions:min_width=160,min_height=160',
            'password'              => 'required|string|min:6|confirmed',

            'location.street'       => 'nullable|max:100',
            'location.city'         => 'required_with:location.street|required_with:location.postal_code',
            'location.postal_code'  => 'nullable|numeric',

            'pic.name'              => 'nullable|string|max:40',
            'pic.email'             => 'nullable|email',
            'pic.phone'             => 'nullable',
            'pic.position'          => 'required_with:pic.name',
            'pic.location.street'   => 'required_with:pic.location.city',
            'pic.location.city'     => 'required_with:pic.location.street',
            'pic.location.postal_code'  => 'required_with_all:pic.location.street,pic.location.city',
        ];
    }
}
