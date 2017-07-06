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
                    @component('components.aside-member-register', ['active' => ''])@endcomponent
                @else
                    @component('components.aside-member-unregister', ['active' => ''])@endcomponent
                @endif
            @elseif(Auth::user()->role() == 4)
                @component('components.aside-member-child', ['active' => ''])@endcomponent
            @endif
            @if(Auth::user()->role() == 5)
                @component('components.aside-merchant', ['active' => ''])@endcomponent
            @endif
            <section class="col-md-9 p-3">
                <h4 class="mb-4 medium-small d-flex flex-row justify-content-between align-items-baseline">
                    HOME
                    <span>
                        @if(Auth::user()->role() == 3 or Auth::user()->role() == 4)
                            @if(count(Auth::user()->members->first()['profiles']) < 1 && (!Auth::user()->members->first()->isChildAccount()))
                                <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                            @elseif(Auth::user()->members->first()->isPendingUpgrade())
                                <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                            @endif
                        @endif
                    </span>
                </h4>
                <section class="card">
                    <section class="card-header medium-small py-2">Home</section>
                    <section class="card-block medium">
                        <p>{{ Auth::user()->members->first()->isRegistered() ? 'true' : 'false' }}</p>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection