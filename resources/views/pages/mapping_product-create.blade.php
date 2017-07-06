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
                        <p class="medium lh-1-5 mb-0">MAPPING PRODUCT TAX & FEE</p>
                    </section>
                </section>
                <section class="col-sm-8 offset-sm-2 p-5">
                    @if (session('success'))
                        <section class="alert alert-success">{{ session('success') }}</section>
                    @endif
                    @if (session('warning'))
                        <section class="alert alert-danger">{{ session('warning') }}</section>
                    @endif
                    <h5>Create new product mapping tax & fee</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    <form method="post" action="{{ route('mapping_product.store') }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        <fieldset class="form-group{{ $errors->has('account_id') ? ' has-danger' : '' }}">
                            <label for="account_id">Seller</label>
                            <select id="account_id" name="account_id" class="form-control w-100">
                                <option {{ is_null(old('account_id')) ? 'selected' : '' }} disabled>Choose one</option>
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}">
                                    {{ $account->companies()->first()['name'] }} 
                                    {{ $account->merchants()->first()['name'] }} 
                                    ({{ ucfirst($account->account_type()->first()['name']) }})
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('account_id'))<section class="form-control-feedback">{{ $errors->first('account_id') }}</section>@endif
                            <small class="form-text text-muted d-flex justify-content-between">Please select one seller. <span class="text-grey">Required</span></small>
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                            <label for="product_id">Product</label>
                            <select id="product_id" name="product_id" class="form-control w-100">
                                <option {{ is_null(old('product_id')) ? 'selected' : '' }} disabled>Choose one</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('product_id'))<section class="form-control-feedback">{{ $errors->first('product_id') }}</section>@endif
                            <small class="form-text text-muted d-flex justify-content-between">Please select one product to map. <span class="text-grey">Required</span></small>
                        </fieldset>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <fieldset class="form-group">
                                    <label>Default Price</label>
                                    <input id="default_price" class="form-control" type="number" placeholder="0" disabled />
                                    <small class="form-text text-muted d-flex justify-content-between">
                                        Numeric. Minimum price to sell. <span class="text-grey">Info</span>
                                    </small>
                                </fieldset>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <fieldset class="form-group">
                                    <label for="price">Mapped Price</label>
                                    <input id="price" name="price" class="form-control" type="number" placeholder="0" disabled />
                                    <small class="form-text text-muted d-flex justify-content-between">
                                        Numeric. Mapped price of product for selected seller. <span class="text-grey">Info</span>
                                    </small>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <fieldset class="form-group{{ $errors->has('tax') ? ' has-danger' : '' }}">
                                    <label for="tax">
                                        Tax 
                                        <span class="text-muted">(default 10% of mapped price)</span>
                                    </label>
                                    <input id="tax" name="tax" class="form-control" value="{{ old('tax') }}" placeholder="0" type="number" />
                                    @if ($errors->has('tax'))
                                        <section class="form-control-feedback">{{ $errors->first('tax') }}</section>
                                    @endif
                                    <small class="form-text text-muted d-flex justify-content-between">
                                        Numeric. Tax of product for selected seller. <span class="text-grey">Required</span>
                                    </small>
                                </fieldset>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <fieldset class="form-group{{ $errors->has('fee') ? ' has-danger' : '' }}">
                                    <label for="fee">Fee</label>
                                    <input id="fee" name="fee" class="form-control" value="{{ old('fee') }}" placeholder="0" type="number" />
                                    @if ($errors->has('fee'))
                                        <section class="form-control-feedback">{{ $errors->first('fee') }}</section>
                                    @endif
                                    <small class="form-text text-muted d-flex justify-content-between">
                                        Numeric. Fee of product for selected seller. <span class="text-grey">Required</span>
                                    </small>
                                </fieldset>
                            </div>
                        </div>
                        <fieldset class="form-group">
                            <label for="total_price">Total Price</label>
                            <input id="total_price" name="total_price" class="form-control" type="number" placeholder="0" disabled />
                            <small class="form-text text-muted d-flex justify-content-between">
                                Numeric. Summary of mapped price, tax and fee of product for selected seller. <span class="text-grey">Info</span>
                            </small>
                        </fieldset>
                        <a href="{{ route('mapping_product.index') }}" tabindex="-1" class="btn btn-secondary small-caps">cancel</a>
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
    $accounts = $('#account_id');
    $product = $('#product_id');
    $tax = $('#tax');
    $fee = $('#fee');
    $price = $('#price');
    $default_price = $('#default_price');
    $total_price = $('#total_price');

    $tax.on('input', calculate);
    $fee.on('input', calculate);
    $accounts.on('change', function() { if ($product.val() !== null) $product.trigger('change'); });
    $product.on('change', function() {
        $.getJSON('{{ route('api.product.show', [null]) }}/' + $product.val(), function (data) {
            $default_price.val(data.product.price);

            var found = false;

            if ($accounts.val() !== null)
            {
                $.each(data.product.companies, function(index, row){
                    $.each(row.accounts, function(index, account){
                        found = found == false ? ($accounts.val() == account.pivot.account_id) : found;
                        if (found) $price.val(row.pivot.price);
                    });
                });

                $.each(data.product.merchants, function(index, row){
                    $.each(row.accounts, function(index, account){
                        found = found == false ? ($accounts.val() == account.pivot.account_id) : found;
                        if (found) $price.val(row.pivot.price);
                    });
                });
            }

            if (found == false) $price.val(data.product.price);

            $tax.val(Math.floor(0.10 * $price.val()));

            calculate();
        });
    });

    function calculate() {
        var price = ! $price.val() ? 0 : parseInt($price.val());
        var tax = ! $tax.val() ? 0 : parseInt($tax.val());
        var fee = ! $fee.val() ? 0 : parseInt($fee.val());

        $total_price.val(price + tax + fee);
    }
});
</script>
@endsection