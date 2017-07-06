<?php namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Services\Confirmation;
use App\Contracts\UserInterface;
use App\Contracts\LimitInterface;
use App\Contracts\MemberInterface;
use App\Contracts\AccountInterface;
use App\Contracts\CompanyInterface;
use App\Contracts\ContactInterface;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Contracts\RegistrationInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;
    protected $confirmation;
    protected $member;
    protected $account;
    protected $user;
    protected $limit;
    protected $company;
    protected $contact;
    private $registration;
    protected $redirectTo = '/home';

    public function __construct(MemberInterface $member, Confirmation $confirmation, AccountInterface $account, LimitInterface $limit, CompanyInterface $company, ContactInterface $contact, UserInterface $user, RegistrationInterface $registration)
    {
        $this->middleware('guest');
        $this->member = $member;
        $this->confirmation = $confirmation;
        $this->account = $account;
        $this->limit = $limit;
        $this->company = $company;
        $this->contact = $contact;
        $this->user = $user;
        $this->registration = $registration;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, ['first_name' => ['required', 'string', 'max:16', 'regex:/^\S+\w\S{1,}/'], 'last_name' => ['required', 'string', 'max:16', 'regex:/^\S+\w\S{1,}/'], 'email' => 'required|string|email|max:40', 'password' => 'required|string|min:6|confirmed', 'phone' => 'required|numeric|digits_between:6,16', 'captcha' => 'required|captcha', 'referral' => 'nullable|exists:companies,code', 'term' => 'accepted'], ['referral.exists' => 'Company code does not exist in our system.', 'term.accepted' => 'Please accepted our term & condition', 'captcha.captcha' => 'Security code not match', 'first_name.regex' => 'No space and no symbol', 'last_name.regex' => 'No space and no symbol']);
    }

    protected function create(array $data)
    {
        return User::create(['name' => strtolower($data['first_name']) . ' ' . strtolower($data['last_name']), 'email' => strtolower($data['email']), 'phone' => str_is('0*', $data['phone']) ? '62' . substr($data['phone'], 1) : $data['phone'], 'password' => bcrypt($data['password']),]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $name = strtolower($request->input('first_name')) . ' ' . strtolower($request->input('last_name'));
        $referral = (is_null($request->input('referral'))) ? '000' : $request->input('referral');
        $email = strtolower($request->input('email'));
        $phone = $request->input('phone');
        if ($id = $this->user->isUserExistsByReferral((string)$email, (string)$referral)) {
            return back()->withInput($request->except(['password']))->with('warning', 'Your email has been registered with this company,please use different email or register this email on different company.');
        }
        if ($this->user->attemptUniqueCredential($request->input('email'), $request->input('password'))) {
            $this->guard()->logout();
            return back()->withInput($request->except(['password']))->with('warning', 'Please use another account credential,we can not create your account at this moment.');
        }
        if ($this->registration->isUserHasRegisterInReferral($request->all())) return back()->withInput($request->all())->with('warning', 'You are has been registered in this company. Please,change your referral code,if you want to register another account');
        if (!$member = $this->member->save(['name' => $name, 'email' => $email, 'phone' => $phone])) return redirect()->back()->withInput($request->except(['password']))->with('warning', 'We are having problems now,please come back later');
        $company = $this->company->getCompanyByCode($referral);
        $member->companies()->attach($company->id);
        if (!$account = $this->account->save(['number' => $referral . date('y'), 'account_type_id' => 1, 'mynt_id' => null, 'limit_balance' => 1000000, 'limit_balance_transaction' => 20000000])) {
            $member->delete();
            return redirect()->back()->withInput($request->except(['password']))->with('warning', 'We are having problems now,please come back later');
        }
        $member->accounts()->attach($account->id);
        event(new Registered($user = $this->create($request->all())));
        $user->roles()->attach(3);
        $user->members()->attach($member->id);
        $this->confirmation->sendConfirmationMail($user);
        $this->guard()->login($user);
        return redirect()->action('EmailConfirmationController@notification');
    }
}