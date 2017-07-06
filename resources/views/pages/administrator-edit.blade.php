@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'admin'])
    @endcomponent
@endsection

@section('content')
    <article class="container-fluid">
        <section class="row">
            @component('components.aside')
            @endcomponent
            <section class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2 p-0">
                <section class="header-content justify-content-between align-items-baseline">
                    <section>
                        <p class="medium lh-1-5 mb-0">ADMINISTRATOR</p>
                    </section>
                </section>
                <section class="col-sm-6 offset-sm-3 p-5">
                    @if (session('success'))
                        <section class="alert alert-success">{{ session('success') }}</section>
                        <br/>
                    @endif
                    @if (session('warning'))
                        <section class="alert alert-danger">{{ session('warning') }}</section>
                        <br/>
                    @endif
                    <h5>Update administrator</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>

                    <form method="post" action="{{ route('administrator.update', [$administrator->id]) }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name">Name</label>
                            <input id="name" name="name" class="form-control" value="{{ $administrator->name  }}" />
                            @if ($errors->has('name'))
                                <section class="form-control-feedback">{{ $errors->first('name') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Alphanumeric, max. 40 characters, eg. `Administrator`. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" name="email" value="{{ $administrator->email }}" type="email" />
                            @if ($errors->has('email'))
                                <section class="form-control-feedback">{{ $errors->first('email') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Aplhanumeric, unique, eg. `administrator@gmail.com`. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="password" />
                            @if ($errors->has('password'))
                                <section class="form-control-feedback">{{ $errors->first('password') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Alphanumeric, min. 6 characters, eg. `secret`. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <label for="password_confirmation">Password Confirmation</label>
                            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" />
                            @if ($errors->has('password_confirmation'))
                                <section class="form-control-feedback">{{ $errors->first('password_confirmation') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Repeat password here to confirm. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <a href="{{ route('administrator.index', ['all']) }}" tabindex="-1" class="btn btn-secondary small-caps">cancel</a>
                        <button type="submit" class="btn btn-primary float-right small-caps" role="button">update</button>
                        <br>
                        <br>
                    </form>
                </section>
            </section>
        </section>
    </article>
@endsection