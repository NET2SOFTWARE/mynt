@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'user'])
    @endcomponent
@endsection

@section('content')
    <article class="col d-flex justify-content-center">
        <section class="align-self-center con-sign-in">
            <header class="col-md-12">
                <h6 class="mb-1"><strong>MYNT-ID</strong></h6>
                <h6 class="medium mb-0">Please create your unique ID</h6>
            </header>
            <section class="col-md-12 py-3">
                <form class="form-signin" method="POST" action="{{ route('mynt_id.store') }}" role="form" accept-charset="utf-8">
                    {{ csrf_field() }}
                    <label for="email" class="sr-only">E-mail</label>
                    <input id="email" name="email" value="{{ $email }}" type="hidden" class="sr-only">
                    <fieldset class="form-group{{ $errors->has('mynt_id') ? ' has-danger' : '' }}">
                        <label for="mynt_id" class="sr-only">MYNT-ID</label>
                        <input id="mynt_id" type="text" class="form-control" name="mynt_id" value="{{ old('mynt_id') }}" placeholder="MYNT-ID" required autofocus>
                        @if ($errors->has('mynt_id'))
                            <section class="form-control-feedback">{{ $errors->first('mynt_id') }}</section>
                        @endif
                        <p class="form-text text-muted">Must be 6-16 characters long</p>
                    </fieldset>
                    <section class="form-group">
                        <button type="submit" class="btn btn-block btn-primary" role="button">Create MYNT-ID</button>
                    </section>
                </form>
            </section>
        </section>
    </article>
    @component('components.footer')
    @endcomponent
@endsection
