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
                        <p class="medium lh-1-5 mb-0">GENERAL LEDGER</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-secondary">Print</button>
                                <button type="button" class="btn btn-secondary">Refresh</button>
                            </section>
                        </section>
                        <section class="input-group input-group-sm ml-3">
                            <input id="search" name="search" type="search" class="form-control" placeholder="Search value" style="width:240px!important;">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button">Find</button>
                            </span>
                        </section>
                        <section class="btn-group btn-group-sm ml-3">
                            <button type="button" class="btn btn-secondary">Previous</button>
                            <button type="button" class="btn btn-secondary">Next</button>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                <th>CREATED DATE</th>
                                <th style="width:104px">DEBIT</th>
                                <th style="width:104px">CREDIT</th>
                                <th style="width:104px">BALANCE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($general_passbooks as $general_passbook)
                                <tr>
                                    <th>{{ date('d-m-Y H:i:s', strtotime($general_passbook->created_at)) }}</th>
                                    <td>{{ 'Rp ' . number_format($general_passbook->debit) }}</td>
                                    <td>{{ 'Rp ' . number_format($general_passbook->credit) }}</td>
                                    <td>{{ 'Rp ' . number_format($general_passbook->balance) }}</td>
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