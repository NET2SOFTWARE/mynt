<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Contracts\AreaInterface;
use App\Contracts\BankInterface;
use App\Contracts\StateInterface;
use App\Http\Controllers\Controller;
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
        return view('company.management-bank');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFormRegisterBank()
    {
        $regencies  = $this->area->gets();
        $provinces  = $this->state->gets();
        $banks      = $this->bank->gets();

        return view('company.management-bank-create', compact('regencies', 'provinces', 'banks'));
    }

    /**
     * @param Request $request
     */
    public function storeBank(Request $request)
    {
        Validator::make($request->all(), [])->validate();
    }
}
