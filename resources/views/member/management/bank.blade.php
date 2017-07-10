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
                    @component('components.aside-member-register', ['active' => 'management'])@endcomponent
                @else
                    @component('components.aside-member-unregister', ['active' => 'management'])@endcomponent
                @endif
            @else
                @component('components.aside-member-child', ['active' => 'management'])@endcomponent
            @endif
            <section class="col-md-9 py-3">
                <h5 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">
                    Management
                    <span>
                        @if(count(Auth::user()->members->first()['profiles']) < 1 && (!Auth::user()->members->first()->isChildAccount()))
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif(Auth::user()->members->first()->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </h5>
                <section class="card" style="min-height:556px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('member.management') }}">Personal Account</a></li>
                            @if(!Auth::user()->members->first()->isChildAccount())
                                <li class="nav-item"><a class="nav-link active" href="{{ route('member.management.bank') }}">Bank Account</a></li>
                            @endif
                            @if(Auth::user()->members->first()->isRegistered())
                                <li class="nav-item"><a class="nav-link" href="{{ route('member.management.child') }}">Child Account</a></li>
                            @endif
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="row">
                            <section class="col-md-12 px-5">
                                @if (session('warning'))
                                    <section class="alert alert-success">{{ session('warning') }}</section>
                                    <br/>
                                @elseif(session('success'))
                                    <section class="alert alert-success">{{ session('success') }}</section>
                                    <br/>
                                @endif
                                <form class="card card-block p-4" action="{{ route('member.management.bank.store') }}" method="POST" accept-charset="utf-8" role="form">
                                    {{ csrf_field() }}
                                    @include('forms.bank-register')
                                    <section class="form-group mt-4 mb-0">
                                        <button type="submit" class="btn btn-sm btn-block btn-primary">{{ (count(Auth::user()->members->first()['banks']) >= 1) ? 'Update bank account' : 'Register my bank account' }}</button>
                                    </section>
                                </form>
                            </section>
                        </section>
                    </section>
                    <section class="card-footer">
                        <small class="text-muted">Note : If you have a trouble, please contact our cumtumer service.</small>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
