@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => 'summary'])@endcomponent
            <section class="col-md-9 py-3">
                <h6 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">Summary Transaction</h6>
                <section class="card my-3" style="min-height:560px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.summary.product') }}">Merchant Product</a></li>
                            <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.summary.payment') }}">MYNT Payment Product</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.summary.purchase') }}">MYNT Purchase Product</a></li>
                        </ul>
                    </section>
                    <section class="card-block">

                    </section>
                    <section class="card-footer">
                        <small class="text-muted">Note : If you have a trouble, please contact our costumer service.</small>
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
        })(jQuery);
    </script>
@endsection
