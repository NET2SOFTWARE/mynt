@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => 'transaction'])@endcomponent
            <section class="col-md-9 py-3">
                <h6 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">Transaction</h6>
                <section class="card" style="min-height:556px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.transaction.account') }}">Transfer To Account</a></li>
                            <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.transaction.bank') }}">Transfer To Bank</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.transaction.remittance') }}">Remittance ( MYNT to Cash )</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.transaction.redeem') }}">Redeem</a></li>
                        </ul>
                    </section>
                    <section class="card-block">

                    </section>
                    <section class="card-footer">
                        <small class="text-muted">Note : If you have a trouble, please contact our cumtumer service.</small>
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