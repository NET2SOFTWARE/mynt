@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => 'accounting'])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3" style="min-height:624px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.accounting') }}">Account Balance</a></li>
                        </ul>
                    </section>
                    <section class="card-block d-flex flex-column justify-content-between">
                        <section class="col-auto w-100 d-flex justify-content-end">
                            <section class="mb-3 d-flex justify-content-between">
                                <form method="POST" action="{{ route('company.sort.accounting') }}" class="form-inline" accept-charset="utf-8" role="form">
                                    {{ csrf_field() }}
                                    <section class="input-group input-group-sm input-daterange">
                                        <label for="sort-from" class="sr-only"></label>
                                        <input id="start_date" name="start_date" type="text" class="form-control" value="{{ date('d-m-Y') }}" style="max-width:105px">
                                        <span class="input-group-addon" id="to">To</span>
                                        <label for="sort-to" class="sr-only"></label>
                                        <input id="end_date" name="end_date" type="text" class="form-control" value="{{ date('d-m-Y') }}" style="max-width:105px">
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-secondary">&nbsp;Find&nbsp;</button>
                                    </span>
                                    </section>
                                </form>
                            </section>
                        </section>
                        <section class="col px-0 table-sm table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>TRANSACTION TIME</th>
                                    <th>TRANSACTION NAME</th>
                                    <th class="text-center">TRANSACTION ID</th>
                                    <th class="text-center">RELATED ACCOUNT</th>
                                    <th class="text-center">DEBIT</th>
                                    <th class="text-center">CREDIT</th>
                                    <th class="text-center" style="width:88px">BALANCE</th>
                                </tr>
                                </thead>
                                <tbody class="medium-small">
                                @foreach($passbooks as $passbook)
                                    <tr>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($passbook->created_at)) }}</td>
                                        <td>{{ $passbook->transaction->service->name }}</td>
                                        <td class="text-center">{{ $passbook->transaction->trx_id }}</td>
                                        <td class="text-center">
                                            @if ($passbook->transaction->sender_account_number == $account->number)
                                            {{ $passbook->transaction->receiver_account_number }}
                                            @else
                                            {{ $passbook->transaction->sender_account_number }}
                                            @endif
                                        </td>
                                        <td class="text-center">{{ 'Rp ' . number_format($passbook->debit) }}</td>
                                        <td class="text-center">{{ 'Rp ' . number_format($passbook->credit) }}</td>
                                        <td class="text-center">{{ 'Rp ' . number_format($passbook->balance) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection

@section('script')
    <script type="text/javascript">
        (function ($) {
            'use strict';
            $('.input-daterange input').each(function() {
                $(this).datepicker({
                    clearDates:true,
                    autoclose: true,
                    format: 'dd-mm-yyyy',
                });
            });
        })(jQuery);
    </script>
@endsection
