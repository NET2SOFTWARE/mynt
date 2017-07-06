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
                <section class="card my-3" style="min-height:560px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('member.accessibility') }}">Personal setting</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('member.accessibility.notification') }}">Notification</a></li>
                            <li class="nav-item ml-auto"><a class="nav-link" href="{{ route('member.accessibility.log.access') }}">Log access</a></li>
                        </ul>
                    </section>
                    <section class="card-block">

                    </section>
                    <section class="card-footer">
                        <small class="text-muted">You can setting your access system by this feature.</small>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
