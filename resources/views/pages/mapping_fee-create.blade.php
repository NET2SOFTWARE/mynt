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
                        <p class="medium lh-1-5 mb-0">CREATE MAPPING FEE</p>
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
                    <h5>Create new fee mapping</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    <form method="post" action="{{ route('mapping_fee.store') }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        <input type="hidden" name="mapping_charge_id" value="{{ $mapping_charge->id }}">

                        <fieldset class="form-group">
                            <label for="service_id">Service</label>
                            <input name="service_id" class="form-control" value="{{ $mapping_charge->service()->first()['name'] }}" type="text" disabled>
                            <small class="form-text text-muted d-flex justify-content-between">&nbsp; <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="charge_id">Charge</label>
                            <input name="charge_id" class="form-control" value="{{ $mapping_charge->charge()->first()['name'] }}" type="text" disabled>
                            <small class="form-text text-muted d-flex justify-content-between">&nbsp; <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset class="form-group">
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
                            <small class="form-text text-muted d-flex justify-content-between">&nbsp; <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset id="fieldCompany" class="form-group">
                            @if($mapping_charge->account_type_id == '3')
                            <label for="account_id">Company</label>
                            <input class="form-control"
                                type="text"
                                name="account_id"
                                value="{{ $mapping_charge->account()->first()->companies()->first()['name'] }}"
                                disabled>
                            <small class="form-text text-muted d-flex justify-content-between">&nbsp; <span class="text-grey">Required</span></small>
                            @else
                            <label for="account_id">Merchant</label>
                            <input class="form-control"
                                type="text"
                                name="account_id"
                                value="{{ $mapping_charge->account()->first()->merchants()->first()['name'] }}"
                                disabled>
                            <small class="form-text text-muted d-flex justify-content-between">&nbsp; <span class="text-grey">Required</span></small>
                            @endif
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="remaining_amount">Remaining Fee Amount</label>
                            <input id="remaining_amount" name="remaining_amount" class="form-control" value="{{ $mapping_charge->amount - $mapping_fees->sum('amount') }}" type="number" min="0" max="999999" disabled />
                            <small class="form-text text-muted d-flex justify-content-between">Numeric remaining fee amount. Min. 0.<span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('service_id') ? ' has-danger' : '' }}">
                            <label for="account_id">Fee receiver</label>
                            <select id="account_id" name="account_id" class="form-control w-100">
                                <option {{ is_null(old('account_id')) ? 'selected' : '' }} disabled>Choose one</option>
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->number }}
                                    -
                                    {{ $account->companies()->first()['name'] }} 
                                    {{ $account->merchants()->first()['name'] }} 
                                    ({{ ucfirst($account->account_type()->first()['name']) }})
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('account_id'))<section class="form-control-feedback">{{ $errors->first('account_id') }}</section>@endif
                            <small class="form-text text-muted d-flex justify-content-between">Please select one fee receiver. <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                            <label for="amount">Fee amount</label>
                            <input id="amount" name="amount" class="form-control" type="number" min="0" max="{{ $mapping_charge->amount - $mapping_fees->sum('amount') }}" />
                            @if ($errors->has('amount'))<section class="form-control-feedback">{{ $errors->first('amount') }}</section>@endif
                            <small class="form-text text-muted d-flex justify-content-between">Numeric fee amount. Min. 0, Max. {{ $mapping_charge->amount - $mapping_fees->sum('amount') }} (value of remaining fee amount).<span class="text-grey">Required</span></small>
                        </fieldset>
                        <a href="{{ route('mapping_fee.index', [$mapping_charge->id]) }}" tabindex="-1" class="btn btn-secondary small-caps">cancel</a>
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
$(function() {
    $remaining = $('#remaining_amount');
    $fee = $('#amount');

    $fee.on('input', function(){
        var diff = {{ $mapping_charge->amount - $mapping_fees->sum('amount') }} - $(this).val();

        if (diff < 0)
        {
            $remaining.val(0);
            $fee.val({{ $mapping_charge->amount - $mapping_fees->sum('amount') }});
        } else {
            $remaining.val(diff);
        }
    });
});
</script>
@endsection