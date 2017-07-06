@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'user'])
    @endcomponent
@endsection

@section('content')
    <article class="col d-flex justify-content-center">
        <section class="align-self-center con-sign-in">
            <section class="p-3">
                <section class="text-center">
                    <h4 class="mt-4 mb-3">Email Confirmation</h4>
                    <p class="small text-muted">We have sent email to <span class="text-primary">{{ $email }}</span> to confirm the validity of our email address. After receiving the email follow the link provided to complete your registration.</p>
                </section>
            </section>
            <section class="text-center">
                <hr class="clearfix"/>
                @if (session('success'))
                    <section class="alert medium-small lh-1-2 alert-success">{{ session('success') }}</section>
                    <br/>
                @endif
                <span class="d-block mb-3 medium">If you not got any email</span>
                <form action="{{ route('account.confirmation.resend') }}" method="post" accept-charset="utf-8" role="form">
                    {{ csrf_field() }}

                    <fieldset>
                        <label for="email" class="sr-only">email</label>
                        <input id="email" type="email" class="sr-only" name="email" value="{{ $email }}">
                    </fieldset>
                    <button type="submit" class="btn btn-primary" role="button">Resend confirmation mail</button>
                </form>
            </section>
        </section>
    </article>
    @component('components.footer')
    @endcomponent
@endsection