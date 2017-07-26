@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'user'])
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @if(Auth::user()->role() == 3)
                @if(Auth::user()->members->first()->isRegistered())
                    @component('components.aside-member-register', ['active' => 'accessibility'])@endcomponent
                @else
                    @component('components.aside-member-unregister', ['active' => 'accessibility'])@endcomponent
                @endif
            @else
                @component('components.aside-member-child', ['active' => 'accessibility'])@endcomponent
            @endif
            <section class="col-md-9 py-3">
                <h5 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">
                    Accessibility
                    <span>
                        @if(count(Auth::user()->members->first()['profiles']) < 1 && (!Auth::user()->members->first()->isChildAccount()))
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif(Auth::user()->members->first()->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </h5>
                <section class="card my-3" style="min-height:550px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('member.accessibility.notification') }}">Notification</a></li>
                            <li class="nav-item ml-auto"><a class="nav-link active" href="{{ route('member.accessibility.log.access') }}">Log access</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="d-flex justify-content-end mb-3">
                            <section class="d-flex justify-content-between">
                                 <form action="#" method="POST" accept-charset="utf-8" role="form" style="min-width:240px">
                                     <label for="search-date" class="sr-only">Search by date</label>
                                    <section class="input-group input-group-sm" id="search-date">
                                        <input id="search_date" name="search_date" type="text" class="form-control" placeholder="Search by date">
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-secondary">&nbsp;Find&nbsp;</button>
                                    </span>
                                    </section>
                                </form>
                                <section class="btn-group btn-group-sm ml-3">
                                    <a href="{{ $logs->previousPageUrl() }}" class="btn btn-secondary{{ ($logs->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                                    <a href="{{ $logs->nextPageUrl() }}" class="btn btn-secondary{{ ($logs->hasMorePages()) ?: ' disabled' }}">Next</a>
                                </section>
                            </section>
                        </section>
                        <section class="table-sm table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>IP. ADDRESS</th>
                                    <th>DATE</th>
                                    <th>TIME</th>
                                </tr>
                                </thead>
                                <tbody class="medium-small lh-1-2">
                                @if(count($logs) >= 1)
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{ $log->ip_address }}</td>
                                            <td>{{ date('d-m-Y', strtotime($log->created_at)) }}</td>
                                            <td>{{ date('H:i:s', strtotime($log->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>Login history is empty</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection

@section('script')
    <script type="text/javascript">
        (function ($) {
            'use strict';
            $('#search-date input').each(function() {
                $(this).datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy',
                    clearDates:true
                });
            });
        })(jQuery);
    </script>
@endsection
