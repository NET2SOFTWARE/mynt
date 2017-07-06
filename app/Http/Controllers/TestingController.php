<?php

namespace App\Http\Controllers;

use App\Contracts\MemberInterface;
use Illuminate\Http\Request;


class TestingController extends Controller
{
    public $app;

    public function __construct(MemberInterface $app)
    {
        $this->app = $app;
    }

    public function testing(Request $request)
    {
        $referral = $this->app->getMemberReferralByMemberId($request->get('id'));

        return (!$referral) ? 'false' : $referral;
    }
}
