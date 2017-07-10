<?php

namespace App\Http\Controllers\Merchant;

use App\Contracts\CityInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagementController extends Controller
{
    /**
     * @var CityInterface
     */
    private $city;

    /**
     * ManagementController constructor.
     * @param CityInterface $city
     */
    public function __construct(CityInterface $city)
    {
        $this->city = $city;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account()
    {
        return view('merchant.management-account');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bank()
    {
        return view('merchant.management-bank');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bankCreate()
    {
        $cities = $this->city->gets(['id', 'name']);

        return view('merchant.management-bank-create', compact('cities'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bankStore(Request $request)
    {
        return redirect()
            ->back()
            ->with('success', 'Bank account was successfully added.');
    }
}
