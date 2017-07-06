@extends('layouts.app')

@section('content')
    <article class="col d-flex justify-content-center">
        <section class="align-self-center" style="width:60%">
            <header class="col-md-12">
                <h4 class="mb-1">Choose sign in page</h4>
                <h6 class="medium mb-4">Please choose the login page option below according to your account.</h6>
            </header>
            <section class="col-sm-12 col-md-12">
                <section class="card-group card-group-hover">
                    <section class="card">
                        <section class="card-img-top px-5 pt-4 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000">
                                <path fill="#cecfd1" d="M108.1 949.3c-.6 27.1-23 48.5-50.1 48-27.1-.6-48.5-23-48-50.1C15.4 692 269.2 528.6 500 528.6c236.2 0 484.6 163.4 490 418.6.5 27.1-21 49.5-48 50.1-27.1.5-49.5-21-50.1-48-4.2-199.2-206.7-322.6-391.9-322.6-186 0-387.9 129.7-391.9 322.6"/>
                                <path fill="#cecfd1" d="M500 493c108.2 0 196.2-88 196.2-196.2 0-108.1-88-196.2-196.2-196.2-108.1 0-196.1 88-196.1 196.2C303.9 405 391.8 493 500 493m0 98.1c-162.5 0-294.2-131.7-294.2-294.2S337.5 2.7 500 2.7s294.3 131.7 294.3 294.2c-.1 162.5-131.8 294.2-294.3 294.2z"/></svg>
                        </section>
                        <section class="card-block text-center">
                            <a href="{{ route('login') }}" class="btn btn-block btn-sm btn-primary">Sign in</a>
                        </section>
                        <section class="card-footer py-2 text-center">
                            <small class="text-muted">Member of MYNT</small>
                        </section>
                    </section>
                    <section class="card">
                        <section class="card-img-top px-5 pt-4 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000">
                                <path fill="#cecfd1" d="M108.1 949.3c-.6 27.1-23 48.5-50.1 48-27.1-.6-48.5-23-48-50.1C15.4 692 269.2 528.6 500 528.6c236.2 0 484.6 163.4 490 418.6.5 27.1-21 49.5-48 50.1-27.1.5-49.5-21-50.1-48-4.2-199.2-206.7-322.6-391.9-322.6-186 0-387.9 129.7-391.9 322.6"/>
                                <path fill="#cecfd1" d="M500 493c108.2 0 196.2-88 196.2-196.2 0-108.1-88-196.2-196.2-196.2-108.1 0-196.1 88-196.1 196.2C303.9 405 391.8 493 500 493m0 98.1c-162.5 0-294.2-131.7-294.2-294.2S337.5 2.7 500 2.7s294.3 131.7 294.3 294.2c-.1 162.5-131.8 294.2-294.3 294.2z"/></svg>
                        </section>
                        <section class="card-block text-center">
                            <a href="{{ route('login.member.company') }}" class="btn btn-block btn-sm btn-primary">Sign in</a>
                        </section>
                        <section class="card-footer py-2 text-center">
                            <small class="text-muted">Member of Company</small>
                        </section>
                    </section>
                    <section class="card">
                        <section class="card-img-top px-5 pt-4 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000">
                                <path fill="#cecfd1" d="M108.1 949.3c-.6 27.1-23 48.5-50.1 48-27.1-.6-48.5-23-48-50.1C15.4 692 269.2 528.6 500 528.6c236.2 0 484.6 163.4 490 418.6.5 27.1-21 49.5-48 50.1-27.1.5-49.5-21-50.1-48-4.2-199.2-206.7-322.6-391.9-322.6-186 0-387.9 129.7-391.9 322.6"/>
                                <path fill="#cecfd1" d="M500 493c108.2 0 196.2-88 196.2-196.2 0-108.1-88-196.2-196.2-196.2-108.1 0-196.1 88-196.1 196.2C303.9 405 391.8 493 500 493m0 98.1c-162.5 0-294.2-131.7-294.2-294.2S337.5 2.7 500 2.7s294.3 131.7 294.3 294.2c-.1 162.5-131.8 294.2-294.3 294.2z"/></svg>
                        </section>
                        <section class="card-block text-center">
                            <a href="{{ route('login.merchant') }}" class="btn btn-block btn-sm btn-primary">Sign in</a>
                        </section>
                        <section class="card-footer py-2 text-center">
                            <small class="text-muted">Merchant</small>
                        </section>
                    </section>
                    <section class="card">
                        <section class="card-img-top px-5 pt-4 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000">
                                <path fill="#cecfd1" d="M108.1 949.3c-.6 27.1-23 48.5-50.1 48-27.1-.6-48.5-23-48-50.1C15.4 692 269.2 528.6 500 528.6c236.2 0 484.6 163.4 490 418.6.5 27.1-21 49.5-48 50.1-27.1.5-49.5-21-50.1-48-4.2-199.2-206.7-322.6-391.9-322.6-186 0-387.9 129.7-391.9 322.6"/>
                                <path fill="#cecfd1" d="M500 493c108.2 0 196.2-88 196.2-196.2 0-108.1-88-196.2-196.2-196.2-108.1 0-196.1 88-196.1 196.2C303.9 405 391.8 493 500 493m0 98.1c-162.5 0-294.2-131.7-294.2-294.2S337.5 2.7 500 2.7s294.3 131.7 294.3 294.2c-.1 162.5-131.8 294.2-294.3 294.2z"/></svg>
                        </section>
                        <section class="card-block text-center">
                            <a href="{{ route('login.company') }}" class="btn btn-block btn-sm btn-primary">Sign in</a>
                        </section>
                        <section class="card-footer py-2 text-center">
                            <small class="text-muted">Company</small>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
    @component('components.footer')
    @endcomponent
@endsection