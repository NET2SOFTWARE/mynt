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
    public function summaryProduct()
    {
        return response()
            ->view('merchant.summary-product');
    }

    public function summaryPayment()
    {
        return response()
            ->view('merchant.summary-payment-product');
    }

    public function summaryPurchase()
    {
        return response()
            ->view('merchant.summary-purchase-product');
    }
}
