<?php

namespace App\Http\Controllers;

use App\Contracts\MemberInterface;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * @param MemberInterface $member
     */
    public function __construct(MemberInterface $member)
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role() == 6) {
            return response()->view('home-company');
        } elseif (Auth::user()->role() == 5) {
            return response()->view('home-merchant');
        }

        return response()->view('home');
    }
}
