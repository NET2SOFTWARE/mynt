<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function summary()
    {
        return response()
            ->view('merchant.summary', compact(null), 200);
    }

    public function summaryPayment()
    {
        return response()
            ->view('merchant.summary-payment-product', compact(null), 200);
    }

    public function summaryPurchase()
    {
        return response()
            ->view('merchant.summary-purchase-product', compact(null), 200);
    }
}
