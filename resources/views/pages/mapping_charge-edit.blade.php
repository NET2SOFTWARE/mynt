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
                        <p class="medium lh-1-5 mb-0">MAPPING CHARGE</p>
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
                    <h5>Create new charge mapping</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    <form method="post" action="{{ route('mapping_charge.update', [$mapping_charge->id]) }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <fieldset class="form-group{{ $errors->has('service_id') ? ' has-danger' : '' }}">
                            <label for="service_id">Service</label>
                            <input name="service_id" class="form-control" value="{{ $mapping_charge->service()->first()['name'] }}" type="text" readonly>
                            <small class="form-text text-muted d-flex justify-content-between">Please select one service. <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('charge_id') ? ' has-danger' : '' }}">
                            <label for="charge_id">Charge</label>
                            <input name="charge_id" class="form-control" value="{{ $mapping_charge->charge()->first()['name'] }}" type="text" readonly>
                            <small class="form-text text-muted d-flex justify-content-between">Please select one charge. <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('account_type_id') ? ' has-danger' : '' }}">
                            <label>Implement to</label><br/>
                            <label class="custom-control custom-radio">
                                <input id="implementCompany" name="account_type_id" type="radio" value="3" class="custom-control-input" disabled required {{ $mapping_charge->account_type_id == '3' ? 'checked' : '' }}> 
                                <span class="custom-control-indicator"></span> 
                                <span class="custom-control-description">Member of selected company</span>
                            </label>
                            <br/>
                            <label class="custom-control custom-radio">
                                <input id="implementMerchant" name="account_type_id" type="radio" value="4" class="custom-control-input" disabled required {{ $mapping_charge->account_type_id == '4' ? 'checked' : '' }}> 
                                <span class="custom-control-indicator"></span> 
                                <span class="custom-control-description">Members who conduct transactions on selected merchant</span>
                            </label>
                            <small class="form-text text-muted d-flex justify-content-between">Please select where this charge will implement to. <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset id="fieldCompany" class="form-group{{ $errors->has('account_id') ? ' has-danger' : '' }}">
                            @if($mapping_charge->account_type_id == '3')
                            <label for="account_id">Company</label>
                            <input class="form-control"
                                type="text"
                                name="account_id"
                                value="{{ $mapping_charge->account()->first()->companies()->first()['name'] }}"
                                readonly>
                            <small class="form-text text-muted d-flex justify-content-between">Please select one or more company <span class="text-grey">Required</span></small>
                            @else
                            <label for="account_id">Merchant</label>
                            <input class="form-control"
                                type="text"
                                name="account_id"
                                value="{{ $mapping_charge->account()->first()->merchants()->first()['name'] }}"
                                readonly>
                            <small class="form-text text-muted d-flex justify-content-between">Please select one or more merchant <span class="text-grey">Required</span></small>
                            @endif
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                            <label for="amount">Amount</label>
                            <input id="amount" name="amount" class="form-control" value="{{ $mapping_charge->amount }}" type="number" min="0" max="999999" />
                            @if ($errors->has('amount'))<section class="form-control-feedback">{{ $errors->first('amount') }}</section>@endif
                            <small class="form-text text-muted d-flex justify-content-between">Numeric charge amount. Min. 0, Max. 6.<span class="text-grey">Required</span></small>
                        </fieldset>
                        <a href="{{ route('mapping_charge.index') }}" tabindex="-1" class="btn btn-secondary small-caps">cancel</a>
                        <button type="submit" class="btn btn-primary float-right small-caps" role="button">save</button>
                        <br>
                        <br>
                    </form>
                </section>
            </section>
        </section>
    </article>
@endsection