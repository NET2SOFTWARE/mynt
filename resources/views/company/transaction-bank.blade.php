@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => 'transaction'])@endcomponent
            <section class="col-md-9 py-3">
                <section class="card" style="min-height:612px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.transaction.account') }}">Transfer To Account</a></li>
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.transaction.bank') }}">Transfer To Bank</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.transaction.remittance') }}">Remittance ( MYNT to Cash )</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.transaction.redeem') }}">Redeem</a></li>
                        </ul>
                    </section>
                    <section class="card-block">

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