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
                <section class="d-flex p-3 justify-content-between align-items-baseline">
                    <section>
                        <p class="medium lh-1-5 mb-0">PENDING UPGRADE MEMBER</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('member.pending_upgrade') }}" type="button" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('member.sort.pending_upgrade') }}" method="POST" class="ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by name, email and phone" style="width:240px!important;">
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                            </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $members->previousPageUrl() }}" type="button" class="btn btn-secondary{{ ($members->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $members->nextPageUrl() }}" type="button" class="btn btn-secondary{{ $members->hasMorePages() ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <section class="table-sm table-responsive p-3">
                    <table class="table medium-small lh-1-2">
                        <thead>
                        <tr class="medium">
                            <th>ACCOUNT NUM.</th>
                            <th>CREATED DATE</th>
                            <th>NAME</th>
                            <th>PHONE</th>
                            <th>EMAIL</th>
                            <th>REFERRAL</th>
                            <th style="width:40px">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($members as $member)
                            <tr>
                                <td>{{ $member->accounts->first()['number'] }}</td>
                                <td>{{ $member->created_at->format('Y-m-d') }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ count($member->companies) < 1 ? '000' : $member->companies->first()['code'] }}</td>
                                <td style="width:40px">
                                    <a class="badge badge-default" style="padding-top:3px!important;padding-bottom:3px!important;" href="{{ route('member.approve', [$member->id, $member->accounts->first()['number']]) }}" data-toggle="tooltip" data-placement="left" title="Approve">
                                        <i class="fa fa-address-card-o" style="font-size:14px;font-style:normal;line-height:inherit" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </article>
@endsection