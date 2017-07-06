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
                        <p class="medium lh-1-5 mb-0">ALL COMPANY</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('company.create') }}" class="btn btn-secondary">New</a>
                            </section>
                        </section>
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('company.index', ['all']) }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('company.sort.index') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input name="extra" type="hidden" value="all" />
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by co-brand code, name, account no." style="width:240px!important;" />
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $companies->previousPageUrl() }}" class="btn btn-secondary {{ ($companies->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $companies->nextPageUrl() }}" class="btn btn-secondary {{ ($companies->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3" style="overflow: visible;">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                <th class="text-center">STATUS</th>
                                <th class="text-center">CO-BRAND CODE</th>
                                <th>COMPANY NAME</th>
                                <th class="text-center">ACCOUNT NO.</th>
                                <th>INSTITUTION</th>
                                <th>PARTNERSHIPS</th>
                                <th>CREATED DATE</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $company)
                                <tr>
                                    <td class="text-center">
                                        @if (sizeof($company->users()->get()) < 1)
                                            <span class="badge small-caps badge-danger">inactive</span>
                                        @else
                                            <span class="badge small-caps badge-success">active</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $company->code }}
                                    </td>
                                    <td>
                                        {{ $company->name }}
                                    </td>
                                    <td class="text-center">
                                        {{ count($company->accounts) > 0 ? $company->accounts->first()['number'] : '-' }}
                                    </td>
                                    <td>
                                        <span class="badge small-caps badge-default">{{ strtolower($company->industry->name) }}</span>
                                    </td>
                                    <td>
                                        @foreach($company->partnerships as $partnership)
                                            <span class="badge small-caps badge-info">{{ strtolower($partnership->name) }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $company->created_at->format('j F Y') }}
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle small-caps" type="button" data-toggle="dropdown" style="margin-top: -.12em; line-height: 1.6em">
                                                actions
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a href="{{ route('company.members', [$company->id]) }}"
                                                    class="dropdown-item small-caps">
                                                    view members
                                                </a>
                                                <a href="{{ route('company.edit', [$company->id]) }}"
                                                    class="dropdown-item small-caps">
                                                    edit
                                                </a>
                                                <a href="{{ route('company.delete', [$company->id]) }}"
                                                    onclick="event.preventDefault();document.getElementById('company-delete-{{$company->id}}').submit();"
                                                    class="dropdown-item small-caps">
                                                    delete
                                                </a>
                                                <form id="company-delete-{{$company->id}}" action="{{ route('company.delete', [$company->id]) }}" method="POST" class="sr-only">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                </form>
                                            </div>
                                        </div>
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