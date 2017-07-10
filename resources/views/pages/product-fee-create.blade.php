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
                        <p class="medium lh-1-5 mb-0">PRODUCT FEE</p>
                    </section>
                </section>
                <section class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 p-5">
                    @if (session('success'))
                        <section class="alert alert-success">{{ session('success') }}</section>
                    @endif
                    @if (session('warning'))
                        <section class="alert alert-danger">{{ session('warning') }}</section>
                    @endif
                    <h5>Create new product fee mapping</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    <form method="post" action="{{ route('product.fee.store', [$data->id]) }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="form-group">
                                    <label>Supplier</label>
                                    <input id="supplier" class="form-control" type="text" disabled value="{{ $data->product_sales()->first()->product_purchase()->first()->companies()->first()->name }}">
                                    <small class="form-text text-muted d-flex justify-content-between">
                                        Supplier of selected product. <span class="text-grey">Info</span>
                                    </small>
                                </fieldset>
                                <fieldset class="form-group">
                                    <label>Product</label>
                                    <input id="product" class="form-control" type="text" disabled value="{{ $data->product_sales()->first()->product_purchase()->first()->products()->first()->name }}">
                                    <small class="form-text text-muted d-flex justify-content-between">
                                        Charged product. <span class="text-grey">Info</span>
                                    </small>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="form-group">
                                    <label>Merchant</label>
                                    <input id="merchant" class="form-control" type="text" disabled value="{{ $data->product_sales()->first()->merchants()->first()->name }}">
                                    <small class="form-text text-muted d-flex justify-content-between">
                                        Seller of selected product. <span class="text-grey">Info</span>
                                    </small>
                                </fieldset>
                                <fieldset class="form-group">
                                    <label>Charge</label>
                                    <input id="charge" class="form-control" type="number"
                                        @if ($data->product_fees()->count() > 0)
                                        value="{{ $data->charge - $data->product_fees()->sum('fee') }}"
                                        @else
                                        value="{{ $data->charge }}"
                                        @endif
                                        disabled>
                                    <small class="form-text text-muted d-flex justify-content-between">
                                        Product charge on selected merchant. <span class="text-grey">Info</span>
                                    </small>
                                </fieldset>
                            </div>
                        </div>

                        <div id="fee-wrapper">
                        <div class="row">
                            <div class="col-sm-8 col-md-6 fee-receiver">
                                <fieldset class="form-group">
                                    <label>Fee receiver</label>
                                    <select name="account_id[]" class="custom-select w-100 form-control" value="{{ old('account_id') }}" size required>
                                        <option selected disabled value="0">Choose one account</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ (old('account_id') == $account->id) ? 'selected' : '' }}>
                                                {{ $account->number }}
                                                -
                                                {{ $account->{str_plural($account->account_type()->first()->name)}()->first()->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('account_id'))
                                        <section class="form-control-feedback">{{ $errors->first('account_id') }}</section>
                                    @endif
                                    <small class="form-text text-muted d-flex justify-content-between">
                                        Select fee receiver.<span class="text-grey">Required</span>
                                    </small>
                                </fieldset>
                            </div>
                            <div class="col-sm-8 col-md-4 fee-amount">
                                <fieldset class="form-group">
                                    <label>Fee</label>
                                    <input name="fee[]" class="form-control" value="{{ old('fee') ? old('fee') : 0 }}" type="number" required>
                                    @if ($errors->has('fee'))
                                        <section class="form-control-feedback">{{ $errors->first('fee') }}</section>
                                    @endif
                                    <small class="form-text text-muted d-flex justify-content-between">
                                        Numeric, greater than zero. <span class="text-grey">Required</span>
                                    </small>
                                </fieldset>
                            </div>
                            <div class="col-sm-4 col-md-2 pl-0">
                                <button class="btn btn-block btn-secondary small-caps px-1 btn-add" style="margin-top: 31px;" type="button" role="button">add</button>
                                <button class="btn btn-block btn-danger small-caps px-1 btn-delete" style="margin-top: 31px; display:none;" type="button" role="button">remove</button>
                            </div>
                        </div>
                        </div>

                        <a href="{{ route('product.fee.index', [$data->id]) }}" tabindex="-1" class="btn btn-secondary small-caps">back</a>
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
        $btnAdd = $('#fee-wrapper .btn-add').last();
        $feeWrapper = $('#fee-wrapper');
        $row = $('#fee-wrapper .row').last();
        $feeAmount = $('.fee-amount');
        $feeReceiver = $('.fee-receiver');
        $fee = $('input[name="fee[]"]');
        $charge = $('#charge');
        @if ($data->product_fees()->count() > 0)
        charges = {{ $data->charge - $data->product_fees()->sum('fee') }};
        @else
        charges = {{ $data->charge }};
        @endif

        $btnAdd.on('click', function(e){
            e.preventDefault();

            if ($charge.val() < 1)
            {
                insertAlert('Charge already zero (mapped to all receiver), you cannot add more fees.', $row);
                return;
            }

            $('.alert').alert('close');

            $addAccount = $row.find('select');
            $addFee = $row.find('input[name="fee[]"]');

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
            $clone.find('input[name="fee[]"]').on('input', function() { calc($(this)); });
            $clone.find('fieldset').prop('disabled', true);
            $clone.insertBefore($row);

            $addAccount.val(0);
            $addFee.val('');
        });

        $fee.on('input', function() { calc($(this)); });

        $('form').on('submit', function(e){
            e.preventDefault();

            if ($charge.val() > 0)
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

            $.each($('input[name="fee[]"]'), function(i, obj){ fees += parseInt($(obj).val()); });

            if (fees) $charge.val(charges - fees);
            else $charge.val(charges);

            if ($charge.val() < 0)
            {
                $charge.val(0);

                excluded = 0;
                
                $.each($('input[name="fee[]"]').not($this), function(i, obj){ excluded += parseInt($(obj).val()); });

                $this.val(charges - excluded);
            }
        }

        function removeRow(row) {
            row.remove();

            fees = 0;

            $.each($('input[name="fee[]"]'), function(i, obj){ val = !$(obj).val() ? 0 : $(obj).val(); fees += parseInt(val); });

            console.log(fees);

            if (fees) $charge.val(charges - fees); else $charge.val(charges);
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
