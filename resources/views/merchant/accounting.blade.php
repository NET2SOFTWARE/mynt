@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => 'accounting'])@endcomponent
            <section class="col-md-9 py-3">
                <h6 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">Account Sheet</h6>
                <section class="card my-3" style="min-height:540px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.accounting') }}">Account Balance</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="mb-3 d-flex flex-column">
                            <form method="POST" action="{{ route('merchant.sort.accounting') }}" class="form-inline align-self-end" role="form">
                                {{ csrf_field() }}
                                <section class="input-group input-group-sm mr-2 input-daterange">
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
                        <section class="table-sm table-responsive">
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
                    <section class="card-footer">
                        <small class="text-muted">Your last balance, you can check your list last balance by time period. Use "Print" sub-menu on this page.</small>
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
