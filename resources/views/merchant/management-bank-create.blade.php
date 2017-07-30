@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => 'management'])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3" style="min-height:620px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.management.account') }}">Personal Account</a></li>
                            <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <header class="px-md-5 mt-3">
                            <h5 class="d-flex justify-content-between align-items-baseline">
                                Create new bank account
                                <span>
                                    <a href="{{ route('merchant.management.bank') }}" class="btn btn-sm btn-primary">Bank to list</a>
                                </span>
                            </h5>
                            <hr class="clearfix"/>
                        </header>
                        <section class="px-md-5">
                            @if (session('success'))<section class="alert alert-success">{{ session('success') }}</section>@endif
                            @if (session('warning'))<section class="alert alert-danger">{{ session('warning') }}</section>@endif
                            <form action="{{ route('merchant.management.bank.store') }}" method="post" accept-charset="utf-8" role="form">
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
            'use strict';
            $('#born-date input').each(function() {
                $(this).datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy',
                    clearDates:true
                });
            });

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
