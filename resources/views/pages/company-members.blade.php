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
                        <p class="medium lh-1-5 mb-0">COMPANY MEMBERS</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('company.members', [$company->id]) }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('company.sort.members', [$company->id]) }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input name="extra" type="hidden" value="members" />
                                <input name="page" type="hidden" value="pages.company-members" />
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by account no., name, email or phone" style="width:240px!important;" />
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $accounts->previousPageUrl() }}" class="btn btn-secondary {{ ($accounts->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $accounts->nextPageUrl() }}" class="btn btn-secondary {{ ($accounts->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <section class="header-content justify-content-between align-items-baseline">
                    <section class="btn-group btn-group-sm">
                        <a href="{{ route('company.index', ['all']) }}" class="btn btn-secondary"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                    </section>
                    <section>
                        <p class="medium lh-1-5 mb-0"><span class="badge badge-info">{{ $company->name }}</span></p>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                <th>ACCOUNT NO.</th>
                                <th>TYPE</th>
                                <th>NAME</th>
                                <th>PHONE</th>
                                <th>EMAIL</th>
                                <th>CREATED DATE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accounts as $account)
                                <tr>
                                    <td>{{ $account->number }}</td>
                                    <td><span class="badge badge-info small-caps">{{ $account->account_type()->first()['name'] }}</span></td>
                                    <td>
                                        @if (! is_null($account->members()->first()))
                                            {{ $account->members()->first()['name'] }}
                                        @else
                                            {{ $account->merchants()->first()['name'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (! is_null($account->members()->first()))
                                            {{ $account->members()->first()['phone'] }}
                                        @else
                                            {{ $account->merchants()->first()['phone'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (! is_null($account->members()->first()))
                                            {{ $account->members()->first()['email'] }}
                                        @else
                                            {{ $account->merchants()->first()['email'] }}
                                        @endif
                                    </td>
                                    <td>{{ $account->created_at }}</td>
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