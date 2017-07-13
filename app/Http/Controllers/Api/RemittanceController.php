<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;

class RemittanceController extends Controller
{
    public function register(Request $request)
    {
        Validator::make($request->all(), [])->validate();
    }

    public function delete_account(Request $request)
    {
        Validator::make($request->all(), [])->validate();
    }

    public function inquiry_status(Request $request)
    {
        Validator::make($request->all(), [])->validate();
    }

    public function inquiry(Request $request)
    {
        Validator::make($request->all(), [])->validate();
    }

    public function transfer(Request $request)
    {
        Validator::make($request->all(), [])->validate();
    }
}
