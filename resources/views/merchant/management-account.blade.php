@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => 'management'])@endcomponent
            <section class="col-md-9 py-3">
                <h6 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">Management</h6>
                <section class="card my-3" style="min-height:565px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.management.account') }}">Merchant Account</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">

                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
