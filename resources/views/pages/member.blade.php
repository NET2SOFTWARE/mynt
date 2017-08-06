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
                        <p class="medium lh-1-5 mb-0">MEMBER</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('member.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('member.sort.index') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by name, email, no. phone" style="width:240px!important;">
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
                <section class="table-sm table-responsive medium p-3">
                    <table class="table medium-small lh-1-2">
                        <thead>
                        <tr class="medium">
                            <th>ACC. NO.</th>
                            <th>MYNT-ID</th>
                            <th>DATETIME</th>
                            <th>NAME</th>
                            <th>PHONE</th>
                            <th>EMAIL</th>
                            <th>REF.</th>
                            <th>TYPE</th>
                            <th>STATUS</th>
                            <th style="width:73px">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($members as $member)
                            <tr>
                                <td class="{{ $member->accounts()->count() }}">{{ $member->accounts()->first()['number'] }}</td>
                                <td>{{ $member->accounts()->first()['mynt_id'] }}</td>
                                <td>{{ $member->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ count($member->companies) < 1 ? '000' : $member->companies->first()['code'] }}</td>
                                <td>{{ ucfirst($member->type) }}</td>
                                <td>{{ ucfirst($member->status) }}</td>
                                <td style="width:73px">
                                    <a class="badge badge-default" href="{{ route('member.show', [$member->id]) }}" data-toggle="tooltip" data-placement="left" title="View" style="font-size:14px;">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a class="badge badge-default" href="{{ route('member.delete', [$member->id]) }}" onclick="event.preventDefault();document.getElementById('member-delete-{{ $member->id }}').submit();" data-toggle="tooltip" data-placement="left" title="Delete" style="font-size:14px">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                    <form id="member-delete-{{ $member->id }}" action="{{ route('member.delete', [$member->id]) }}" method="POST" class="sr-only">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
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