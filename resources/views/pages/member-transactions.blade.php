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
                        <p class="medium lh-1-5 mb-0">MEMBER TRANSACTIONS</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('member.transactions') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('member.transactions.sort') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by name, email, phone" style="width:240px!important;">
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $members->previousPageUrl() }}" class="btn btn-secondary {{ ($members->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $members->nextPageUrl() }}" class="btn btn-secondary {{ ($members->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                <th>ACCOUNT NO.</th>
                                <th>NAME</th>
                                <th>DEBIT SUMMARY</th>
                                <th>CREDIT SUMMARY</th>
                                <th>BALANCE</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                <tr>
                                    <td>{{$member->accounts()->first()['number']}}</td> 
                                    <td>{{$member->name}}</td> 
                                    <td>
                                        {{ sprintf('Rp %s', number_format($member->accounts()->first()->passbooks()->sum('debit'))) }}
                                    </td>
                                    <td>
                                        {{ sprintf('Rp %s', number_format($member->accounts()->first()->passbooks()->sum('credit'))) }}
                                    </td>
                                    <td>
                                        @if (is_null($member->accounts()->first()->passbooks()->first()))
                                            Rp 0
                                        @else
                                            {{ sprintf('Rp %s', number_format($member->accounts()->first()->passbooks()->orderBy('id', 'desc')->first()['balance'])) }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <section class="btn-group btn-group-sm">
                                            <a class="btn btn-secondary py-0 small-caps" href="{{ route('member.detail.transactions.index', [$member->id]) }}">details</a>
                                        </section>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                </transition>
            </section>
        </section>
    </article>
@endsection