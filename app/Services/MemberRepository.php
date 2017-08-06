<?php

namespace App\Services;

use DB;
use App\User;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\Children;
use App\Models\Confirmation;
use App\Contracts\UserInterface;
use App\Contracts\AccountInterface;
use App\Contracts\ProfileInterface;
use App\Contracts\MemberInterface;
use App\Contracts\AbstractInterface;

class MemberRepository extends AbstractInterface implements MemberInterface
{

    /**
     * @var ProfileInterface
     */
    protected $profile;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var AccountInterface
     */
    protected $account;

    /**
     * MemberRepository constructor.
     * @param Member $model
     * @param ProfileInterface $profile
     * @param UserInterface $user
     * @param AccountInterface $account
     */
    public function __construct(
        Member              $model,
        ProfileInterface    $profile,
        UserInterface       $user,
        AccountInterface    $account
    )
    {
        parent::__construct($model);

        $this->profile      = $profile;
        $this->user         = $user;
        $this->account      = $account;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes)
    {
        return [
            'name'      => $attributes['name'],
            'email'     => $attributes['email'],
            'phone'     => $attributes['phone'],
        ];
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createProfile(array $data)
    {
        // TODO: Implement createProfile() method.
    }

    /**
     * @param int $memberId
     * @param int $contactId
     * @return mixed
     */
    public function attachContact(int $memberId, int $contactId)
    {
        $member = $this->get($memberId);

        return $member->users()->attach($contactId);
    }

    /**
     * @param int $memberId
     * @param int $locationId
     * @return mixed
     */
    public function attachLocation(int $memberId, int $locationId)
    {
        // TODO: Implement attachLocation() method.
    }

    /**
     * @param int $memberId
     * @param int $accountId
     * @return mixed
     */
    public function attachAccount(int $memberId, int $accountId)
    {
        // TODO: Implement attachAccount() method.
    }

    /**
     * @param int $memberId
     * @param int $bankId
     * @return mixed
     */
    public function attachBank(int $memberId, int $bankId)
    {
        // TODO: Implement attachBank() method.
    }

    /**
     * @param int $memberId
     * @param int $roleId
     * @return mixed
     */
    public function attachRole(int $memberId, int $roleId)
    {
        // TODO: Implement attachRole() method.
    }

    /**
     * @param int $memberId
     * @param int $companyId
     * @return mixed
     */
    public function attachCompany(int $memberId, int $companyId)
    {
        return $this->model
                    ->companies()
                    ->attach($companyId);
    }

    /**
     * @param int $memberId
     * @param int $userId
     * @return mixed
     */
    public function attachUser(int $memberId, int $userId)
    {
        $member = $this->get($memberId);

        $member->users()->attach($userId);
    }

    /**
     * @param int $memberId
     * @return mixed
     */
    public function getMyntId(int $memberId)
    {
        $member = $this->model->where('id', '=', $memberId)->first();

        if (!$member)
            return null;

        return $member->accounts->first()->mynt_id;
    }

    /**
     * @param int $memberId
     * @param array $data
     * @return mixed
     * @internal param $member
     */
    public function upgrade(int $memberId, array $data)
    {
        $profile = $this->profile->insert($this->profile->attribute($data));

        if (!$profile)
            return false;

        $member = $this->model->where('id', '=', $memberId)->first();

        $member->profiles()->attach($profile->id);

        return true;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getMemberByUserId(int $id)
    {
        $member = $this->model->whereHas('users', function ($query) use ($id) {
            $query->where('users.id', '=', $id);
        })->with('accounts', 'companies', 'profiles')->first();

        return $member;
    }

    /**
     * @return mixed
     */
    public function getChildAccount()
    {
        $member = $this->model
                        ->with('companies', 'accounts', 'locations', 'profiles', 'banks', 'users')
                        ->whereHas('accounts', function ($query) {
                            $query->where('accounts.account_type_id', '=', 2);
                        })->paginate(20);

        foreach ($member as $row)
        {
            // ->$row->users->first()['id'];

            $child_id = DB::table('childrens')
                ->where('user_id', '=', $row->users->first()['id'])
                ->get()
                ->first()
                ->id;

            $parent = DB::table('user_childrens')
                ->join('user_members', 'user_members.user_id', '=', 'user_childrens.user_id')
                ->join('members', 'members.id', '=', 'user_members.member_id')
                ->join('member_accounts', 'member_accounts.member_id', '=', 'members.id')
                ->join('accounts', 'accounts.id', '=', 'member_accounts.account_id')
                ->where('children_id', '=', $child_id)
                ->get()
                ->first();

            $row->parent_account = $parent->number;

            // $row->parent_account = DB::table('user_childrens')
            //     ->select('user_id as id')
            //     ->where('user_id', '=', $row->users->first()['id'])
            //     ->get();
        } 

        return $member;
    }

    /**
     * @return mixed
     */
    public function getUnRegister()
    {
        $member = $this->model
                        ->with('companies', 'accounts', 'locations', 'profiles', 'banks')
                        ->doesntHave('profiles')->paginate(20);

        return $member;
    }

    /**
     * @return mixed
     */
    public function getAccountable()
    {
        $member = $this->model->with('companies', 'accounts', 'locations', 'profiles', 'banks')
                            ->whereHas('accounts', function ($q) {
                                $q->where('account_type_id', '=', 1);
                            })->paginate(20);

        return $member;
    }

    /**
     * @param int $id
     * @param $accountNumber
     * @return mixed
     */
    public function approve(int $id, $accountNumber)
    {
        $member = $this->model->where('id', '=', $id)->whereHas('accounts', function ($query) use ($accountNumber) {
            $query->where('accounts.number', '=', $accountNumber);
        })->with('profiles', 'accounts')->first();

        if ($member->profiles->first()['status'] == 'approved')
            return null;

        if (!$member->profiles()->update([
            'status' => 'approved'
        ]))
            return false;

        if (!$member->accounts()->update([
            'limit_balance' => 10000000,
            'limit_balance_transaction' => 20000000
        ])) {
            $member->profiles()->update([
                'status' => 'pending'
            ]);
            return false;
        }

        return true;

    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function createChildAccount(int $id, array $data)
    {
        $user = $this->user->save(array(
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
            'phone'     => $data['phone'],
            'isConfirmed' => false
        ));

        if (!$user) return false;

        $member = $this->save(array(
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone']
        ));

        if (!$member) {
            $user->forceDelete();
            return false;
        }

        $account = $this->account->save(array(
            'number'            => $data['referral'] . date('y'),
            'account_type_id'   => 2,
            'mynt_id'           => null,
            'limit_balance'     => $data['limit_balance'],
            'limit_balance_transaction' => $data['limit_balance_transaction']
        ));

        if (!$account) {
            $user->forceDelete();
            $member->forceDelete();
            return false;
        }

        $child = new Children;
        $child->user_id = $user->id;
        $child->save();

        if (!$child) {
            $user->forceDelete();
            $member->forceDelete();
            $account->delete();
            return false;
        }

        $member->accounts()->attach($account->id);
        $user->members()->attach($member->id);

        $child->users()->attach($id);

        $child_user = User::find($user->id);

        return $child_user;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data)
    {
        $member = new Member;

        foreach ($data as $index => $value) { $member->$index = $value; }

        $member->save();

        return (!$member) ? false : Member::find($member->id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deActiveAccount(int $id)
    {
        $user = User::withTrashed()
            ->whereHas('members', function ($query) use ($id) {
                $query->where('members.id', '=', $id);
            })
            ->first();

        // $status = $user->update(['deleted_at' => Carbon::now()]);
        
        if ($user->deleted_at == null)
        {
            $status = $user->delete();
        } else {
            $status = $user->restore();
        }

        return (!$status) ? false : true;
    }

    public function getListPendingApproval(int $limit = 15)
    {
        $member = Member::whereHas('profiles', function ($query) {
            $query->where('status', '=', 'pending');
        })->paginate($limit);

        return $member;
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getListMemberNeededApproved(int $limit = 15)
    {
        $user = Confirmation::all();

        $ids = [];

        foreach ($user as $index) { $ids[] = $index['user_id']; }

        $member = Member::whereHas('users', function ($query) use ($ids) {
            $query->whereIn('users.id', $ids);
        })->paginate((int) $limit);

        return $member;
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function confirmUser(int $userId)
    {
        $confirmation = Confirmation::where('user_id', '=', $userId)->first();

        if (!$confirmation) return false;

        $confirmation->delete();

        return $this->getListMemberNeededApproved((int) 15);
    }

    /**
     * @param string $search
     * @param int $limit
     * @return mixed
     */
    public function sortConfirmationUser(string $search, int $limit)
    {
        $user = Confirmation::all();

        $ids = [];

        foreach ($user as $index) { $ids[] = $index['user_id']; }

        $member = Member::where('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('phone', 'LIKE', '%'.$search.'%')
                        ->orWhere('email', 'LIKE', '%'.$search.'%')
                        ->whereHas('users', function ($query) use ($ids) {
                            $query->whereIn('users.id', $ids);
                        })
                    ->paginate((int) $limit);

        return $member;
    }

    /**
     * @param string $search
     * @param int $limit
     * @return mixed
     */
    public function sortAllUser(string $search, int $limit)
    {
        $member = Member::with(['accounts' => function($q){ $q->orderBy('number', 'desc'); }])
            ->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('email', 'LIKE', '%'.$search.'%')
            ->orWhere('phone', 'LIKE', '%'.$search.'%')
            ->paginate($limit);

        return $member;
    }

    /**
     * @param string $search
     * @param int $limit
     * @return mixed
     */
    public function sortListMemberNeededApproved(string $search, int $limit = 15)
    {
        $user = Confirmation::all();

        $ids = [];

        foreach ($user as $index) { $ids[] = $index['user_id']; }

        $member = Member::where('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('email', 'LIKE', '%'.$search.'%')
                            ->orWhere('phone', 'LIKE', '%'.$search.'%')
                            ->whereHas('users', function ($query) use ($ids) {
                                $query->whereIn('users.id', $ids);
                            })->paginate((int) $limit);

        return $member;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getMemberReferralByMemberId(int $id)
    {
        $member = Member::find($id);

        return (count($member->companies) < 1)
            ? false
            : $member->companies->first()['code'];
    }
}