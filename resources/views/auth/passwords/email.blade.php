@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'user'])
    @endcomponent
@endsection

@section('content')
    <article class="col py-3 container-fluid d-flex justify-content-center">
        <section class="my-auto row" style="max-width:360px">
            <header class="col-md-12">
                <h5 class="f-l-300">Reset Password</h5>
                <h6><small>Please enter your valid email address</small></h6>
            </header>
            <section class="col-md-12 py-3">
                @if (session('status'))
                    <section class="alert alert-success medium mb-3">{{ session('status') }}</section>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <fieldset class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="sr-only">E-mail</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail address" required>
                        @if ($errors->has('email'))
                            <section class="form-control-feedback">{{ $errors->first('email') }}</section>
                        @endif
                    </fieldset>
                    <section class="form-group">
                        <button type="submit" class="btn btn-block btn-primary" role="button">Send password reset link</button>
                    </section>
                </form>
            </section>
        </section>
    </article>
    @component('components.footer')
    @endcomponent
@endsection
