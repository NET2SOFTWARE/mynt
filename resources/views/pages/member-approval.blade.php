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
                        <p class="medium lh-1-5 mb-0">MANUAL REGISTRATION APPROVAL</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('member.approval') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('member.sort.confirm') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by name, email, phone" style="width:240px!important;">
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
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table medium-small lh-1-2">
                            <thead>
                            <tr class="medium">
                                <th>ACC. NUMBER</th>
                                <th>DATETIME</th>
                                <th>NAME</th>
                                <th>REF.</th>
                                <th>PHONE</th>
                                <th>EMAIL</th>
                                <th style="width:36px">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>{{ $member->accounts->first()['number'] }}</td>
                                    <td>{{ $member->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ count($member->companies) < 1 ? '000' : $member->companies->first()['code'] }}</td>
                                    <td>{{ $member->phone }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td style="width:36px">
                                        <a class="badge badge-default" href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('confirm-user').submit();" data-toggle="tooltip" data-placement="left" title="Confirm User">
                                            <i class="fa fa-bell-o" aria-hidden="true"></i>
                                        </a>
                                        <form id="confirm-user" action="{{ route('member.confirm', [$member->users->first()['id']]) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('patch') }}
                                        </form>
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