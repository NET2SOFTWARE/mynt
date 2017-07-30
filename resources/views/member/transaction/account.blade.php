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
                    @component('components.aside-member-register', ['active' => 'transaction'])@endcomponent
                @else
                    @component('components.aside-member-unregister', ['active' => 'transaction'])@endcomponent
                @endif
            @else
                @component('components.aside-member-child', ['active' => 'transaction'])@endcomponent
            @endif
            <section class="col-md-9 py-3">
                <h5 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">
                    Transaction
                    <span>
                        @if(count(Auth::user()->members->first()['profiles']) < 1 && !Auth::user()->members->first()->isChildAccount())
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif(Auth::user()->members->first()->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </h5>
                <section class="card mt-3" style="min-height:576px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('member.transactions.account') }}">Transfer To Account</a></li>
                            @if(Auth::user()->members->first()->isRegistered() && !Auth::user()->members->first()->isChildAccount())
                            <li class="nav-item"><a class="nav-link" href="{{ route('member.transactions.bank') }}">Transfer to Bank</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('member.transactions.remittance') }}">Remittance to Cash</a></li>
                            @endif
                            <li class="nav-item ml-auto"><a class="nav-link" href="{{ route('member.transactions.redeem') }}">Redeem</a></li>
                        </ul>
                    </section>
                    <section class="card-block d-flex justify-content-center align-items-center align-content-center">
                        <section class="w-75">
                            @if (session('warning'))
                                <section class="alert mb-3 small alert-danger lh-1-2">{{ session('warning') }}</section>
                            @elseif(session('success'))
                                <section class="alert mb-3 small alert-success lh-1-2">{{ session('success') }}</section>
                            @endif
                            <form action="{{ route('member.transactions.account.store') }}" method="POST" accept-charset="utf-8" role="form">
                                {{ csrf_field() }}
                                @include('forms.transfer-account')
                            </form>
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
            $('#reload_captcha').on('click', function () {
                $.ajax({
                    method: 'GET',
                    url: '/get_captcha',
                }).done(function (response) {
                    $('#img_captcha').prop('src', response);
                });
            });
        })(jQuery);
    </script>
@endsection