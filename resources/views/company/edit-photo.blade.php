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
                <section class="card mt-3" style="min-height:624px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.management.account') }}">Personal Account</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="row">
                            <section class="col-sm-8 col-md-8 px-md-5">
                                <h6 class="medium d-flex justify-content-between">
                                    <small class="text-uppercase text-warning mb-1">IDENTITY</small>
                                    <a href="javascript:void(0)" class="text-muted" data-toggle="tooltip" data-placement="top" title="Edit member identity"><i class="fa fa-pencil-square-o align-text-top" style="font-size:14px;line-height:inherit;font-style:normal" aria-hidden="true"></i></a>
                                </h6>
                                <hr class="mt-0 mb-1">
                                <ul class="list-group list-group-flush medium-small lh-1-2 mb-5">
                                    <li class="list-group-item justify-content-between border-top-0">
                                        Full name
                                        <span>{{ Auth::user()->name }}</span>
                                    </li>
                                    <li class="list-group-item justify-content-between">
                                        Phone
                                        <span>{{ Auth::user()->phone }}</span>
                                    </li>
                                </ul>
                                <h6 class="medium d-flex justify-content-between align-items-baseline">
                                    <small class="text-uppercase text-warning mb-1">CREDENTIAL</small>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#myntModal" class="text-muted" data-toggle="tooltip" data-placement="top" title="Change password"><i class="fa fa-pencil-square-o align-text-top" style="font-size:14px;line-height:inherit;font-style:normal" aria-hidden="true"></i></a>
                                </h6>
                                <hr class="mt-0 mb-1">
                                <ul class="list-group list-group-flush medium-small lh-1-2 mb-5">
                                    <li class="list-group-item justify-content-between border-top-0">
                                        E-mail address
                                        <span>{{ Auth::user()->email }}</span>
                                    </li>
                                    <li class="list-group-item justify-content-between">
                                        Password
                                        <span>
                                            <strong>&#42;&#42;&#42;&#42;&#42;</strong>
                                        </span>
                                    </li>
                                </ul>
                                <h6 class="medium d-flex justify-content-between align-items-baseline lh-1-5">
                                    <small class="text-uppercase text-warning mb-1">BANK</small>
                                    <span>
                                        @if(count(Auth::user()->members->first()['banks'])>=1)
                                            <a href="{{ route('member.management.bank') }}" class="text-muted" data-toggle="tooltip" data-placement="top" title="Edit bank account"><i class="fa fa-pencil-square-o align-text-top" style="font-size:14px;line-height:inherit;font-style:normal" aria-hidden="true"></i></a>
                                        @else
                                            <a href="{{ route('member.management.bank') }}" class="text-muted" data-toggle="tooltip" data-placement="top" title="Register new bank account"><i class="fa fa-address-card-o align-text-top" style="font-size:14px;line-height:inherit;font-style:normal" aria-hidden="true"></i></a>
                                        @endif
                                    </span>
                                </h6>
                                <hr class="mt-0">
                                @if(count(Auth::user()->members->first()['banks']) >= 1)
                                    <p class="mb-0 d-flex justify-content-between medium-small lh-1-2">
                                        <span>{{ Auth::user()->members->first()['banks'][0]['bank_code'] }}</span>
                                        <span>{{ strtoupper(Auth::user()->members->first()['banks'][0]['bank_name']) }}</span>
                                        <span>{{ Auth::user()->members->first()['banks'][0]['pivot']['account_number'] }}</span>
                                    </p>
                                @else
                                    <p class="medium-small text-grey">No registered bank account yet.</p>
                                @endif
                            </section>
                            <section class="col-sm-4 col-md-4">
                                <section class="card medium">
                                    <section class="card-img-top text-center mt-3">
                                        <img src="{{ asset('img/member/member.jpg') }}" alt="{{ Auth::user()->name }}" class="rounded-circle">
                                    </section>
                                    <section class="card-block text-center">
                                        <section class="text-center mb-3">
                                            <a href="#" class="btn btn-sm py-0 btn-outline-success" data-toggle="modal" data-target="#myntModal">Upload Photo</a>
                                        </section>
                                    </section>
                                    <ul class="list-group list-group-flush medium-small lh-1-2">
                                        <li class="list-group-item justify-content-between">No. Acc <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['number'] }}</span></li>
                                        <li class="list-group-item justify-content-between">MYNT ID <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['mynt_id'] }}</span></li>
                                        <li class="list-group-item justify-content-between">Balance Limit <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['limit_balance'] }}</span></li>
                                        <li class="list-group-item justify-content-between">Transaction Limit <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['limit_balance_transaction'] }}</span></li>
                                        <li class="list-group-item justify-content-between border-bottom-0">Register date<span class="text-muted">{{ date('d-m-Y', strtotime(Auth::user()->created_at)) }}</span></li>
                                    </ul>
                                    <section class="card-footer">
                                        <small class="text-muted">Last updated {{ Auth::user()->updated_at }}</small>
                                    </section>
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection