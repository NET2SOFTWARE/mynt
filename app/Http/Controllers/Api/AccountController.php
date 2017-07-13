<?php

namespace App\Http\Controllers\Api;

use DB;
use SnappyPDF;
use Lava;
use Khill\Lavacharts\Lavacharts;
use App\Models\Account;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function report(Request $request)
    {
        return response()->view('pages.report-account', compact(null), 200);
    }

    public function reportShow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'          => 'required|string|in:daily,ranged,monthly',
            'date'          => 'required_if:type,daily|date_format:m/d/Y|before_or_equal:' . date('m/d/Y'),
            'date_from'     => 'required_if:type,ranged|date_format:m/d/Y|before:date_to',
            'date_to'       => 'required_if:type,ranged|date_format:m/d/Y|before_or_equal:' . date('m/d/Y'),
            'year'          => 'required_if:type,monthly|numeric|min:2017',
            'month'         => 'required_if:type,monthly|numeric|between:1,12',
        ]);

        if ($validator->fails()) return redirect()->route('report.account.index')->withInput()->withErrors($validator);

        $data = [];

        // $accounts = Account::get();
        $services = Service::with('transaction')->get();

        $data['services'] = $services;
        $data['count_company'] = Account::where('account_type_id', 3)->count();
        $data['count_merchant'] = Account::where('account_type_id', 4)->count();
        $data['count_member_unregis'] = Account::whereHas('members', function($q){ $q->whereHas('users', function($q){ $q->where('isConfirmed', false); }); })->count();
        $data['count_member_parent'] = Account::where('account_type_id', 1)->whereHas('members', function($q){ $q->whereHas('users', function($q){ $q->where('isConfirmed', true); }); })->count();
        $data['count_member_child'] = Account::where('account_type_id', 2)->whereHas('members', function($q){ $q->whereHas('users', function($q){ $q->where('isConfirmed', true); }); })->count();
        $data['count_account'] = Account::count();
        $data['total_floating_fund'] = 0;
        $data['total_liability'] = 0;

        $accounts = Lava::DataTable();
        $accounts->addStringColumn('Type')
            ->addNumberColumn('Counts')
            ->addRow(['Company', $data['count_company']])
            ->addRow(['Member Unregistered', $data['count_member_unregis']])
            ->addRow(['Member Registered - Child', $data['count_member_child']])
            ->addRow(['Member Registered - Parent', $data['count_member_parent']])
            ->addRow(['Merchant', $data['count_merchant']]);
            
        Lava::PieChart('Accounts', $accounts, [
            'title'  => 'Accounts',
            // 'png' => true,
        ]);

        $closedAccounts = Lava::DataTable();
        $closedAccounts->addStringColumn('Type')
            ->addNumberColumn('Count')
            ->addRow(['Active', $data['count_account']])
            ->addRow(['Closed', 0]);

        Lava::PieChart('ClosedAccounts', $closedAccounts, [
            'title'  => 'Accounts closed',
            // 'png' => true,
        ]);

        $transactions = Lava::DataTable();
        $transactions->addStringColumn('Service')->addNumberColumn('Count');

        foreach ($services as $service) $transactions->addRow([$service->name, $service->transaction->count()]);

        Lava::PieChart('Transactions', $transactions, [
            'title'  => 'Transaction count by service',
            // 'png' => true,
        ]);

        $transactionsAmount = Lava::DataTable();
        $transactionsAmount->addStringColumn('Service')->addNumberColumn('Amount');

        foreach ($services as $service) $transactionsAmount->addRow([$service->name, $service->transaction->sum('amount')]);

        Lava::PieChart('TransactionsAmount', $transactionsAmount, [
            'title'  => 'Transaction amount by service',
            // 'png' => true,
        ]);

        return response()->view('pages.report-account-show', compact('request', 'data'), 200);
    }
}
