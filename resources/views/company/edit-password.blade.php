@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => 'management'])@endcomponent
            <section class="col-md-9">
                <section class="card my-3" style="min-height:624px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.management.account') }}">Personal Account</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="row">
                            <section class="col-sm-8 col-md-8" style="padding-left:4rem;padding-right:4rem">
                                <h6 class="d-flex justify-content-between lh-1-5 align-items-baseline my-3">
                                    <small class="text-uppercase text-warning mb-1">CHANGE PASSWORD</small>
                                    <span><a href="{{ route('company.management.account') }}" class="btn btn-sm btn-outline-success py-0">Back</a></span>
                                </h6>
                                @if (session('warning'))
                                    <section class="alert mb-3 small alert-success lh-1-2">{{ session('warning') }}</section>
                                @elseif(session('success'))
                                    <section class="alert mb-3 small alert-success lh-1-2">{{ session('success') }}</section>
                                @endif
                                <form action="{{ route('company.management.store.identity') }}" method="post" accept-charset="utf-8" role="form">
                                    {{ csrf_field() }}
                                    @include('forms.edit-password')
                                </form>
                            </section>
                            <section class="col-sm-4 col-md-4">
                                <section class="card medium">
                                    <section class="card-img-top text-center mt-3">
                                        <img src="{{ asset('img/member/member.jpg') }}" alt="{{ Auth::user()->name }}" class="rounded-circle">
                                    </section>
                                    <section class="card-block text-center">
                                        <section class="text-center mb-3">
                                            <a href="{{ route('company.management.edit.photo') }}" class="btn btn-sm py-0 btn-outline-success">Upload Photo</a>
                                        </section>
                                    </section>
                                    <ul class="list-group list-group-flush medium-small lh-1-2">
                                        <li class="list-group-item justify-content-between">No. Acc <span class="text-muted">{{ Auth::user()->companies->first()['accounts'][0]['number'] }}</span></li>
                                        <li class="list-group-item justify-content-between">MYNT ID <span class="text-muted">{{ Auth::user()->companies->first()['accounts'][0]['mynt_id'] }}</span></li>
                                        <li class="list-group-item justify-content-between border-bottom-0">Register date<span class="text-muted">{{ date('d-m-Y', strtotime(Auth::user()->created_at)) }}</span></li>
                                    </ul>
                                    <section class="card-footer">
                                        <small class="text-muted">Last updated {{ Auth::user()->updated_at }}</small>
                                    </section>
                                </section>
                            </section>
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