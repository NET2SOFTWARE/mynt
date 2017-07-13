@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => 'list_group'])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3" style="min-height:624px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.list.member') }}">All Member</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.list.merchant') }}">All Merchant</a></li>
                        </ul>
                    </section>
                    <section class="card-block d-flex flex-column justify-content-between">
                        <section class="col-auto d-flex justify-content-end w-100 mb-3">
                            <section class="d-flex justify-content-end">
                                <form action="{{ route('company.list.member.sort') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                                    {{ csrf_field() }}
                                    <section class="input-group input-group-sm">
                                        <span class="input-group-btn">
                                            <a href="{{ route('company.list.member') }}" class="btn btn-secondary">Refresh</a>
                                        </span>
                                        <input id="search" name="search" type="search" class="form-control" placeholder="Search by name, email, no. phone" style="width:240px!important;">
                                        <span class="input-group-btn">
                                            <button class="btn btn-secondary" type="submit">Find</button>
                                        </span>
                                    </section>
                                </form>
                                <section class="btn-group btn-group-sm ml-3">
                                    <a href="{{ $members->previousPageUrl() }}" class="btn btn-secondary {{ ($members->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                                    <a href="{{ $members->nextPageUrl() }}" class="btn btn-secondary {{ $members->hasMorePages() ?: 'disabled' }}">Next</a>
                                </section>
                            </section>
                        </section>
                        <section class="col px-0 table-sm table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>REG. DATETIME</th>
                                    <th>ACC. NUM</th>
                                    <th>NAME</th>
                                    <th>PHONE</th>
                                    <th>EMAIL</th>
                                    <th>ACC. TYPE</th>
                                </tr>
                                </thead>
                                <tbody class="medium-small lh-1-2">
                                @foreach($members as $member)
                                    <tr>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($member->created_at)) }}</td>
                                        <td>{{ $member->accounts->first()['number'] }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->phone }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ ((int) $member->accounts->first()['limit_balance'] > 1000000) ? 'Registered' : 'Un-Registered' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
