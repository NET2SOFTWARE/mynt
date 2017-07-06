@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => ''])@endcomponent
            <section class="col-md-9 py-3">
                <h6 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">Profile</h6>
                <section class="card my-3" style="min-height:540px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.profile') }}">Profile</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="row">
                            <section class="col-sm-6">
                                <form action="{{ route('upgrade.member') }}" method="POST" class="card card-block p-4 mb-3" accept-charset="utf-8" role="form">
                                    {{ csrf_field() }}
                                    <h6 class="text-muted text-uppercase mb-4"><small>Credential</small></h6>
                                    <section class="form-group{{ $errors->has('born_place') ? ' has-danger' : '' }}">
                                        <label for="name">Name</label>
                                        <input id="name" name="name" type="text" value="{{ $merchant->name }}" class="form-control" placeholder="Full name">
                                        @if ($errors->has('born_place'))<section class="form-control-feedback">{{ $errors->first('born_place') }}</section>@endif
                                    </section>
                                    <section class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label for="email">E-mail address</label>
                                        <input id="email" name="email" type="email" value="{{ $merchant->email }}" class="form-control" placeholder="Email address">
                                        @if ($errors->has('email'))<section class="form-control-feedback">{{ $errors->first('email') }}</section>@endif
                                    </section>
                                    <section class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                        <label for="phone">Phone number</label>
                                        <input id="phone" name="phone" type="text" value="{{ $merchant->phone }}" class="form-control" placeholder="Phone number">
                                        @if ($errors->has('phone'))<section class="form-control-feedback">{{ $errors->first('phone') }}</section>@endif
                                    </section>
                                    <section class="form-group mt-3 text-right">
                                        <button class="btn btn-primary" type="submit" role="button">Update Credential</button>
                                    </section>
                                </form>

                                <form action="{{ route('upgrade.member') }}" method="POST" class="card card-block p-4 mb-3" accept-charset="utf-8" role="form">
                                    {{ csrf_field() }}
                                    <h6 class="text-muted text-uppercase mb-4"><small>Password</small></h6>
                                    <section class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                        <label for="name" class="sr-only">Old password</label>
                                        <input id="old_password" name="old_password" type="password" class="form-control" placeholder="Old password">
                                        @if ($errors->has('old_password'))<section class="form-control-feedback">{{ $errors->first('old_password') }}</section>@endif
                                    </section>
                                    <section class="form-group{{ $errors->has('new_password') ? ' has-danger' : '' }}">
                                        <label for="new_password" class="sr-only">E-mail address</label>
                                        <input id="new_password" name="new_password" type="password" value="{{ old('new_password') }}" class="form-control" placeholder="New password">
                                        @if ($errors->has('new_password'))<section class="form-control-feedback">{{ $errors->first('new_password') }}</section>@endif
                                    </section>
                                    <section class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                        <label for="password_confirmation" class="sr-only">Confirm new password</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Confirm new password">
                                        @if ($errors->has('password_confirmation'))<section class="form-control-feedback">{{ $errors->first('password_confirmation') }}</section>@endif
                                    </section>
                                    <section class="form-group text-right">
                                        <button class="btn btn-primary" type="submit" role="button">Change Password</button>
                                    </section>
                                </form>

                                {{--<form action="{{ route('upgrade.member') }}" method="POST" class="card card-block p-4 mb-3" accept-charset="utf-8" role="form">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--<h6 class="text-muted text-uppercase mb-4"><small>Location</small></h6>--}}
                                    {{--<section class="form-group{{ $errors->has('street') ? ' has-danger' : '' }}">--}}
                                        {{--<label for="street">Street</label>--}}
                                        {{--<textarea class="form-control" id="street" rows="3">{{ $merchant->locations->first()['street'] }}</textarea>--}}
                                        {{--@if ($errors->has('born_place'))<section class="form-control-feedback">{{ $errors->first('born_place') }}</section>@endif--}}
                                    {{--</section>--}}
                                    {{--<section class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">--}}
                                        {{--<label for="city">City</label>--}}
                                        {{--<select id="city" name="city" class="custom-select w-100">--}}
                                            {{--<option selected disabled>Choose one city</option>--}}
                                            {{--@foreach($cities as $city)--}}
                                                {{--<option value="{{ $city->id }}" {{ ($merchant->locations->first()['city_id'] == $city->id) ? ' selected' : '' }}>{{ $city->name }}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                        {{--@if ($errors->has('city'))<section class="form-control-feedback">{{ $errors->first('city') }}</section>@endif--}}
                                    {{--</section>--}}
                                    {{--<section class="form-group{{ $errors->has('postal_code') ? ' has-danger' : '' }}">--}}
                                        {{--<label for="postal_code">Postal code</label>--}}
                                        {{--<input id="postal_code" name="postal_code" type="text" value="{{ $merchant->locations->first()['zip_code'] }}" class="form-control" placeholder="Phone number">--}}
                                        {{--@if ($errors->has('phone'))<section class="form-control-feedback">{{ $errors->first('phone') }}</section>@endif--}}
                                    {{--</section>--}}
                                    {{--<section class="form-group mt-3 text-right">--}}
                                        {{--<button class="btn btn-primary" type="submit" role="button">Update</button>--}}
                                    {{--</section>--}}
                                {{--</form>--}}
                            </section>

                            <section class="col-sm-6">
                                <form action="{{ route('upgrade.member') }}" method="POST" class="card card-block p-4 mb-3" accept-charset="utf-8" role="form">
                                    {{ csrf_field() }}
                                    <h6 class="text-muted text-uppercase mb-4"><small>Bank</small></h6>
                                    <section class="form-group{{ $errors->has('bank_id') ? ' has-danger' : '' }}">
                                        <label for="bank_id">Bank name</label>
                                        <select id="bank_id" class="custom-select w-100">
                                            <option selected disabled>Banks</option>
                                            <option value="{{ 1 }}">001 - Bank Indonesia</option>
                                            <option value="{{ 2 }}">002 - Bank Rakyat Indonesia</option>
                                            <option value="{{ 3 }}">003 - Bank Export Indonesia</option>
                                            <option value="{{ 4 }}">008 - Bank Mandiri</option>
                                            <option value="{{ 5 }}">009 - Bank Negara Indonesia</option>
                                            <option value="{{ 6 }}">011 - Bank Danamon Indonesia</option>
                                        </select>
                                        @if ($errors->has('bank_id'))<section class="form-control-feedback">{{ $errors->first('bank_id') }}</section>@endif
                                    </section>
                                    <section class="form-group{{ $errors->has('bank_account_number') ? ' has-danger' : '' }}">
                                        <label for="bank_account_number">Bank account number</label>
                                        <input id="bank_account_number" name="phone" type="text" value="{{ old('bank_account_number') }}" class="form-control" placeholder="Bank account number">
                                        @if ($errors->has('bank_account_number'))<section class="form-control-feedback">{{ $errors->first('bank_account_number') }}</section>@endif
                                    </section>
                                    <section class="form-group mt-4 text-right">
                                        <button class="btn btn-primary" type="submit" role="button">Update</button>
                                    </section>
                                </form>

                                <form action="{{ route('upgrade.member') }}" method="POST" class="card card-block p-4 mb-3" accept-charset="utf-8" role="form">
                                    {{ csrf_field() }}
                                    <h6 class="text-muted text-uppercase mb-4"><small>Terminal</small></h6>
                                    <section class="form-group{{ $errors->has('bank_account_number') ? ' has-danger' : '' }}">
                                        <label for="bank_account_number" class="sr-only">Phone</label>
                                        <input id="bank_account_number" name="phone" type="text" value="{{ old('bank_account_number') }}" class="form-control" placeholder="Bank account number">
                                        @if ($errors->has('bank_account_number'))<section class="form-control-feedback">{{ $errors->first('bank_account_number') }}</section>@endif
                                    </section>
                                    <section class="form-group mt-4 text-right">
                                        <button class="btn btn-primary" type="submit" role="button">Update</button>
                                    </section>
                                </form>
                            </section>
                        </section>
                    </section>
                    <section class="card-footer">
                        <small class="text-muted">Note : If you have a trouble, please contact our costumer service.</small>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
