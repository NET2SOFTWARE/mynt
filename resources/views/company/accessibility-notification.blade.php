@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => 'accessibility'])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3" style="min-height:624px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.accessibility.notification') }}">Notification</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.accessibility.log') }}">Log Access</a></li>
                        </ul>
                    </section>
                    <section class="card-block d-flex flex-column justify-content-between">
                        <section class="col-auto d-flex justify-content-end w-100 mb-3">
                            <section class="d-flex justify-content-between">
                                <form action="#" method="POST" accept-charset="utf-8" role="form" style="min-width:240px">
                                    <label for="search-date" class="sr-only">Search by date</label>
                                    <section class="input-group input-group-sm" id="search-date">
                                        <span class="input-group-btn">
                                            <a href="{{ route('company.accessibility.notification') }}" class="btn btn-secondary">Refresh</a>
                                        </span>
                                        <input id="search_date" name="search_date" type="text" class="form-control" placeholder="Search by date">
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-secondary">&nbsp;Find&nbsp;</button>
                                    </span>
                                    </section>
                                </form>
                                <section class="btn-group btn-group-sm ml-3">
                                    <a href="{{ $notifications->previousPageUrl() }}" class="btn btn-secondary {{ ($notifications->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                                    <a href="{{ $notifications->nextPageUrl() }}" class="btn btn-secondary {{ ($notifications->hasMorePages()) ?: ' disabled' }}">Next</a>
                                </section>
                            </section>
                        </section>
                        <section class="col px-0 table-sm table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>TITLE</th>
                                    <th>MESSAGE</th>
                                    <th>DATE</th>
                                    <th>TIME</th>
                                </tr>
                                </thead>
                                <tbody class="medium-small lh-1-2">
                                @foreach($notifications as $notification)
                                    <tr>
                                        <td>{{ $notification->title }}</td>
                                        <td>{{ $notification->message }}</td>
                                        <td>{{ date('d-m-Y', strtotime($notification->created_at)) }}</td>
                                        <td>{{ date('H:i:s', strtotime($notification->created_at)) }}</td>
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
