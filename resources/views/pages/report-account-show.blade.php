@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'admin'])
    @endcomponent
@endsection

@section('content')
    <article class="container-fluid">
        <section class="row">
            @component('components.aside')
            @endcomponent
            <section class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2 p-0">
                <section class="header-content justify-content-between align-items-baseline">
                    <section>
                        <p class="medium lh-1-5 mb-0">REPORT ACCOUNT</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="mr-2">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('report.account.index') }}" class="btn btn-secondary">Back</a>
                            </section>
                        </section>
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                {{-- <a href="{{ route('report.account.print') }}" class="btn btn-secondary">Print</a> --}}
                                <a href="{{ route('report.account.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                    </section>
                </section>
                {{-- Chart : start --}}
                <div class="container p-0">
                    <div class="card m-3">
                        <div class="row p-0" style="min-height:200px;">
                            <div class="col-md-8">
                                <table class="table small mb-0 h-100" style="border-right: 1px solid #e9eaec;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                <p class="lead m-0 p-2">
                                                    Accounts
                                                </p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="p-3"><strong>Company</strong></td>
                                            <td class="p-3 text-right">{{ number_format($data['count_company']) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="p-3"><strong>Merchant</strong></td>
                                            <td class="p-3 text-right">{{ number_format($data['count_merchant']) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="p-3"><strong>Member</strong> <span class="badge badge-default small-caps">unregistered</span></td>
                                            <td class="p-3 text-right">{{ number_format($data['count_member_unregis']) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="p-3"><strong>Member</strong> <span class="badge badge-success small-caps">registered</span> <span class="badge badge-primary small-caps">parent</span></td>
                                            <td class="p-3 text-right">{{ number_format($data['count_member_parent']) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="p-3"><strong>Member</strong> <span class="badge badge-success small-caps">registered</span> <span class="badge badge-info small-caps">child</span></td>
                                            <td class="p-3 text-right">{{ number_format($data['count_member_child']) }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="p-3 text-muted"><strong>Total Accounts</strong></td>
                                            <td class="p-3 text-right text-muted"><strong>{{ number_format($data['count_account']) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-4" style="overflow: hidden;">
                                <div id="chart-1" style="position:absolute; width: auto; left: 0; right: 20px; top: 50%; margin-top: -25%;"></div>
                                {!! Lava::render('PieChart', 'Accounts', 'chart-1') !!}
                            </div>
                        </div>
                    </div>

                    <div class="card m-3">
                        <div class="row p-0" style="min-height:200px;">
                            <div class="col-md-8">
                                <table class="table small mb-0 h-100" style="border-right: 1px solid #e9eaec;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                <p class="lead m-0 p-2">
                                                    Closed Accounts
                                                </p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="p-3"><strong>Active Accounts</strong></td>
                                            <td class="p-3 text-right">{{ number_format($data['count_account']) }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="p-3 text-muted"><strong>Total Closed Accounts</strong></td>
                                            <td class="p-3 text-right text-muted"><strong>0</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-4" style="overflow: hidden;">
                                <div id="chart-2" style="position:absolute; width: auto; left: 0; right: 20px; top: 50%; margin-top: -25%;"></div>
                                {!! Lava::render('PieChart', 'ClosedAccounts', 'chart-2') !!}
                            </div>
                        </div>
                    </div>

                    <div class="card m-3">
                        <div class="row p-0" style="min-height:200px;">
                            <div class="col-md-8">
                                <table class="table small mb-0 h-100" style="border-right: 1px solid #e9eaec;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                <p class="lead m-0 p-2">
                                                    Transactions by Service
                                                </p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['services'] as $service)
                                        <tr>
                                            <td class="p-3"><strong>{{ ucfirst($service->name) }}</strong></td>
                                            <td class="p-3 text-right">{{ number_format($service->transaction->count()) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="p-3 text-muted"><strong>Total Transactions</strong></td>
                                            <td class="p-3 text-right text-muted">
                                                <strong>
                                                    @php ($total = 0)
                                                    @foreach ($data['services'] as $service)
                                                    @php ($total += $service->transaction->count() )
                                                    @endforeach
                                                    {{ number_format($total) }}
                                                </strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-4" style="overflow: hidden;">
                                <div id="chart-3" style="position:absolute; width: auto; left: 0; right: 20px; top: 50%; margin-top: -25%;"></div>
                                {!! Lava::render('PieChart', 'Transactions', 'chart-3') !!}
                            </div>
                        </div>
                    </div>

                    <div class="card m-3">
                        <div class="row p-0" style="min-height:200px;">
                            <div class="col-md-8">
                                <table class="table small mb-0 h-100" style="border-right: 1px solid #e9eaec;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                <p class="lead m-0 p-2">
                                                    Transactions Amount by Service
                                                </p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['services'] as $service)
                                        <tr>
                                            <td class="p-3"><strong>{{ ucfirst($service->name) }}</strong></td>
                                            <td class="p-3 text-right">{{ sprintf('Rp %s', number_format($service->transaction->sum('amount'))) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="p-3 text-muted"><strong>Total Amount Transactions</strong></td>
                                            <td class="p-3 text-right text-muted">
                                                <strong>
                                                    @php ($total = 0)
                                                    @foreach ($data['services'] as $service)
                                                    @php ($total += $service->transaction->sum('amount') )
                                                    @endforeach
                                                    {{ sprintf('Rp %s', number_format($total)) }}
                                                </strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-4" style="overflow: hidden;">
                                <div id="chart-4" style="position:absolute; width: auto; left: 0; right: 20px; top: 50%; margin-top: -25%;"></div>
                                {!! Lava::render('PieChart', 'TransactionsAmount', 'chart-4') !!}
                            </div>
                        </div>
                    </div>

                    <div class="row px-3 pb-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="row p-0">
                                    <div class="col-md-12">
                                        <table class="table small mb-0">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">
                                                        <p class="lead m-0 p-2">
                                                            Floating Funds
                                                        </p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <td class="p-3 text-muted"><strong>Total Floating Funds</strong></td>
                                                    <td class="p-3 text-right text-muted"><strong>{{ sprintf('Rp %s', number_format($data['total_floating_fund'])) }}</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="row p-0">
                                    <div class="col-md-12">
                                        <table class="table small mb-0">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">
                                                        <p class="lead m-0 p-2">
                                                            Liabilities
                                                        </p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <td class="p-3 text-muted"><strong>Total Liabilities</strong></td>
                                                    <td class="p-3 text-right text-muted"><strong>{{ sprintf('Rp %s', number_format($data['total_liability'])) }}</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Chart : end --}}
            </section>
        </section>
    </article>
@endsection
