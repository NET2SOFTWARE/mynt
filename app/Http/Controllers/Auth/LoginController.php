<?php namespace App\Http\Controllers\Auth;

use App\Models\Company;

use Illuminate\Http\Request;
use App\Contracts\UserInterface;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    /**
     * @var UserInterface
     */
    private $user;
    /**
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * LoginController constructor.
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->middleware('guest')->except('logout');
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return response()->view('auth.login', compact(null), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showLoginMemberCompanyForm()
    {
        $companies = Company::whereNotIn('id', [1])->get();
        return response()->view('auth.login-member-company', compact('companies'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showLoginMerchantForm()
    {
        return response()->view('auth.login-merchant', compact(null), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showLoginCompanyForm()
    {
        return response()->view('auth.login-company', compact(null), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if (!$id = $this->user->isUserExistsByReferral($this->email($request), $this->defaultReferral())) {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
        if ($this->attemptLogin($id, $request)) {
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param $id
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin($id, Request $request)
    {
        return $this->guard()->attempt(array_add($this->credentials($request), 'id', $id), $request->has('remember'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function loginMemberCompany(Request $request)
    {
        $this->validateLoginMember($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if (!$id = $this->user->isUserExistsByReferral($this->email($request), $this->referralCode($request))) {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
        if ($this->attemptLoginMemberCompany($id, $request)) {
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function loginMerchant(Request $request)
    {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if (!$id = $this->user->isMerchant($this->email($request))) {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
        if ($this->attemptLogin($id, $request)) {
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function loginCompany(Request $request)
    {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if (!$id = $this->user->isCompany($this->email($request))) {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
        if ($this->attemptLogin($id, $request)) {
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param Request $request
     */
    protected function validateLoginMember(Request $request)
    {
        $this->validate($request, [$this->username() => 'required|string', 'password' => 'required|string', $this->referral() => 'required|exists:companies,code']);
    }

    /**
     * @param $id
     * @param Request $request
     * @return bool
     */
    protected function attemptLoginMemberCompany($id, Request $request)
    {
        return $this->guard()->attempt(array_add($this->credentials($request), 'id', $id), $request->has('remember'));
    }

    /**
     * @return string
     */
    protected function referral()
    {
        return 'code';
    }

    /**
     * @param Request $request
     * @return array|string
     */
    protected function referralCode(Request $request)
    {
        return $request->input($this->referral());
    }

    /**
     * @param Request $request
     * @return array|string
     */
    protected function email(Request $request)
    {
        return $request->input($this->username());
    }

    /**
     * @return string
     */
    protected function defaultReferral()
    {
        return '000';
    }
}