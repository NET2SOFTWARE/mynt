<?php

namespace App\Http\Controllers;

use App\Services\Confirmation;
use Illuminate\Support\Facades\Auth;

/**
 * Class EmailConfirmationController
 * @package App\Http\Controllers
 */
class EmailConfirmationController extends Controller
{

    /**
     * @var Confirmation
     */
    private $confirmation;

    /**
     * EmailConfirmationController constructor.
     * @param Confirmation $confirmation
     */
    public function __construct(Confirmation $confirmation)
    {
        $this->confirmation = $confirmation;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function notification()
    {
        if (!Auth::check())
            return redirect('/login');

        $email = Auth::user()->email;

        Auth::logout();

        return response()
            ->view('confirmation', compact('email'), 200);
    }

    public function confirm($token)
    {
        if ($user = $this->confirmation->confirmUser($token)) {

            auth()->login($user);

            return redirect('/home');
        }

        return redirect()
            ->route('login')
            ->with('status', 'Your confirmation token has expired. Please request again.');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resend()
    {
        if (!Auth::check())
            return redirect('/login');

        $this->confirmation->sendConfirmationMail(Auth::user());

        return redirect()
            ->back()
            ->with('success', 'We have sent the confirmation email back to your email address : '. Auth::user()->email);
    }
}
