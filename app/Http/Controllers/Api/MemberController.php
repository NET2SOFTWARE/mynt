<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use DB;
use App\User;
use App\Models\Account;
use App\Models\Company;
use App\Models\Member;
use App\Models\Passbook;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Contracts\UserInterface;
use App\Contracts\MemberInterface;
use App\Contracts\AccountInterface;
use App\Http\Requests\MemberRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UpgradeNotification;

/**
 * Class MemberController
 * @package App\Http\Controllers\Api
 */
class MemberController extends Controller
{

    /**
     * @var MemberInterface
     */
    private $member;


    /**
     * @var AccountInterface
     */
    private $account;

    /**
     * @var
     */
    private $user;

    /**
     * MemberController constructor.
     * @param MemberInterface $member
     * @param AccountInterface $account
     * @param UserInterface $user
     */
    public function __construct(
        MemberInterface $member,
        AccountInterface $account,
        UserInterface $user
    )
    {
        $this->member = $member;
        $this->account = $account;
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $user = User::where('id', Auth::id())->with(
            'roles',
            'members',
            'members.profiles',
            'members.profiles.identity',
            'members.accounts',
            'members.accounts.passbooks',
            'members.accounts.account_type',
            'members.banks',
            'members.companies',
            'members.locations',
            'members.locations.city'
        )->first();

        return response()
            ->json([
                'status'    => false,
                'code'      => 200,
                'message'   => config('code.200'),
                'text'      => 'Profile data member.',
                'data'      => compact('user')
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $members = $this->member->getsPaginate();

        $members->map(function($member){
            $member['type'] = count($member->profiles) > 0 ? 'registered' : 'unregistered';
            if ($member['type'] == 'unregistered')
            {
                $confirmations = DB::table('confirmations')->where('user_id', $member['id'])->get();
                $member['status'] = count($confirmations) > 0 ? 'pending' : 'confirmed';
            } else {
                $member['status'] = $member->profiles->first()['status'];
            }
        });

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member', compact('members'), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approval(Request $request)
    {
        $members = $this->member->getListMemberNeededApproved((int) 15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-approval', compact('members'), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pending_upgrade(Request $request)
    {
        $members = $this->member->getListPendingApproval((int) 15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-pending_upgrade', compact('members'), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function child_account(Request $request)
    {
        $members = $this->member->getChildAccount();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-child_account', compact('members'), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function document(Request $request)
    {
        $members = $this->member->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-document', compact('members'), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate(Request $request)
    {
        if ($request->ajax() || $request->isJson()) abort(401, config('code.401'));

        $members = $this->member->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-deactivate', compact('members'), 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivate_process($id, Request $request)
    {
        if ($request->ajax() || $request->isJson()) abort(401, config('code.401'));

        return ($this->member->deActiveAccount($id))
            ? redirect()->back()->with('success', 'Process success')
            : redirect()->back()->with('warning', 'Process failed');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transactions(Request $request)
    {
        $members = $this->member->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-transactions', compact('members'), 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.member-create', compact(null), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MemberRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {
        $referral = array_has($request->all(), 'referral')
            ? (!is_null($request->input('referral'))) ? $request->input('referral') : '000'
            : '000';

        $user = User::where('email', '=', $request->input('email'))
                    ->where('phone', '=', $request->input('phone'))
                    ->whereHas('companies', function ($query) use ($referral) {
                        $query->where('companies.code', '=', $referral);
                    })->first();

        if ($user)
            return response()->json([
                'status'    => false,
                'code'      => 500,
                'message'   => config('code.500'),
                'text'      => 'Member data was registered by this company.',
                'data'      => null
            ], 500);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
            return response()->json([
                'status'    => false,
                'code'      => 500,
                'message'   => config('code.500'),
                'text'      => 'Member credential data not allowed by system.',
                'data'      => null
            ], 500);

        $user  = new User([
            'name'          => $request->input('name'),
            'email'         => $request->input('email'),
            'password'      => bcrypt($request->input('password')),
            'phone'         => str_is('0*', $request->input('phone')) ? '62'. substr($request->input('phone'), 1) : $request->input('phone'),
            'isConfirmed'   => true
        ]);

        $user->save();

        if ( !$user )
            return response()->json([
                'status'    => false,
                'code'      => 500,
                'message'   => config('code.500'),
                'text'      => 'Our system is still busy, please try again later.',
                'data'      => null
            ], 500);


        $members = new Member([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'phone'     => str_is('0*', $request->input('phone')) ? '62'. substr($request->input('phone'), 1) : $request->input('phone')
        ]);

        $members->save();

        if ( !$members ) {
            $user->delete();
            return response()->json([
                'status'    => false,
                'code'      => 500,
                'message'   => config('code.500'),
                'text'      => 'Our system is still busy, please try again later.',
                'data'      => null
            ], 500);
        }

        $company = Company::where('code', '=', $referral)->first();

        $account = new Account([
            'number'                    => $referral . date('y'),
            'account_type_id'           => 1,
            'mynt_id'                   => null,
            'limit_balance'             => 1000000,
            'limit_balance_transaction' => 20000000
        ]);

        $account->save();

        if ( !$account ) {
            $user->delete();
            $members->delete();
            return response()->json([
                'status'    => false,
                'code'      => 500,
                'message'   => config('code.500'),
                'text'      => 'Our system is still busy, please try again later.',
                'data'      => null
            ], 500);
        }

        $members->companies()->attach($company->id);

        $members->accounts()->attach($account->id);

        $user->roles()->attach(3);

        $user->members()->attach($members->id);

        $member = Member::where('id', '=', $members->id)
                        ->with('accounts', 'companies')
                        ->first();

        return ($request->isJson() || $request->ajax())
            ? response()->json([
                'status'    => true,
                'code'      => 201,
                'message'   => config('code.201'),
                'text'      => 'Member registration was saved successfully.',
                'data'      => compact('member')
            ], 201)
            : redirect()->back()
                ->with(compact('member'))
                ->with('message', 'Member has added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $member = $this->member->get($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('member'), 200)
            : response()->view('pages.member-show', compact('member'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $member = $this->member->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.member-edit', compact('member'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MemberRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $filename = null;

        if ($request->hasFile('photo') && $request->file('photo')->isValid())
        {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 120);

            $photo = $request->file('photo');

            if (! in_array(strtolower($photo->getClientOriginalExtension()), [
                'jpg',
                'jpeg',
                'png'
            ])) {
                return ($request->ajax() || $request->isJson())
                    ? response()->json([
                            'status'    => false,
                            'code'      => 400,
                            'message'   => config('code.400'),
                            'text'      => 'Unsupported file image format.',
                            'data'      => compact(null)
                        ], 400)
                    : redirect()->back()
                        ->withInput()
                        ->with('warning', 'Unsupported file image format.');
            }

            $filename  = time() . '.' . $photo->getClientOriginalExtension();

            Image::make($photo->getRealPath())->resize(320, 320, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->save('img/member/'. $filename);
        }

        $data = [];

        if ($filename) $data['image'] = $filename;

        if ($request->has('name'))
        {
            $validator = Validator::make($request->all(), [
                'name'      => 'required',
                'phone'     => 'required',
            ]);

            if ($validator->fails())
            {
                return ($request->ajax() || $request->isJson())
                    ? response()->json([
                        'status'    => false,
                        'code'      => 400,
                        'message'   => config('code.400'),
                        'text'      => 'Fail to update member data, please check invalid message below.',
                        'data'      => compact(null),
                        'errors'    => $validator
                    ], 400)
                    : redirect()->back()->withErrors($validator)->with('warning', 'Fail to update member data, please check invalid message below.')->withInput($request->all());
            }

            $number = trim($request->input('phone'));

            if ('+' == substr($number, 0, 1))    $number = substr($number, 1);
            if ('6208' == substr($number, 0, 4)) $number = '62' . substr($number, 3);
            if ('08' == substr($number, 0, 2))   $number = '62' . substr($number, 1);
            if ('8' == substr($number, 0, 1))    $number = '62' . $number;

            $data = [
                'name'  => strtolower($request->input('name')),
                'phone' => $number,
            ];
        } elseif ($request->has('password')) {
            $validator = Validator::make($request->all(), [
                'old_password'          => 'required',
                'password'              => 'required|between:6,32|confirmed',
                'password_confirmation' => 'required',
            ]);

            if ($validator->fails())
            {
                return ($request->ajax() || $request->isJson())
                    ? response()->json([
                        'status'    => false,
                        'code'      => 400,
                        'message'   => config('code.400'),
                        'text'      => 'Fail to update member data, please check invalid message below.',
                        'data'      => compact(null),
                        'errors'    => $validator
                    ], 400)
                    : redirect()->back()->withErrors($validator)->with('warning', 'Fail to update member data, please check invalid message below.')->withInput($request->all());
            }

            $old_password = Member::find($id)->users()->first()->password;

            if (! Hash::check($request->input('old_password'), $old_password))
                return ($request->ajax() || $request->isJson())
                    ? response()->json([
                            'status'    => false,
                            'code'      => 400,
                            'message'   => config('code.400'),
                            'text'      => 'Invalid password.',
                            'data'      => compact(null)
                        ], 400)
                    : redirect()->back()
                        ->withInput()
                        ->with('warning', 'Invalid password.');

            $data = [
                'password'  => bcrypt($request->input('password')),
            ];
        }

        $member = Member::find($id);

        if (sizeof($data) > 0)
        {
            if (isset($data['password']))
            {
                $user_id = $member->users()->first()->id;
                $user = User::find($user_id);

                $update = User::where('id', $user_id)->update($data);

                abort_unless($update, config('code.500'));
            } elseif (isset($data['name'])) {
                $update = Member::where('id', $id)->update($data);

                abort_unless($update, config('code.500'));

                $user_id = $member->users()->first()->id;
                $user = User::find($user_id);

                $update = User::where('id', $user_id)->update($data);

                abort_unless($update, config('code.500'));
            } else {
                $update = Member::where('id', $id)->update($data);

                abort_unless($update, config('code.500'));
            }
        }

        $member = Member::find($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                    'status'    => true,
                    'code'      => 200,
                    'message'   => config('code.200'),
                    'text'      => 'Member data was updated successfully.',
                    'data'      => compact('member')
                ], 200)
            : redirect()->back()
                ->with(compact('member'))
                ->with('success', 'Member data was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $member = $this->member->delete($id);

        abort_unless($member, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Member data was updated successfully');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function pending()
    {
        $members = $this->member->getAllMemberPending();

        return response()
            ->json(compact('members'), 200);
    }

    /**
     * @param $id
     * @param $accountNumber
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id, $accountNumber, Request $request)
    {
        $approve = $this->member->approve($id, $accountNumber);

        $member = $this->member->get($id);

        if (is_null($approve))
            return ($request->isJson() || $request->ajax())
                ? response()
                    ->json([
                        'status'    => true,
                        'code'      => 201,
                        'text'      => config('code.505'),
                        'message'   => 'Member has been approved.',
                        'data'      => compact('member')
                    ])
                : redirect()
                    ->back()
                    ->with(compact('member'))
                    ->with('message', 'Member has been approved.');

        if (!$member)
            return ($request->isJson() || $request->ajax())
                ? response()
                    ->json([
                        'status'    => true,
                        'code'      => 500,
                        'text'      => config('code.500'),
                        'message'   => 'Member can not be approved at this time. System is experiencing problems. Please try again later.',
                        'data'      => compact('member')
                    ])
                : redirect()
                    ->back()
                    ->with(compact('member'))
                    ->with('message', 'Member can not be approved at this time. System is experiencing problems. Please try again later.');

        return ($request->isJson() || $request->ajax())
            ? response()
                ->json([
                    'status'    => true,
                    'code'      => 200,
                    'text'      => config('code.200'),
                    'message'   => 'Member has been successfully approved.',
                    'data'      => compact('member')
                ])
            : redirect()
                ->back()
                ->with(compact('member'))
                ->with('success', 'Member has been successfully approved.');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function confirm($id, Request $request)
    {
        $member = $this->member->confirmUser((int) $id);

        if (!$member)
            return redirect()
                ->back()
                ->with('warning', 'System error, we cannot confirm this user right now, please try again later.');

        return ($request->isJson() || $request->ajax())
            ? response()
                ->json([
                    'status'    => true,
                    'code'      => 200,
                    'text'      => config('code.200'),
                    'message'   => 'Member has been successfully confirmed.',
                    'data'      => compact('member')
                ])
            : redirect()
                ->route('member.approval')
                ->with(compact('member'))
                ->with('success', 'Member has been successfully confirmed.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function mynt(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email|exists:members,email',
            'account_number' => 'required',
            'mynt_id'       => 'required'
        ])->validate();

        $email = $request->input('email');
        $acc_no = $request->input('account_number');

        $account = Account::where('number', $acc_no)
                            ->whereHas('members',  function ($query) use ($email) {
                                $query->where('members.email', $email);
                            })->first();

        if (!$account)
            return ($request->isJson() || $request->ajax())
                ? response()
                    ->json([
                        'status'    => false,
                        'code'      => 404,
                        'text'      => config('code.404'),
                        'message'   => 'Email and account number do not match.',
                        'data'      => null
                    ])
                : redirect()
                    ->back()
                    ->with('warning', 'Email and account number do not match.');

        if ( !$this->account->isNullPin($account->number) )
            return ($request->isJson() || $request->ajax())
                ? response()
                    ->json([
                        'status'    => false,
                        'code'      => 406,
                        'text'      => config('code.406'),
                        'message'   => 'Mynt ID already created.',
                        'data'      => null
                    ])
                : redirect()
                    ->back()
                    ->with('warning', 'Email and account number do not match.');

        $account->update(['mynt_id' => $request->input('mynt_id')]);

        $member = Member::where('email', $email)
                            ->whereHas('accounts', function ($query) use ($acc_no) {
                                $query->where('accounts.number', $acc_no);
                            })
                            ->with('companies', 'accounts')
                            ->first();

        return ($request->isJson() || $request->ajax())
            ? response()
                ->json([
                    'status'    => true,
                    'code'      => 201,
                    'text'      => config('code.201'),
                    'message'   => 'MYNT ID was successfully created.',
                    'data'      => compact('member')
                ])
            : redirect()
                ->back()
                ->with(compact('member'))
                ->with('success', 'MYNT ID was successfully created.');
    }


    /**
     * @param $accountNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function last_balance($accountNumber)
    {
        $lastBalance = $this->account->getLastBalance($accountNumber);

        return response()
            ->json([
                'status'    => true,
                'code'      => 200,
                'message'   => config('code.200'),
                'text'      => 'Last balance of member`s account',
                'data'      => compact('lastBalance')
            ]);
    }

    public function sortMemberNeedConfirmation(Request $request)
    {
        if (is_null($request->input('search')))
            return redirect()->route('member.approval');

        $members = $this->member->sortConfirmationUser($request->input('search'), (int) 15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-approval', compact('members'), 200);
    }

    public function sortAllMember(Request $request)
    {
        if (is_null($request->input('search')))
            return redirect()->route('member.index');

        $members = $this->member->sortAllUser($request->input('search'), (int) 15);

        $members->map(function($member){
            $member['type'] = count($member->profiles) > 0 ? 'registered' : 'unregistered';
            if ($member['type'] == 'unregistered')
            {
                $confirmations = DB::table('confirmations')->where('user_id', $member['id'])->get();
                $member['status'] = count($confirmations) > 0 ? 'pending' : 'confirmed';
            } else {
                $member['status'] = $member->profiles->first()['status'];
            }
        });

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member', compact('members'), 200);
    }

    public function sortDeactivatePage(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('member.deactivate');

        $members = $this->member->sortAllUser($request->input('search'), (int) 15);

        $members->map(function($member){
            $member['type'] = count($member->profiles) > 0 ? 'registered' : 'unregistered';
            if ($member['type'] == 'unregistered')
            {
                $confirmations = DB::table('confirmations')->where('user_id', $member['id'])->get();
                $member['status'] = count($confirmations) > 0 ? 'pending' : 'confirmed';
            } else {
                $member['status'] = $member->profiles->first()['status'];
            }
        });

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-deactivate', compact('members'), 200);
    }

    public function sortPendingUpgrade(Request $request)
    {
        if (is_null($request->input('search')))
            return redirect()->route('member.pending_upgrade');

        $members = $this->member->sortListMemberNeededApproved($request->input('search'), 15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-pending_upgrade', compact('members'), 200);
    }

    public function sortChildAccount(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('member.child_account');

        $members = Member::where(function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%'.$request->input('search'))
                    ->orWhere('email', 'ILIKE', '%'.$request->input('search'))
                    ->orWhere('phone', 'ILIKE', '%'.$request->input('search'));
            })
            ->whereHas('accounts', function ($query) {
                $query->whereHas('account_type', function ($query) {
                    $query->where('id', '=', 2);
                });
            })
            ->paginate(15);

        $members->map(function ($member) {
            $parent = Member::whereHas('user', function ($query) use ($member) {
                    $query->whereHas('childrens', function ($query) use ($member) {
                        $query->where('childrens.user_id', '=', $member->id);
                    });
                })
                ->where(function ($query) use ($request) {
                    $query->where('name', 'ILIKE', '%'.$request->input('search'));
                })
                ->whereHas('accounts', function ($query) {
                    $query->whereHas('account_type', function ($query) {
                        $query->where('id', '=', 1);
                    });
                });

            $member['parent_account'] = $parent->accounts()->first()['number'];
            $member['parent_name'] = $parent->name;
        });

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-child_account', compact('members'), 200);
    }

    public function sortDocument(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('member.document');

        $members = $this->member->sortAllUser($request->input('search'), (int) 15);

        $members->map(function($member){
            $member['type'] = count($member->profiles) > 0 ? 'registered' : 'unregistered';
            
            if ($member['type'] == 'unregistered')
            {
                $confirmations = DB::table('confirmations')->where('user_id', $member['id'])->get();
                $member['status'] = count($confirmations) > 0 ? 'pending' : 'confirmed';
            } else {
                $member['status'] = $member->profiles->first()['status'];
            }
        });

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-document', compact('members'), 200);
    }

    public function sortTransactions(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('member.transactions');

        $members = $this->member->sortAllUser($request->input('search'), (int) 15);

        $members->map(function($member){
            $member['type'] = count($member->profiles) > 0 ? 'registered' : 'unregistered';

            if ($member['type'] == 'unregistered')
            {
                $confirmations = DB::table('confirmations')->where('user_id', $member['id'])->get();
                $member['status'] = count($confirmations) > 0 ? 'pending' : 'confirmed';
            } else {
                $member['status'] = $member->profiles->first()['status'];
            }
        });

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('members'), 200)
            : response()->view('pages.member-transactions', compact('members'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function detailTransactions($id, Request $request)
    {
        $member = Member::find($id, ['*']);
        
        $transactions = Transaction::whereHas('accounts', function ($query) use ($id) {
                $query->whereHas('members', function ($query) use ($id) {
                    $query->where('members.id', '=', $id);
                });
            })
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('member', 'transactions'), 200)
            : response()->view('pages.member-detail-transactions', compact('member', 'transactions'), 200);
    }

    /**
     * Display sorted listing of member transactions
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sortDetailTransactions($id, Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('member.detail.transactions.index', $id);

        $member = Member::find($id, ['*']);
        
        $transactions = Transaction::whereHas('accounts', function ($query) use ($id) {
                $query->whereHas('members', function ($query) use ($id) {
                    $query->where('members.id', '=', $id);
                });
            })
            ->where(function ($query) use ($request) {
                $query->where(DB::raw('trx_id::TEXT'), 'LIKE', '%'.$request->input('search').'%')
                    ->orWhere('sender_account_number', 'LIKE', '%'.$request->input('search').'%')
                    ->orWhere('receiver_account_number', 'LIKE', '%'.$request->input('search').'%');
            })
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('member', 'transactions'), 200)
            : response()->view('pages.member-detail-transactions', compact('member', 'transactions'), 200);
    }

    public function upgrade(Request $request)
    {
        $user = Auth::user()->members->first();

        $member = $this->member->get($user->id);

        if (!$member)
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 400,
                    'message'   => config('code.400'),
                    'text'      => 'Your identity is not recognized by the system.',
                    'data'      => compact(null)
                ], 400);

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

        $expired_date = date('Y-m-d', strtotime($request->input('identity_date')));
        $now = date('Y-m-d', strtotime(Carbon::now()->toDateString()));

        if ($request->input('identity_date_type') == 'lifetime')
        {
            $dob = date('Y-m-d', strtotime($request->input('born_date')));
            $expired_date = date('Y-m-d', strtotime(date('Y-m-d', strtotime($dob)) . ' + 200 year'));
        }

        if ($expired_date <= $now) {
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 400,
                    'message'   => config('code.400'),
                    'text'      => 'Your identity document date has expired. We are unable to process your request to upgrade your account.',
                    'data'      => compact(null)
                ], 400);
        }

        $profile = $this->member->upgrade($member->id, [
            'gender'                    => $request->input('gender'),
            'born_place'                => $request->input('born_place'),
            'born_date'                 => $request->input('born_date'),
            'identity_id'               => $request->input('identity_type'),
            'identity_number'           => $request->input('identity_number'),
            'identity_expired_date'     => $expired_date,
            'mother_name'               => $request->input('mother_name'),
            'document'                  => $filename,
            'status'                    => 'pending',
        ]);

        if (!$profile)
            return response()
                ->json([
                    'status'    => false,
                    'code'      => 400,
                    'message'   => config('code.400'),
                    'text'      => 'Process failed, our server is very busy, please try again later.',
                    'data'      => compact(null)
                ], 400);

        Mail::to($user->email)->send(new UpgradeNotification(Auth::user()));

        return response()
            ->json([
                'status'    => true,
                'code'      => 200,
                'message'   => config('code.200'),
                'text'      => 'We will review your input data to validate the identity validity. Your account will be systematically upgraded if your documents and data have been processed. This process will take up to 24 hours. Please check back. Thank you.',
                'data'      => compact('member')
            ], 200);
    }
}