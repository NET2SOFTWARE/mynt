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
                        <p class="medium lh-1-5 mb-0">MEMBER CHILD ACCOUNT</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('member.child_account') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('member.child_account.sort') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
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
                                <th>PARENT ACCOUNT</th>
                                <th>ACCOUNT NUM.</th>
                                <th>CREATED DATE</th>
                                <th>NAME</th>
                                <th>PHONE</th>
                                <th>EMAIL</th>
                                <th class="text-center">REFERRAL</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>{{ $member->parent_account }}</td>
                                    <td>{{ $member->accounts->first()['number'] }}</td>
                                    <td>{{ $member->created_at }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->phone }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td class="text-center">{{ count($member->companies) < 1 ? '000' : $member->companies->first()['code'] }}</td>
                                    <td style="width:104px">
                                        <section class="btn-group btn-group-sm">
                                            <a class="btn btn-primary py-0" href="{{ route('member.edit', [$member->id]) }}">View</a>
                                            <a class="btn btn-primary py-0" href="{{ route('member.delete', [$member->id]) }}" onclick="event.preventDefault();document.getElementById('member-delete').submit();">Delete</a>
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