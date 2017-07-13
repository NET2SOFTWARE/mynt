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
