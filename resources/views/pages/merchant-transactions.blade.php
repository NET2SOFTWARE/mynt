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
                        <p class="medium lh-1-5 mb-0">MERCHANT TRANSACTIONS</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('merchant.transactions.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('merchant.transactions.sort') }}" method="POST" class="input-group input-group-sm ml-3">
                            {{ csrf_field() }}
                            <input id="search" name="search" type="search" class="form-control" placeholder="Search by name, email, phone" style="max-width:240px!important;width:240px!important;">
                            <span class="input-group-btn">
                                <button ty class="btn btn-secondary" type="submit">Find</button>
                            </span>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $merchants->previousPageUrl() }}" class="btn btn-secondary {{ ($merchants->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $merchants->nextPageUrl() }}" class="btn btn-secondary {{ ($merchants->previousPageUrl() != null) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                <th class="text-center">STATUS</th>
                                <th>MERCHANT NAME</th>
                                <th>ACCOUNT NO.</th>
                                <th>MERCHANT TYPE</th>
                                <th>DEBIT SUMMARY</th>
                                <th>CREDIT SUMMARY</th>
                                <th>BALANCE</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($merchants as $merchant)
                                <tr>
                                    <td class="text-center">
                                        @if (sizeof($merchant->users()->get()) < 1)
                                            <span class="badge small-caps badge-danger">inactive</span>
                                        @else
                                            <span class="badge small-caps badge-success">active</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $merchant->name }}
                                    </td>
                                    <td>
                                        {{ $merchant->accounts()->first()['number'] }}
                                    </td>
                                    <td>
                                        <span class="badge badge-default small-caps">{{ strtolower($merchant->account_type) }}</span>
                                    </td>
                                    <td>
                                        {{ sprintf('Rp %s', number_format($merchant->accounts()->first()->passbooks()->sum('debit'))) }}
                                    </td>
                                    <td>
                                        {{ sprintf('Rp %s', number_format($merchant->accounts()->first()->passbooks()->sum('credit'))) }}
                                    </td>
                                    <td>
                                        @if (is_null($merchant->accounts()->first()->passbooks()->first()))
                                            Rp 0
                                        @else
                                            {{ sprintf('Rp %s', number_format($merchant->accounts()->first()->passbooks()->orderBy('id', 'desc')->first()['balance'])) }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                            <a href="{{ route('merchant.transactions', [$merchant->id]) }}"
                                                class="btn btn-secondary py-0 small-caps">
                                                details
                                            </a>
                                        </div>
                                    </td>
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