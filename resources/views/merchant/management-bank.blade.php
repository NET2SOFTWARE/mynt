@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => 'management'])@endcomponent
            <section class="col-md-9 py-3">
                <h6 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">Management</h6>
                <section class="card mt-3" style="min-height:565px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.management.account') }}">Merchant Account</a></li>
                            <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="d-flex justify-content-end mb-3">
                            <section class="d-flex justify-content-between">
                                <section class="btn-group btn-group-sm mr-3">
                                    <a href="{{ route('merchant.management.bank.create') }}" class="btn btn-outline-success">New bank account</a>
                                </section>
                                <section class="btn-group btn-group-sm mr-3">
                                    <a href="{{ route('merchant.management.bank') }}" class="btn btn-sm btn-secondary">&nbsp;Refresh&nbsp;</a>
                                </section>
                                <form action="#" method="POST" accept-charset="utf-8" role="form" style="min-width:240px">
                                    <label for="search-date" class="sr-only">Search by date</label>
                                    <section class="input-group input-group-sm" id="search-date">
                                        <input id="search_date" name="search_date" type="text" class="form-control" placeholder="Search by date">
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-secondary">&nbsp;Find&nbsp;</button>
                                        </span>
                                    </section>
                                </form>
                                {{--<section class="btn-group btn-group-sm ml-3">--}}
                                    {{--<a href="{{ $logs->previousPageUrl() }}" class="btn btn-secondary{{ ($logs->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>--}}
                                    {{--<a href="{{ $logs->nextPageUrl() }}" class="btn btn-secondary{{ ($logs->hasMorePages()) ?: ' disabled' }}">Next</a>--}}
                                {{--</section>--}}
                            </section>
                        </section>
                        <section class="table-sm table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>BANK ACC. NAME</th>
                                    <th>BANK CODE</th>
                                    <th>BANK ACC. NUMBER</th>
                                </tr>
                                </thead>
                                <tbody class="medium-small lh-1-2">

                                </tbody>
                            </table>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
