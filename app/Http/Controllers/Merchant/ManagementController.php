<?php

namespace App\Http\Controllers\Merchant;

use App\Contracts\AreaInterface;
use App\Contracts\BankInterface;
use App\Contracts\StateInterface;
use App\Models\Bank;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Contracts\CityInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{

    private $state;

    /**
     * @var AreaInterface
     */
    private $area;

    /**
     * @var BankInterface
     */
    private $bank;

    public function __construct(
        StateInterface  $state,
        AreaInterface   $area,
        BankInterface   $bank
    )
    {
        $this->state    = $state;
        $this->area     = $area;
        $this->bank     = $bank;
    }

    public function account()
    {
        return view('merchant.management-account');
    }

    public function bank()
    {
        $remittances = Auth::user()->remittances;

        return view('merchant.management-bank', compact('remittances'));
    }

    public function showFormRegisterBank()
    {
        $banks = Bank::all();

        $regencies = $this->area->gets();

        $countries = Country::all();

        $referral = Auth::user()->merchants->first()['companies'][0]['code'];

        $mynt_acc_num = Auth::user()->merchants->first()['accounts'][0]['number'];

        return view('merchant.management-bank-create', compact('banks', 'regencies', 'countries', 'referral', 'mynt_acc_num'));
    }
}
