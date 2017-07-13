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
                <section class="card mt-3" style="min-height:560px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('member.management') }}">Personal Account</a></li>
                            @if(!Auth::user()->members->first()->isChildAccount())
                                <li class="nav-item"><a class="nav-link" href="{{ route('member.management.bank') }}">Bank Account</a></li>
                            @endif
                            @if(Auth::user()->members->first()->isRegistered())
                                <li class="nav-item"><a class="nav-link" href="{{ route('member.management.child') }}">Child Account</a></li>
                            @endif
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="row">
                            <section class="col-sm-8 col-md-8 px-md-5">
                                <h6 class="medium d-flex justify-content-between">
                                    <small class="text-uppercase text-warning mb-1">IDENTITY</small>
                                    <span><a href="{{ route('company.management.edit.identity') }}" class="btn btn-sm btn-outline-success py-0" data-toggle="tooltip" data-placement="top" title="Update personal data">Update</a></span>
                                </h6>
                                <hr class="mt-0 mb-1">
                                <ul class="list-group list-group-flush medium-small lh-1-2 mb-5">
                                    <li class="list-group-item justify-content-between border-top-0">
                                        Full name
                                        <span>{{ Auth::user()->name }}</span>
                                    </li>
                                    <li class="list-group-item justify-content-between">
                                        Phone
                                        <span>{{ Auth::user()->phone }}</span>
                                    </li>
                                </ul>
                                <h6 class="medium d-flex justify-content-between align-items-baseline">
                                    <small class="text-uppercase text-warning mb-1">CREDENTIAL</small>
                                    <span><a href="{{ route('company.management.edit.password') }}" class="btn btn-sm btn-outline-success py-0" data-toggle="tooltip" data-placement="top" title="Update credential data">Change password</a></span>
                                </h6>
                                <hr class="mt-0 mb-1">
                                <ul class="list-group list-group-flush medium-small lh-1-2 mb-5">
                                    <li class="list-group-item justify-content-between border-top-0">
                                        E-mail address
                                        <span>{{ Auth::user()->email }}</span>
                                    </li>
                                    <li class="list-group-item justify-content-between">
                                        Password
                                        <span>
                                            <strong>&#42;&#42;&#42;&#42;&#42;</strong>
                                        </span>
                                    </li>
                                </ul>
                                <h6 class="medium d-flex justify-content-between align-items-baseline lh-1-5">
                                    <small class="text-uppercase text-warning mb-1">BANK</small>
                                    <span>
                                        <a href="{{ route('member.management') }}" class="btn btn-sm btn-outline-success py-0" data-toggle="tooltip" data-placement="top" title="Register new bank account">Add new bank</a>
                                    </span>
                                </h6>
                                <hr class="mt-0">
                                @if(count(Auth::user()->members->first()['banks']) >= 1)
                                    <p class="mb-0 d-flex justify-content-between medium-small lh-1-2">
                                        <span>{{ Auth::user()->members->first()['banks'][0]['bank_code'] }}</span>
                                        <span>{{ strtoupper(Auth::user()->members->first()['banks'][0]['bank_name']) }}</span>
                                        <span>{{ Auth::user()->members->first()['banks'][0]['pivot']['account_number'] }}</span>
                                    </p>
                                @else
                                    <p class="medium-small text-grey">No registered bank account yet.</p>
                                @endif
                            </section>
                            <section class="col-sm-4 col-md-4">
                                <section class="card medium">
                                    <section class="card-img-top text-center mt-3">
                                        <img src="{{ asset('img/member/member.jpg') }}" alt="{{ Auth::user()->name }}" class="rounded-circle">
                                    </section>
                                    <section class="card-block text-center">
                                        <section class="text-center mb-3">
                                            <a href="#" class="btn btn-sm py-0 btn-outline-success" data-toggle="modal" data-target="#myntModal">Upload Photo</a>
                                        </section>
                                        <h6 class="card-title"><strong>{{ Auth::user()->name }}</strong></h6>
                                    </section>
                                    <ul class="list-group list-group-flush medium-small lh-1-2">
                                        <li class="list-group-item justify-content-between">No. Acc <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['number'] }}</span></li>
                                        <li class="list-group-item justify-content-between">MYNT ID <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['mynt_id'] }}</span></li>
                                        <li class="list-group-item justify-content-between">Balance Limit <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['limit_balance'] }}</span></li>
                                        <li class="list-group-item justify-content-between">Transaction Limit <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['limit_balance_transaction'] }}</span></li>
                                        <li class="list-group-item justify-content-between border-bottom-0">Register <span class="text-muted">{{ date('d-m-Y', strtotime(Auth::user()->created_at)) }}</span></li>
                                    </ul>
                                    <section class="card-footer">
                                        <small class="text-muted">Last updated {{ Auth::user()->updated_at }}</small>
                                    </section>
                                </section>
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

@section('script')
    <script type="text/javascript">
        (function ($) {
            $('#reload_captcha').on('click', function () {
                $.ajax({
                    method: 'GET',
                    url: '/get_captcha',
                }).done(function (response) {
                    $('#img_captcha').prop('src', response);
                });
            });
        })(jQuery);
    </script>
@endsection