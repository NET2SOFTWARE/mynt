<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Contracts\MemberInterface;
use App\Contracts\IdentityInterface;
use App\Http\Requests\UpgradeRequest;
use App\Mail\UpgradeNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class MemberController extends Controller
{

    /**
     * @var MemberInterface
     */
    private $member;

    /**
     * @var IdentityInterface
     */
    private $identity;

    /**
     * MemberController constructor.
     * @param MemberInterface $member
     * @param IdentityInterface $identity
     */
    public function __construct(
        MemberInterface $member,
        IdentityInterface $identity
    )
    {
        $this->member = $member;
        $this->identity = $identity;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $member = $this->member->getWith(Auth::user()->members->first()['id'], 'companies,accounts,profiles');

        return response()
            ->view('member.profile', compact('member'), 200);
    }


    /**
     * @return \Illuminate\Http\Response
     */
    public function transaction()
    {
        $member = $this->member->getMemberByUserId(Auth::id());

        return response()
            ->view('member.transaction.account', compact('member'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function transfer_account()
    {
        $user = Auth::user();

        $member = $user->members->first();

        return response()
            ->view('member.transaction-to-account', compact('member'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function transfer_bank()
    {
        $member = $this->member->getMemberByUserId(Auth::id());

        return response()
            ->view('member.transaction-to-bank', compact('member'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function remittance()
    {
        $member = $this->member->getMemberByUserId(Auth::id());

        return response()
            ->view('member.transaction-remittance', compact('member'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function redeem()
    {
        $member = $this->member->getMemberByUserId(Auth::id());

        return response()
            ->view('member.transaction-redeem', compact('member'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function accessibility()
    {
        $member = $this->member->getMemberByUserId(Auth::id());

        return response()
            ->view('member.accessibility', compact('member'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function management()
    {
        $member = $this->member->getMemberByUserId(Auth::id());

        return response()
            ->view('member.management.', compact('member'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function upgrade()
    {
        $identities = $this->identity->gets(['id', 'name']);

        $member = $this->member->getMemberByUserId(Auth::id());

        return response()
            ->view('member.upgrade', compact('identities', 'member'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function transactionHistory()
    {
        $member = $this->member->getMemberByUserId(Auth::id());

        return response()
            ->view('member.transaction', compact('member'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function accounting_print()
    {
        $member = $this->member->getMemberByUserId(Auth::id());

        return response()
            ->view('member.accounting-print', compact('member'), 200);
    }

    /**
     * @param UpgradeRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @internal param $id
     */
    public function upgraded(UpgradeRequest $request)
    {
        $filename = 'document.jpg';

        if ($request->hasFile('document'))
        {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 120);

            $document = $request->file('document');
            $filename  = time() . '.' . $document->getClientOriginalExtension();

            Image::make($document->getRealPath())->resize(320, 320, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->save('img/documents/'. $filename);
        }

        $expired_date = date('Y-m-d', strtotime($request->input('identity.date')));
        $now = date('Y-m-d', strtotime(Carbon::now()->toDateString()));

        if ($request->input('identity_date_type') == 'lifetime')
        {
            $dob = date('Y-m-d', strtotime($request->input('born_date')));
            $expired_date = date('Y-m-d', strtotime(date('Y-m-d', strtotime($dob)) . ' + 200 year'));
        }

        if ($expired_date <= $now) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('warning', 'Your identity document date has expired. We are unable to process your request to upgrade your account.');
        }

        $user = Auth::user()->members->first();

        $member = $this->member->get($user->id);

        if (!$member)
            return redirect()
                ->back()
                ->with('warning', 'Your identity is not recognized by the system.');

        $profile = $this->member->upgrade($member->id, [
            'gender'                    => $request->input('gender'),
            'born_place'                => $request->input('born_place'),
            'born_date'                 => $request->input('born_date'),
            'identity_id'               => $request->input('identity.type'),
            'identity_number'           => $request->input('identity.number'),
            'identity_expired_date'     => $expired_date,
            'mother_name'               => $request->input('mother_name'),
            'document'                  => $filename,
            'status'                    => 'pending',
        ]);

        if (!$profile)
            return redirect()
                ->back()
                ->with('warning', 'Process failed, our server is very busy, please try again later.');

        Mail::to($user->email)->send(new UpgradeNotification(Auth::user()));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('member'), 201)
            : redirect()->back()
                ->with(compact('member'))
                ->with(compact('member'))
                ->with('success', 'We will review your input data to validate the identity validity. Your account will be systematically upgraded if your documents and data have been processed. This process will take up to 24 hours. Please check back. Thank you');
    }
}