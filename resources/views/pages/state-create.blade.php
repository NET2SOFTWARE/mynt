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
                        <p class="medium lh-1-5 mb-0">STATE</p>
                    </section>
                </section>
                <section class="row">
                    <section class="col-sm-8 offset-sm-2 py-3">
                        <section class="mt-3 mb-5">
                            <section class="mb-4">
                                <h4><small>Create new state</small></h4>
                                <p class="small text-grey">Please insert with valid data.</p>
                                @if (session('success'))<section class="alert alert-success">{{ session('success') }}</section>@endif
                                @if (session('warning'))<section class="alert alert-danger">{{ session('warning') }}</section>@endif
                            </section>
                            <form class="mb-3" method="post" action="{{ route('state.store') }}" accept-charset="utf-8" role="form">
                                {{ csrf_field() }}
                                <section class="card card-block p-5">
                                    <h6 class="mb-0 medium-small text-warning">STATE DATA</h6>
                                    <section><hr/></section>
                                    <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label for="name">Name</label>
                                        <input id="name" name="name" class="form-control" value="{{ old('name')  }}" placeholder="State name" type="text" aria-describedby="nameHelp">
                                        @if ($errors->has('name'))<section class="form-control-feedback">{{ $errors->first('name') }}</section>@endif
                                        <small class="form-text text-muted d-flex justify-content-between" id="nameHelp">Full state name. Max. 40 characters, eg. `Jakarta` <span class="text-grey">Required</span></small>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="country_id">Country</label>
                                        <select id="country_id" name="country_id" class="custom-select w-100" value="{{ old('country_id') }}" aria-describedby="countryHelp">
                                            <option selected disabled>Choose one country</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ (old('country_id') == $country->id) ? ' selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country_id'))<section class="form-control-feedback">{{ $errors->first('country_id') }}</section>@endif
                                        <small class="form-text text-muted d-flex justify-content-between" id="countryHelp">Country where this state belongs. <span class="text-grey">Required</span></small>
                                    </fieldset>
                                </section>
                                <section class="form-group mt-4">
                                    <a href="{{ route('state.index') }}" class="btn btn-secondary">Back to state</a>
                                    <button type="submit" class="btn btn-primary float-right" role="button">Save state</button>
                                </section>
                            </form>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </article>
@endsection