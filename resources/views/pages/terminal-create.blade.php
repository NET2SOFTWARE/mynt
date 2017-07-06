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
                        <p class="medium lh-1-5 mb-0">TERMINAL</p>
                    </section>
                </section>
                <section class="row">
                    <section class="col-sm-8 offset-sm-2 py-3">
                        <section class="mt-3 mb-5">
                            <section class="mb-4">
                                <h4><small>Create new terminal</small></h4>
                                <p class="small text-grey">Please insert with valid data.</p>
                                @if (session('success'))<section class="alert alert-success">{{ session('success') }}</section>@endif
                                @if (session('warning'))<section class="alert alert-danger">{{ session('warning') }}</section>@endif
                            </section>
                            <form class="mb-3" method="post" action="{{ route('terminal.store') }}" accept-charset="utf-8" role="form">
                                {{ csrf_field() }}
                                <section class="card card-block p-5">
                                    <h6 class="mb-0 medium-small text-warning">TERMINAL DATA</h6>
                                    <section><hr/></section>
                                    <fieldset class="form-group{{ $errors->has('code') ? ' has-danger' : '' }}">
                                        <label for="code">Code</label>
                                        <input id="code" name="code" class="form-control" value="{{ old('code') }}" type="number" min="0" maxlength="8" max="99999999" />
                                        @if ($errors->has('code'))<section class="form-control-feedback">{{ $errors->first('code') }}</section>@endif
                                        <small class="form-text text-muted d-flex justify-content-between">Numeric terminal code. Min. 0 digits. Max. 8 digits.<span class="text-grey">Required</span></small>
                                    </fieldset>
                                    <h6 class="mb-0 medium-small text-warning mt-4">TERMINAL MERCHANT</h6>
                                    <section><hr/></section>
                                    <fieldset class="form-group{{ $errors->has('merchant_id') ? ' has-danger' : '' }}">
                                        <label for="merchant_id">Merchant</label>
                                        <select id="merchant_id" name="merchant_id" class="form-control w-100">
                                            <option selected disabled>Choose one merchant</option>
                                            @foreach($merchants as $merchant)
                                            <option value="{{ $merchant->id }}">{{ $merchant->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('merchant_id'))<section class="form-control-feedback">{{ $errors->first('merchant_id') }}</section>@endif
                                        <small class="form-text text-muted d-flex justify-content-between">Please select one merchant. <span class="text-grey">Required</span></small>
                                    </fieldset>
                                </section>
                                <section class="form-group mt-4">
                                    <a href="{{ route('terminal.index') }}" class="btn btn-secondary small-caps">cancel</a>
                                    <button type="submit" class="btn btn-primary float-right small-caps" role="button">save</button>
                                </section>
                            </form>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </article>
@endsection