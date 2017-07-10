@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => 'management'])@endcomponent
            <section class="col-md-9 py-3">
                <h6 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">Management</h6>
                <section class="card mt-3" style="min-height:565px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.management.account') }}">Merchant Account</a></li>
                            <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <header class="px-md-5 mt-3">
                            <h5 class="d-flex justify-content-between align-items-baseline">
                                Create new bank account
                                <span>
                                    <a href="{{ route('merchant.management.bank') }}" class="btn btn-sm btn-primary">Bank to list</a>
                                </span>
                            </h5>
                            <hr class="clearfix"/>
                        </header>
                        <section class="px-md-5">
                            <form action="{{ route('merchant.management.bank.store') }}" method="post" accept-charset="utf-8" role="form">
                                {{ csrf_field() }}
                                <fieldset class="form-group{{ $errors->has('institution_id') ? ' has-danger' : '' }}">
                                    <label for="institution-id">Institution ID</label>
                                    <input id="institution-id" name="institution_id" class="form-control" value="{{ old('institution_id')  }}" placeholder="Referral code" type="text" aria-describedby="institutionIdHelp">
                                    @if ($errors->has('institution_id'))<section class="form-control-feedback">{{ $errors->first('institution_id') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between" id="institutionIdHelp">Referral code <span class="text-grey">Required</span></small>
                                </fieldset>
                                <fieldset class="form-group{{ $errors->has('account_id') ? ' has-danger' : '' }}">
                                    <label for="account-id">Account ID</label>
                                    <input id="account-id" name="account_id" class="form-control" value="{{ old('account_id')  }}" placeholder="Account ID" type="text" aria-describedby="accountIdHelp">
                                    @if ($errors->has('account_id'))<section class="form-control-feedback">{{ $errors->first('account_id') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between" id="accountIdHelp">Real name of your bank's account. <span class="text-grey">Required</span></small>
                                </fieldset>
                                <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" class="form-control" value="{{ old('name')  }}" placeholder="Bank account name" type="text" aria-describedby="nameHelp">
                                    @if ($errors->has('name'))<section class="form-control-feedback">{{ $errors->first('name') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between" id="nameHelp">Full country name. Max. 40 characters, eg. `Indonesia` <span class="text-grey">Required</span></small>
                                </fieldset>
                                <fieldset class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                    <label for="address">Address</label>
                                    <textarea id="address" name="address" class="form-control" rows="3" placeholder="Address street" aria-describedby="addressHelp" required>{{ old('address') }}</textarea>
                                    @if ($errors->has('address'))<section class="form-control-feedback">{{ $errors->first('address') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between" id="addressHelp">Address street <span class="text-grey">Required</span></small>
                                </fieldset>
                                <fieldset class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                    <label for="city">City</label>
                                    <select id="city" name="city" class="custom-select w-100" aria-describedby="cityHelp" required>
                                        <option selected disabled>Choose address city</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city'))<section class="form-control-feedback">{{ $errors->first('city') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between" id="cityHelp">Full country name. Max. 40 characters, eg. `Indonesia` <span class="text-grey">Required</span></small>
                                </fieldset>
                                <fieldset class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                    <label for="country">Country</label>
                                    <input id="country" name="country" class="form-control" placeholder="Country" value="Indonesia" aria-describedby="countryId" readonly required>
                                    @if ($errors->has('country'))<section class="form-control-feedback">{{ $errors->first('country') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between" id="countryId">Address country <span class="text-grey">Required</span></small>
                                </fieldset>
                            </form>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
