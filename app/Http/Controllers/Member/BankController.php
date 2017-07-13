<?php

namespace App\Http\Controllers\Member;

use App\Contracts\AreaInterface;
use App\Contracts\BankInterface;
use App\Contracts\StateInterface;
use App\Models\Bank;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    /**
     * @var AreaInterface
     */
    private $area;

    /**
     * @var BankInterface
     */
    private $bank;

    private $state;

    /**
     * BankController constructor.
     * @param BankInterface $bank
     * @param AreaInterface $area
     * @param StateInterface $state
     */
    public function __construct(
        BankInterface $bank,
        AreaInterface $area,
        StateInterface $state
    )
    {
        $this->area = $area;
        $this->bank = $bank;
        $this->state = $state;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()
            ->view('member.management.bank', compact('banks', 'regencies', 'provinces'), 200);
    }

    public function showFormRegisterBank()
    {
        $banks = Bank::all();

        $regencies = $this->area->gets();

        $provinces = $this->state->gets(['id', 'name']);

        return view('member.management.bank-create', compact('banks', 'regencies', 'provinces'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'bank'  => 'required|exists:banks,id',
            'bank_account_name' => 'required|numeric'
        ])->validate();

        $bank = Bank::find($request->input('bank'));

        if (!$bank) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors(['bank', 'Bank unknown']);
        }

        $member = Member::whereHas('users', function ($query) {
            $query->where('users.id', Auth::id());
        })->first();

        if (!$member) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Internal system error.');
        }

        $member->banks()->save($bank, ['account_number' => $request->input('bank_account_name')]);

        if (!$member) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Internal system error.');
        }

        return redirect()
            ->back()
            ->withInput($request->all())
            ->with('success', 'Bank account has successfully added.');

    }
}
