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
            <!-- <member-page></member-page> -->
            <section class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2 p-0">
                <section class="header-content justify-content-between align-items-baseline">
                    <section>
                        <p class="medium lh-1-5 mb-0">MEMBER</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('member.create') }}" class="btn btn-secondary">New</a>
                            </section>
                            <section class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-secondary">Print</button>
                                <button type="button" class="btn btn-secondary">Refresh</button>
                            </section>
                        </section>
                        <form action="" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search value" style="max-width:160px!important;width:160px!important;">
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
                        <table class="table medium-small">
                            <thead>
                            <tr class="medium-small">
                                <th>ID</th>
                                <th>DATE</th>
                                <th>NAME</th>
                                <th>ACCOUNT NUMBER</th>
                                <th>EMAIL</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>{{ $member->id }}</td>
                                    <td>{{ $member->created_at }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->accounts->first()['number'] }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td style="width:140px">
                                        <section class="btn-group btn-group-sm">
                                            <a class="btn btn-secondary" href="{{ route('api.member.approve', [$member->id, $member->accounts->first()->number]) }}" style="padding:0 4px 0!important;">Approve</a>
                                            <a class="btn btn-secondary" href="{{ route('member.edit', [$member->id]) }}" style="padding:0 4px 0!important;">View</a>
                                            <a class="btn btn-secondary" href="{{ route('member.delete', [$member->id]) }}" onclick="event.preventDefault();document.getElementById('member-delete').submit();" style="padding:0 4px 0!important;">Delete</a>
                                            <form id="member-delete" action="{{ route('member.delete', [$member->id]) }}" method="POST" class="sr-only">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
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