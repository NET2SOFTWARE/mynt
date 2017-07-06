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
                        <p class="medium lh-1-5 mb-0">COMPANY DETAILED TRANSACTIONS</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('company.transactions', [$company->id]) }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('company.sort.transactions', [$company->id]) }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by transaction name or id" style="width:240px!important;" />
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $transactions->previousPageUrl() }}" class="btn btn-secondary {{ ($transactions->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $transactions->nextPageUrl() }}" class="btn btn-secondary {{ ($transactions->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <section class="header-content justify-content-between align-items-baseline">
                    <section class="btn-group btn-group-sm">
                        <a href="{{ route('company.index', ['transactions']) }}" class="btn btn-secondary"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                    </section>
                    <section>
                        <p class="medium lh-1-5 mb-0"><span class="badge badge-info">{{ $company->name }}</span></p>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                                <tr class="medium">
                                    <th>TRANSACTION TIME</th>
                                    <th>TRANSACTION NAME</th>
                                    <th>TRANSACTION ID</th>
                                    <th>DEBIT</th>
                                    <th>CREDIT</th>
                                    <th>BALANCE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at }}</td>
                                    <td>{{ $transaction->service()->first()['name'] }}</td>
                                    <td>{{ $transaction->trx_id }}</td>
                                    <td>{{ sprintf('Rp %s', number_format($transaction->passbook()->first()['debit'])) }}</td>
                                    <td>{{ sprintf('Rp %s', number_format($transaction->passbook()->first()['credit'])) }}</td>
                                    <td>{{ sprintf('Rp %s', number_format($transaction->passbook()->first()['balance'])) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                </transition>
            </section>
        </section>
    </article>
@endsection