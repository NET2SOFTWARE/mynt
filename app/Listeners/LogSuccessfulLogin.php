<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogin
{
    protected $request;

    /**
     * Create the event listener.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     * @param Login $event
     * @param null $guard
     */
    public function handle(Login $event, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch ($guard) {
                case 'admin':
                    break;
                default:
                    $event->user->log_logins()->create(
                        ['ip_address' => is_null($this->request->ip()) ? 'unknown' : $this->request->ip()]
                    );
                    break;
            }
        }
    }
}
