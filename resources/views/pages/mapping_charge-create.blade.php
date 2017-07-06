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
                    <form method="post" action="{{ route('mapping_charge.store') }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        <fieldset class="form-group{{ $errors->has('service_id') ? ' has-danger' : '' }}">
                            <label for="service_id">Service</label>
                            <select id="service_id" name="service_id" class="form-control w-100">
                                <option {{ is_null(old('service_id')) ? 'selected' : '' }} disabled>Choose one service</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('service_id'))<section class="form-control-feedback">{{ $errors->first('service_id') }}</section>@endif
                            <small class="form-text text-muted d-flex justify-content-between">Please select one service. <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('charge_id') ? ' has-danger' : '' }}">
                            <label for="charge_id">Charge</label>
                            <select id="charge_id" name="charge_id" class="form-control w-100">
                                <option {{ is_null(old('charge_id')) ? 'selected' : '' }} disabled>Choose one charge</option>
                                @foreach($charges as $charge)
                                <option value="{{ $charge->id }}" {{ old('charge_id') == $charge->id ? 'selected' : '' }}>{{ $charge->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('charge_id'))<section class="form-control-feedback">{{ $errors->first('charge_id') }}</section>@endif
                            <small class="form-text text-muted d-flex justify-content-between">Please select one charge. <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('account_type_id') ? ' has-danger' : '' }}">
                            <label for="account_type_id">Implement to</label><br/>
                            <label class="custom-control custom-radio">
                                <input id="implementCompany" name="account_type_id" type="radio" value="3" class="custom-control-input" required {{ is_null(old('account_type_id')) ? 'checked' : (old('account_type_id') == 3 ? 'checked' : '') }}> 
                                <span class="custom-control-indicator"></span> 
                                <span class="custom-control-description">Member of selected company</span>
                            </label>
                            <br/>
                            <label class="custom-control custom-radio">
                                <input id="implementMerchant" name="account_type_id" type="radio" value="4" class="custom-control-input" required {{ old('account_type_id') == 4 ? 'checked' : '' }}> 
                                <span class="custom-control-indicator"></span> 
                                <span class="custom-control-description">Members who conduct transactions on selected merchant</span>
                            </label>
                            @if ($errors->has('account_type_id'))<section class="form-control-feedback">{{ $errors->first('account_type_id') }}</section>@endif
                            <small class="form-text text-muted d-flex justify-content-between">Please select where this charge will implement to. <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset id="fieldCompany" class="form-group{{ $errors->has('account_id') ? ' has-danger' : '' }}">
                            <label for="account_id">Company</label>
                            <select id="selectCompany" name="account_id[]" class="form-control w-100" multiple="multiple">
                                @foreach($companies as $company)
                                    <option value="{{ $company->accounts()->first()['id'] }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('account_id'))<section class="form-control-feedback">{{ $errors->first('account_id') }}</section>@endif
                            <small class="form-text text-muted d-flex justify-content-between">Please select one or more company <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset id="fieldMerchant" class="form-group{{ $errors->has('account_id') ? ' has-danger' : '' }}" style="display: none;">
                            <label for="account_id">Merchant</label>
                            <select id="selectMerchant" name="account_id[]" class="form-control w-100" multiple="multiple">
                                @foreach($merchants as $merchant)
                                    <option value="{{ $merchant->accounts()->first()['id'] }}">{{ $merchant->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('account_id'))<section class="form-control-feedback">{{ $errors->first('account_id') }}</section>@endif
                            <small class="form-text text-muted d-flex justify-content-between">Please select one or more merchant <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                            <label for="amount">Amount</label>
                            <input id="amount" name="amount" class="form-control" value="{{ old('amount') }}" type="number" min="0" max="999999" />
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

@section('script')
<script>
$(function(){
    $radios = $('input[name="account_type_id"]');
    $fieldCompany = $('#fieldCompany');
    $fieldMerchant = $('#fieldMerchant');
    $selectCompany = $('#selectCompany');
    $selectMerchant = $('#selectMerchant');

    @if(! is_null(old('account_type_id')))
        @if(old('account_type_id') == 3)
            $fieldMerchant.hide();
            @if(count(old('account_id')) > 0)
            $selectCompany.multiselect('select', {!! json_encode(old('account_id')) !!});
            @endif
            $fieldCompany.fadeIn();
        @else
            $fieldCompany.hide();
            @if(count(old('account_id')) > 0)
            $selectMerchant.multiselect('select', {!! json_encode(old('account_id')) !!});
            @endif
            $fieldMerchant.fadeIn();
        @endif
    @endif

    $radios.on('change', function (e) {
        $radio = $(this);

        if ($radio.attr('id') == 'implementCompany')
        {
            $fieldMerchant.hide();
            $selectMerchant.find('option:selected').each(function() { $(this).prop('selected', false); });
            $selectMerchant.multiselect('refresh');
            $fieldCompany.fadeIn();
        } else {
            $fieldCompany.hide();
            $selectCompany.find('option:selected').each(function() { $(this).prop('selected', false); });
            $selectCompany.multiselect('refresh');
            $fieldMerchant.fadeIn();
        }
    });
});
</script>
@endsection