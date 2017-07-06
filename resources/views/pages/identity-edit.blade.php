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
                        <p class="medium lh-1-5 mb-0">IDENTITY</p>
                    </section>
                </section>
                <section class="col-sm-8 offset-sm-2 py-3">
                    <h5>Update identity</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    @if (session('success'))<section class="alert alert-success">{{ session('success') }}</section>@endif
                    @if (session('warning'))<section class="alert alert-danger">{{ session('warning') }}</section>@endif
                    <form method="post" action="{{ route('identity.update', [$identity->id]) }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <section class="card card-block p-5">
                            <h6 class="mb-0 medium-small text-warning">IDENTITY DATA</h6>
                            <section><hr/></section>
                            <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label for="name">Name</label>
                                <input id="name" name="name" class="form-control" value="{{ $identity->name }}" placeholder="Identity name" type="text" aria-describedby="nameHelp">
                                @if ($errors->has('name'))<section class="form-control-feedback">{{ $errors->first('name') }}</section>@endif
                                <small class="form-text text-muted d-flex justify-content-between" id="nameHelp">Full institution name. Max. 40 characters, eg. `Identity Card` <span class="text-grey">Required</span></small>
                            </fieldset>
                        </section>
                        <section class="form-group mt-4">
                            <a href="{{ route('identity.index') }}" class="btn btn-secondary">Back to identity</a>
                            <button type="submit" class="btn btn-primary float-right" role="button">Save identity</button>
                        </section>
                    </form>
                </section>
            </section>

        </section>
    </article>
@endsection