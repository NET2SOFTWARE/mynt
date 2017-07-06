@extends('layouts.app')

@section('content')
    <article class="col d-flex justify-content-center">
        <section class="align-self-center con-sign-in">
            <header class="col-md-12">
                <h4 class="mb-1">Company&nbsp;&nbsp;<span class="text-grey">&#124;</span>&nbsp;&nbsp;<small>Sign In</small></h4>
                <h6 class="medium mb-0">Please use your valid mynt account.</h6>
            </header>
            <section class="col-md-12 py-3">
                <form class="form-signin" method="POST" action="{{ route('post.login.company') }}" role="form" accept-charset="utf-8">
                    {{ csrf_field() }}
                    <fieldset class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="sr-only">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail address" required autofocus>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                        @if ($errors->has('email'))
                            <section class="form-control-feedback">{{ $errors->first('email') }}</section>
                        @endif
                    </fieldset>
                    <fieldset class="form-group medium clearfix">
                        <label class="custom-control custom-checkbox lh-1-5 mb-0">
                            <input type="checkbox" class="custom-control-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description"> Remember me</span>
                        </label>
                        <a class="lh-1-5 float-right" href="{{ route('password.request') }}">Forgot password ?</a>
                    </fieldset>
                    <section class="form-group">
                        <button type="submit" class="btn btn-block btn-primary" role="button">Sign In</button>
                    </section>
                </form>
            </section>
            <footer class="col-md-12 medium">
                <p class="d-flex justify-content-between mb-0">
                    <span>Don't have an account ?</span>
                    <a href="{{ url('/register') }}">Create an account</a>
                </p>
            </footer>
        </section>
    </article>
    @component('components.footer')
    @endcomponent
@endsection