@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'user'])
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
                @if(Auth::user()->role() == 3)
                    @if(Auth::user()->members->first()->isRegistered())
                        @component('components.aside-member-register', ['active' => 'accounting'])@endcomponent
                    @else
                        @component('components.aside-member-unregister', ['active' => 'accounting'])@endcomponent
                    @endif
                @else
                    @component('components.aside-member-child', ['active' => 'accounting'])@endcomponent
                @endif
            <section class="col-md-9 py-3">
                <h5 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">
                    Account sheet
                    <span>
                        @if(count(Auth::user()->members->first()['profiles']) < 1 && (!Auth::user()->members->first()->isChildAccount()))
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif(Auth::user()->members->first()->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </h5>
                <section class="card my-3" style="min-height:560px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('member.accounting') }}">Account Balance</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="mb-3 d-flex justify-content-end">
                            <form class="form-inline d-flex justify-content-between">
                                <section class="input-group input-group-sm mr-2 input-daterange">
                                    <label for="sort-from" class="sr-only"></label>
                                    <input id="sort-from" name="sort-form" type="text" class="form-control" value="{{ date('d-m-Y') }}" style="max-width:105px">
                                    <span class="input-group-addon" id="to">To</span>
                                    <label for="sort-to" class="sr-only"></label>
                                    <input id="sort-to" name="sort_to" type="text" class="form-control" value="{{ date('d-m-Y') }}" style="max-width:105px">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-secondary">&nbsp;Find&nbsp;</button>
                                    </span>
                                </section>
                            </form>
                            <section class="btn-group btn-group-sm ml-3">
                                <a href="{{ $passbooks->previousPageUrl() }}" class="btn btn-secondary{{ ($passbooks->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                                <a href="{{ $passbooks->nextPageUrl() }}" class="btn btn-secondary{{ ($passbooks->hasMorePages()) ?: ' disabled' }}">Next</a>
                            </section>
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
