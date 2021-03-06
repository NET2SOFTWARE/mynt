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
                            <li class="nav-item"><a class="nav-link active" href="{{ route('accounting') }}">Account Balance</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        
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
        ;(function ($) {
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
