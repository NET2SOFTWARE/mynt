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
                        <p class="medium lh-1-5 mb-0">CITY</p>
                    </section>
                </section>
                <section class="row">
                    <section class="col-sm-8 offset-sm-2 py-3">
                        <section class="mt-3 mb-5">
                            <section class="mb-4">
                                <h4><small>Create new city</small></h4>
                                <p class="small text-grey">Please insert with valid data.</p>
                                @if (session('success'))<section class="alert alert-success">{{ session('success') }}</section>@endif
                                @if (session('warning'))<section class="alert alert-danger">{{ session('warning') }}</section>@endif
                            </section>
                            <form class="mb-3" method="post" action="{{ route('city.store') }}" accept-charset="utf-8" role="form">
                                {{ csrf_field() }}
                                <section class="card card-block p-5">
                                    <h6 class="mb-0 medium-small text-warning">CITY DATA</h6>
                                    <section><hr/></section>
                                    <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label for="name">Name</label>
                                        <input id="name" name="name" class="form-control" value="{{ old('name')  }}" placeholder="City name" type="text" aria-describedby="nameHelp">
                                        @if ($errors->has('name'))<section class="form-control-feedback">{{ $errors->first('name') }}</section>@endif
                                        <small class="form-text text-muted d-flex justify-content-between" id="nameHelp">Full city name. Max. 40 characters, eg. `Jakarta` <span class="text-grey">Required</span></small>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="state_id">State</label>
                                        <select id="state_id" name="state_id" class="custom-select w-100" value="{{ old('state_id') }}" aria-describedby="stateHelp">
                                            <option selected disabled>Choose one state</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}" {{ (old('state_id') == $state->id) ? ' selected' : '' }}>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('state_id'))<section class="form-control-feedback">{{ $errors->first('state_id') }}</section>@endif
                                        <small class="form-text text-muted d-flex justify-content-between" id="stateHelp">State where this city belongs. <span class="text-grey">Required</span></small>
                                    </fieldset>
                                </section>
                                <section class="form-group mt-4">
                                    <a href="{{ route('city.index') }}" class="btn btn-secondary">Back to city</a>
                                    <button type="submit" class="btn btn-primary float-right" role="button">Save city</button>
                                </section>
                            </form>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </article>
@endsection