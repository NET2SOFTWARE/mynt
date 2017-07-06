<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    public function index()
    {
        return response()
            ->view('member.purchase.index', compact(null), 200);
    }
}
