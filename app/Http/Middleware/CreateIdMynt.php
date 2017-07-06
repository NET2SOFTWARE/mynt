<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CreateIdMynt
{

    private $role;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check())
            return redirect()->route('login');

        $member = null;

        if (Auth::user()->role() == 3 || Auth::user()->role() == 4) {
            $member =  Auth::user()->members->first();
        } elseif (Auth::user()->role() == 5) {
            $member =  Auth::user()->merchants->first();
        } elseif (Auth::user()->role() == 6) {
            $member =  Auth::user()->companies->first();
        }

        $account = $member->accounts->first();

        if (! is_null($account->mynt_id) )
            return $next($request);

        return redirect()
            ->action('MyntController@showForm');
    }
}
