<?php

namespace App\Http\Controllers\Merchant;

use App\Contracts\AreaInterface;
use App\Contracts\BankInterface;
use App\Contracts\StateInterface;
use Illuminate\Http\Request;
use App\Contracts\CityInterface;
use App\Http\Controllers\Controller;

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
        return view('merchant.management-bank');
    }

    public function showFormRegisterBank()
    {
        $regencies  = $this->area->gets();
        $provinces  = $this->state->gets();
        $banks      = $this->bank->gets();

        return view('merchant.management-bank-create', compact('provinces', 'regencies', 'banks'));
    }

    public function bankStore(Request $request)
    {
        return redirect()
            ->back()
            ->with('success', 'Bank account was successfully added.');
    }
}
