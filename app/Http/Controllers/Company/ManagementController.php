<?php

namespace App\Http\Controllers\Company;

use App\Models\Bank;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Contracts\AreaInterface;
use App\Contracts\BankInterface;
use App\Contracts\StateInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class ManagementController extends Controller
{
    /**
     * @var CityInterface
     */
    private $state;

    /**
     * @var AreaInterface
     */
    private $area;

    /**
     * @var BankInterface
     */
    private $bank;

    /**
     * ManagementController constructor.
     * @param StateInterface $state
     * @param AreaInterface $area
     * @param BankInterface $bank
     */
    public function __construct(
        StateInterface $state,
        AreaInterface $area,
        BankInterface $bank
    )
    {
        $this->state = $state;
        $this->area = $area;
        $this->bank = $bank;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account()
    {
        return view('company.management-account');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditAccountForm()
    {
        return view('company.edit-account');
    }

    public function showEditPasswordForm()
    {
        return view('company.edit-password');
    }

    public function showEditPhotoForm()
    {
        return view('company.edit-photo');
    }

    public function editAccount($id, Request $request)
    {
        //
    }

    public function editPassword($id, Request $request)
    {
        //
    }

    public function editPhoto($id, Request $request)
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bank()
    {
        $remittance = Auth::user()->remittances;

        return view('company.management-bank', compact('remittance'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFormRegisterBank()
    {
        $banks = Bank::all();

        $regencies = $this->area->gets();

        $countries = Country::all();

        $referral = Auth::user()->companies->first()['code'];

        $mynt_acc_num = Auth::user()->companies->first()['accounts'][0]['number'];

        return view('company.management-bank-create', compact('banks', 'regencies', 'countries', 'referral', 'mynt_acc_num'));
    }

    /**
     * @param Request $request
     */
    public function storeBank(Request $request)
    {
        Validator::make($request->all(), [])->validate();
    }
}
