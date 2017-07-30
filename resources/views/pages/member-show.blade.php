@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'admin'])
    @endcomponent
@endsection

@section('content')
    <article class="container-fluid">
        <section class="row">
            @component('components.aside')
            @endcomponent
            <section class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2 p-0">
            	<section class="header-content justify-content-between align-items-baseline">
                    <section>
                        <p class="medium lh-1-5 mb-0">MEMBER DETAIL</p>
                    </section>
                    <span>
                        @if(count($member->has('profiles')) < 1 && (!$member->isChildAccount()))
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif($member->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </section>
                <section class="card m-3" style="min-height:525px">
                    <section class="card-block">
                        <section class="row">
                            <section class="col-sm-8 col-md-8 px-md-3">
                                <h6 class="medium d-flex justify-content-between">
                                    <small class="text-uppercase text-warning mb-1">IDENTITY</small>
                                </h6>
                                <hr class="mt-0 mb-1">
                                <ul class="list-group list-group-flush medium-small lh-1-2 mb-5">
                                    <li class="list-group-item justify-content-between border-top-0">
                                        Full name
                                        <span>{{ $member->name }}</span>
                                    </li>
                                    <li class="list-group-item justify-content-between">
                                        Phone
                                        <span>{{ $member->phone }}</span>
                                    </li>
                                </ul>
                                <h6 class="medium d-flex justify-content-between align-items-baseline">
                                    <small class="text-uppercase text-warning mb-1">CREDENTIAL</small>
                                </h6>
                                <hr class="mt-0 mb-1">
                                <ul class="list-group list-group-flush medium-small lh-1-2 mb-5">
                                    <li class="list-group-item justify-content-between border-top-0">
                                        E-mail address
                                        <span>{{ $member->email }}</span>
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
                                </h6>
                                <hr class="mt-0">
                                @if(count($member['banks']) >= 1)
                                    <p class="mb-0 d-flex justify-content-between medium-small lh-1-2">
                                        <span>{{ $member['banks'][0]['bank_code'] }}</span>
                                        <span>{{ strtoupper($member['banks'][0]['bank_name']) }}</span>
                                        <span>{{ $member['banks'][0]['pivot']['account_number'] }}</span>
                                    </p>
                                @else
                                    <p class="medium-small text-grey">No registered bank account yet.</p>
                                @endif
                            </section>
                            <section class="col-sm-4 col-md-4">
                                <section class="card medium">
                                    <section class="card-img-top text-center mt-3">
                                        <img src="{{ asset('img/member/member.jpg') }}" alt="{{ $member->name }}" class="rounded-circle">
                                    </section>
                                    <section class="card-block text-center">
                                        <h6 class="card-title"><strong>{{ $member->name }}</strong></h6>
                                    </section>
                                    <ul class="list-group list-group-flush medium-small lh-1-2">
                                        <li class="list-group-item justify-content-between">Account No. <span class="text-muted">{{ chunk_split($member['accounts'][0]['number'], 4, ' ') }}</span></li>
                                        <li class="list-group-item justify-content-between">MYNT ID <span class="text-muted">{{ $member['accounts'][0]['mynt_id'] }}</span></li>
                                        <li class="list-group-item justify-content-between">Balance Limit <span class="text-muted">{{ 'Rp ' . number_format($member['accounts'][0]['limit_balance']) }}</span></li>
                                        <li class="list-group-item justify-content-between">Transaction Limit <span class="text-muted">{{ 'Rp ' . number_format($member['accounts'][0]['limit_balance_transaction']) }}</span></li>
                                        <li class="list-group-item justify-content-between border-bottom-0">Register <span class="text-muted">{{ date('d-m-Y', strtotime($member->created_at)) }}</span></li>
                                    </ul>
                                    <section class="card-footer">
                                        <small class="text-muted">Last updated {{ $member->updated_at }}</small>
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
