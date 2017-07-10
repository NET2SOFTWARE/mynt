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
                <section class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 p-5">
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

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="form-group">
                                    <label for="service_id">Service</label>
                                    <input name="service_id" class="form-control" value="{{ $mapping_charge->service()->first()['name'] }}" type="text" disabled>
                                    <small class="form-text text-muted d-flex justify-content-between">&nbsp; <span class="text-grey">Info</span></small>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="form-group">
                                    <label for="charge_id">Charge</label>
                                    <input name="charge_id" class="form-control" value="{{ $mapping_charge->charge()->first()['name'] }}" type="text" disabled>
                                    <small class="form-text text-muted d-flex justify-content-between">&nbsp; <span class="text-grey">Info</span></small>
                                </fieldset>
                            </div>
                        </div>
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
                            <small class="form-text text-muted d-flex justify-content-between">&nbsp; <span class="text-grey">Info</span></small>
                        </fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset id="fieldCompany" class="form-group">
                                    @if($mapping_charge->account_type_id == '3')
                                    <label for="account_id">Company</label>
                                    <input class="form-control"
                                        type="text"
                                        name="account_id"
                                        value="{{ $mapping_charge->account()->first()->companies()->first()['name'] }}"
                                        disabled>
                                    <small class="form-text text-muted d-flex justify-content-between">&nbsp; <span class="text-grey">Info</span></small>
                                    @else
                                    <label for="account_id">Merchant</label>
                                    <input class="form-control"
                                        type="text"
                                        name="account_id"
                                        value="{{ $mapping_charge->account()->first()->merchants()->first()['name'] }}"
                                        disabled>
                                    <small class="form-text text-muted d-flex justify-content-between">&nbsp; <span class="text-grey">Info</span></small>
                                    @endif
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                            <fieldset class="form-group">
                                <label for="remaining_amount">Remaining Fee Amount</label>
                                <input id="remaining_amount" name="remaining_amount" class="form-control" value="{{ $mapping_charge->amount - $mapping_fees->sum('amount') }}" type="number" min="0" max="999999" disabled />
                                <small class="form-text text-muted d-flex justify-content-between">Numeric remaining fee amount. Min. 0.<span class="text-grey">Info</span></small>
                            </fieldset>
                            </div>
                        </div>
                        <div id="fee-wrapper">
                        <div class="row">
                            <div class="col-md-6 fee-receiver">
                                <fieldset class="form-group{{ $errors->has('service_id') ? ' has-danger' : '' }}">
                                    <label for="account_id">Fee receiver</label>
                                    <select name="account_id[]" class="form-control w-100">
                                        <option {{ is_null(old('account_id')) ? 'selected' : '' }} disabled value="0">Choose one</option>
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
                            </div>
                            <div class="col-md-4 fee-amount">
                                <fieldset class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                    <label>Fee amount</label>
                                    <input name="amount[]" class="form-control" type="number" min="1" max="{{ $mapping_charge->amount - $mapping_fees->sum('amount') }}" />
                                    @if ($errors->has('amount'))<section class="form-control-feedback">{{ $errors->first('amount') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between">Numeric fee amount. Min. 1, Max. {{ $mapping_charge->amount - $mapping_fees->sum('amount') }} (value of remaining fee amount).<span class="text-grey">Required</span></small>
                                </fieldset>
                            </div>
                            <div class="col-sm-4 col-md-2 pl-0">
                                <button class="btn btn-block btn-secondary small-caps px-1 btn-add" style="margin-top: 31px;" type="button" role="button">add</button>
                                <button class="btn btn-block btn-danger small-caps px-1 btn-delete" style="margin-top: 31px; display:none;" type="button" role="button">remove</button>
                            </div>
                        </div>
                        </div>
                        <a href="{{ route('mapping_fee.index', [$mapping_charge->id]) }}" tabindex="-1" class="btn btn-secondary small-caps">back</a>
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
    // $remaining = $('#remaining_amount');
    // $fee = $('#amount');

    // $fee.on('input', function(){
    //     var diff = {{ $mapping_charge->amount - $mapping_fees->sum('amount') }} - $(this).val();

    //     if (diff < 0)
    //     {
    //         $remaining.val(0);
    //         $fee.val({{ $mapping_charge->amount - $mapping_fees->sum('amount') }});
    //     } else {
    //         $remaining.val(diff);
    //     }
    // });

    $btnAdd = $('#fee-wrapper .btn-add').last();
    $feeWrapper = $('#fee-wrapper');
    $row = $('#fee-wrapper .row').last();
    $feeAmount = $('.fee-amount');
    $feeReceiver = $('.fee-receiver');
    $fee = $('input[name="amount[]"]');
    $remaining_amount = $('#remaining_amount');
    charges = {{ $mapping_charge->amount - $mapping_fees->sum('amount') }};

    console.log(charges);

    $btnAdd.on('click', function(e){
        e.preventDefault();

        if ($remaining_amount.val() < 1)
        {
            insertAlert('Charge already zero (mapped to all receiver), you cannot add more fees.', $row);
            return;
        }

        $('.alert').alert('close');

        $addAccount = $row.find('select');
        $addFee = $row.find('input[name="amount[]"]');

        showAlert = false;

        if (! $addAccount.val())
        {
            $addAccount.parents('.form-group').first().addClass('has-danger');
            insertAlert('Receiver must not be empty.', $row);
            return;
        }

        if ($addFee.val() < 1)
        {
            $addFee.parents('.form-group').first().addClass('has-danger');
            insertAlert('Fee must be greater than zero.', $row);
            return;
        }

        $.each($('#fee-wrapper .row select').not($addAccount), function(i, obj){
            if ($(obj).val() == $addAccount.val()) showAlert = true;
        });

        if (showAlert)
        {
            $addAccount.parents('.form-group').first().addClass('has-danger');
            insertAlert('Receiver must be unique.', $row);
            return;
        }

        $clone = $row.clone(true);
        $clone.find('.btn-add').hide();
        $clone.find('.btn-delete').on('click', function(e){ removeRow($(this).parents('.row').first()); }).show();
        $clone.find('select[name="account_id[]"]').val($row.find('select').val());
        $clone.find('input[name="amount[]"]').on('input', function() { calc($(this)); });
        $clone.find('fieldset').prop('disabled', true);
        $clone.insertBefore($row);

        $addAccount.val(0);
        $addFee.val('');
    });

    $fee.on('input', function() { calc($(this)); });

    $('form').on('submit', function(e){
        e.preventDefault();

        if ($remaining_amount.val() > 0)
        {
            insertAlert('Charge must be zero (mapped to all receiver) before saving.', $row);
            $('#myntModalConfirmCreate').modal('hide');
            return;
        }

        $('[disabled]').prop('disabled', false);

        this.submit();
    });

    function calc($this) {
        fees = 0;

        $.each($('input[name="amount[]"]'), function(i, obj){ fees += parseInt($(obj).val()); });

        if (fees) $remaining_amount.val(charges - fees);
        else $remaining_amount.val(charges);

        if ($remaining_amount.val() < 0)
        {
            $remaining_amount.val(0);

            excluded = 0;
            
            $.each($('input[name="amount[]"]').not($this), function(i, obj){ excluded += parseInt($(obj).val()); });

            $this.val(remaining_amount - excluded);
        }
    }

    function removeRow(row) {
        row.remove();

        fees = 0;

        $.each($('input[name="amount[]"]'), function(i, obj){ val = !$(obj).val() ? 0 : $(obj).val(); fees += parseInt(val); });

        console.log(fees);

        if (fees) $remaining_amount.val(charges - fees); else $remaining_amount.val(charges);
    }

    function insertAlert(msg, row) {
        alert  = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        alert += '<span aria-hidden="true">&times;</span>';
        alert += '</button>';
        alert += msg;
        alert += '</div>';

        $(alert).on('closed.bs.alert', function () { $('.has-danger').removeClass('has-danger'); }).insertAfter(row);
    }
});
</script>
@endsection