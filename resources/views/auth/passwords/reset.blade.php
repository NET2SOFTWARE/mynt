@extends('layouts.app')

@section('content')
    <article class="col py-3 container-fluid d-flex justify-content-center">
        <section class="my-auto row" style="max-width:360px">
            <header class="col-md-12">
                <h5 class="f-l-300">Reset Password</h5>
                <h6><small>Please enter your new password</small></h6>
            </header>
            <section class="col-md-12 py-3">
                @if (session('status'))
                    <section class="alert alert-success">{{ session('status') }}</section>
                    <br/>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <fieldset class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="sr-only">E-mail address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="E-mail address" required autofocus>
                        @if ($errors->has('email'))
                            <section class="form-control-feedback">{{ $errors->first('email') }}</section>
                        @endif
                    </fieldset>
                    <fieldset class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                            <section class="form-control-feedback">{{ $errors->first('password') }}</section>
                        @endif
                    </fieldset>
                    <fieldset class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="sr-only">Confirm password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
                        @if ($errors->has('password_confirmation'))
                            <section class="form-control-feedback">{{ $errors->first('password_confirmation') }}</section>
                        @endif
                    </fieldset>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary" role="button">Reset password</button>
                    </section>
                </form>
            </section>
            <footer class="col-md-12 medium mt-4">
                <ul class="nav justify-content-center">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                </ul>
            </footer>
        </section>
    </article>
    @component('components.footer')
    @endcomponent
@endsection

