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
                        <p class="medium lh-1-5 mb-0">CHARGE</p>
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
                    <h5>Create new charge</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    <form method="post" action="{{ route('charge.store') }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        <fieldset class="form-group">
                            <label for="name">Name</label>
                            <input id="name" name="name" class="form-control" value="{{ old('name')  }}" type="text" />
                            @if ($errors->has('name'))
                                <section class="form-control-feedback">{{ $errors->first('name') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Alphanumeric, unique, max. 40 characters, eg. `Admin Charge`. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>
                        <a href="{{ route('charge.index') }}" tabindex="-1" class="btn btn-secondary small-caps">cancel</a>
                        <button type="submit" class="btn btn-primary float-right small-caps" role="button">save</button>
                        <br>
                        <br>
                    </form>
                </section>
            </section>
        </section>
    </article>
@endsection