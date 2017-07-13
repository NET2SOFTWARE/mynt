@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => 'transaction'])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3" style="min-height:624px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.transaction.account') }}">Transfer to Account</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.transaction.bank') }}">Transfer to Bank</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.transaction.remittance') }}">Remittance to Cash</a></li>
                            <li class="nav-item ml-auto"><a class="nav-link active" href="{{ route('company.transaction.redeem') }}">Redeem</a></li>
                        </ul>
                    </section>
                    <section class="card-block d-flex justify-content-center align-items-center align-content-center">
                        <section class="w-75">
                            @if (session('warning'))
                                <section class="alert mb-3 small alert-success lh-1-2">{{ session('warning') }}</section>
                            @elseif(session('success'))
                                <section class="alert mb-3 small alert-success lh-1-2">{{ session('success') }}</section>
                            @endif
                            <form action="{{ route('merchant.transaction.account.store') }}" method="POST" accept-charset="utf-8" role="form">
                                {{ csrf_field() }}
                                @include('forms.company-redeem')
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