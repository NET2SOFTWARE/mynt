@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => 'management'])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3 mb-3">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.management.account') }}">Personal Account</a></li>
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <h6 class="mb-0 d-flex justify-content-between align-items-baseline">
                            Register new bank account
                            <a class="btn btn-sm btn-outline-success" href="{{ route('company.management.bank') }}">Bank to bank</a>
                        </h6>
                        <hr class="clearfix mt-2 mb-4"/>
                        <section class="px-5 my-3">
                            @if (session('warning'))
                                <section class="alert mb-3 small alert-success lh-1-2">{{ session('warning') }}</section>
                            @elseif(session('success'))
                                <section class="alert mb-3 small alert-success lh-1-2">{{ session('success') }}</section>
                            @endif
                            <form action="{{ route('company.management.bank.store') }}" method="POST" accept-charset="utf-8" role="form">
                                {{ csrf_field() }}
                                @include('forms.bank-register')
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