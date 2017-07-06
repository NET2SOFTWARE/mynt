<?php

namespace App\Http\Controllers\Member;

use App\Contracts\CompanyInterface;
use App\User;
use App\Services\Confirmation;
use App\Contracts\UserInterface;
use App\Contracts\MemberInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChildAccountRequest;

/**
 * Class ChildAccountController
 * @package App\Http\Controllers\Member
 */
class ChildController extends Controller
{

    /**
     * @var MemberInterface
     */
    private $member;

    /**
     * @var Confirmation
     */
    private $confirmation;

    /**
     * @var
     */
    private $user;

    /**
     * @var
     */
    private $company;


    /**
     * ChildAccountController constructor.
     * @param MemberInterface $member
     * @param Confirmation $confirmation
     * @param UserInterface $user
     * @param CompanyInterface $company
     */
    public function __construct(
        MemberInterface     $member,
        Confirmation        $confirmation,
        UserInterface       $user,
        CompanyInterface    $company
    )
    {
        $this->member       = $member;
        $this->confirmation = $confirmation;
        $this->user         = $user;
        $this->company      = $company;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Auth::user()->childrens;

        $ids = [];

        foreach ($data as $index) { $ids = $index->user_id; }

        $children = User::whereIn('user.id', $ids)->paginate(15);

        return response()
            ->view('member.management-child', compact('children'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showForm()
    {
        $member = Auth::user()->members->first();

        return response()->view('member.child-form', compact('member'), 200);
    }

    public function createChild(ChildAccountRequest $request)
    {
        if ((bool) $this->user->checkUsernameExists(strtolower($request->input('name')))) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors(['name' => 'The name has already been taken.']);
        }

        if ((bool) $this->user->checkEmailExists(strtolower($request->input('email')))) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors(['email' => 'The email has already been taken.']);
        }

        if ((bool) $this->user->checkingIsLinePhoneNumber($request->input('phone'))) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors(['phone' => 'Please use mobile number only']);
        }

        if ((bool) $this->user->checkPhoneExists($this->user->serializePhone($request->input('phone')))) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors(['phone' => 'The email has already been taken.']);
        }

        $member = Auth::user()->members()->first();

        if (!$referral = $this->member->getMemberReferralByMemberId($member->id)) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'System error, we could not get your referral.');
        }

        if (!$company = $this->company->getCompanyByCode($referral)) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'System error, we could not find company that has code as your company code.');
        }

        $childMember = $this->member->createChildAccount(Auth::id(), array(
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'phone'     => $request->input('phone'),
            'password'  => $request->input('password'),
            'referral'  => $member->companies->first()['code'],
            'limit_balance' => $request->input('limit.balance'),
            'limit_balance_transaction' => $request->input('limit.transaction')
        ));

        if (!$childMember) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'System error, system cannot create child account.');
        }

        if (!$childMember->parentAccounts()->create([
            'parent_id' => Auth::id()
        ])) {
            $childMember->delete();
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'System error, system cannot create relation of child account with parentAccount.');
        }

        $childMember->roles()->attach(4);

        $child = $this->member->getMemberByUserId($childMember->id);

        $child->companies()->attach($company->id);

        $this->confirmation->sendConfirmationMail($this->user->get($childMember->id));

        return redirect()
            ->back()
            ->with('success', 'Child account has been successfully created, we have sent email confirmation to your child account. Please check your email of child account and follow the next instruction.');
    }
}