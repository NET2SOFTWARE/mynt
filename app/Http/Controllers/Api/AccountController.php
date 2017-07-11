<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function report(Request $request)
    {
        $data = [];

        return response()->view('pages.report-account', compact('data'), 200);
    }

    public function reportShow(Request $request)
    {
        $data = [];

        return response()->view('pages.report-account-show', compact('data'), 200);
    }
}
