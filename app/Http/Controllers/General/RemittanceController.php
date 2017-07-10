<?php

namespace App\Http\Controllers\General;

use App\Contracts\CityInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RemittanceController extends Controller
{

    private $city;

    private $remittance;

    public function __construct(CityInterface $city)
    {
        $this->city         = $city;
        $this->remittance   = null;
    }

    public function showFormRegister()
    {
        $city = $this->city->gets(array('id', 'name'));

        return view('forms.remittance', compact('city'));
    }

    public function register(Request $request)
    {
        //
    }

    public function validator(Request $request)
    {
        //
    }
}
