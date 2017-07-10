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
                        <p class="medium lh-1-5 mb-0">PRODUCT SALES</p>
                    </section>
                </section>
                <section class="col-sm-6 offset-sm-3 p-5">
                    @if (session('success'))
                        <section class="alert alert-success">{{ session('success') }}</section>
                    @endif
                    @if (session('warning'))
                        <section class="alert alert-danger">{{ session('warning') }}</section>
                    @endif
                    <h5>Create new product sales</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    <form method="post" action="{{ route('product.sales.store') }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}

                        <fieldset class="form-group">
                            <label for="product_purchase_price_id">Product</label>
                            <select id="product_purchase_price_id" name="product_purchase_price_id" class="custom-select w-100" value="{{ old('product_id') }}">
                                <option selected disabled>Choose one product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ (old('product_purchase_price_id') == $product->id) ? 'selected' : '' }}>
                                        {{ $product->products()->first()->name }}
                                        -
                                        {{ $product->companies()->first()->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('product_purchase_price_id'))
                                <section class="form-control-feedback">{{ $errors->first('product_purchase_price_id') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Select a product.<span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Supplier</label>
                            <input id="supplier" class="form-control" type="text" disabled>
                            <small class="form-text text-muted d-flex justify-content-between">
                                Product supplier. <span class="text-grey">Info</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Purchase Price</label>
                            <input id="purchase_price" class="form-control" type="number" disabled>
                            <small class="form-text text-muted d-flex justify-content-between">
                                Product purchase price from selected supplier. <span class="text-grey">Info</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="merchant_id">Merchant</label>
                            <select id="merchant_id" name="merchant_id" class="custom-select w-100" value="{{ old('merchant_id') }}">
                                <option selected disabled>Choose one merchant</option>
                                @foreach($merchants as $merchant)
                                    <option value="{{ $merchant->id }}" {{ (old('merchant_id') == $merchant->id) ? 'selected' : '' }}>{{ $merchant->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('merchant_id'))
                                <section class="form-control-feedback">{{ $errors->first('merchant_id') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Select a merchant.<span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="price">Sales Price</label>
                            <input id="price" name="price" class="form-control" value="{{ old('price')  }}" type="number" />
                            @if ($errors->has('price'))
                                <section class="form-control-feedback">{{ $errors->first('price') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Numeric, min. 0. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <a href="{{ route('product.sales.index') }}" tabindex="-1" class="btn btn-secondary small-caps">back</a>
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
        var $product = $('#product_purchase_price_id');
        var $supplier = $('#supplier');
        var $purchase_price = $('#purchase_price');
        var data = {
            @foreach($products as $product)
            '{{ $product->id }}' : {
                'supplier': '{{ $product->companies()->first()->name }}',
                'purchase_price': {{ $product->price }}
            },
            @endforeach
        };

        if ($product.val())
        {
            $supplier.val(data[$product.val()].supplier);
            $purchase_price.val(data[$product.val()].purchase_price);
        }

        $product.on('change', function (e) {
            $this = $(this);
            $supplier.val(data[$this.val()].supplier);
            $purchase_price.val(data[$this.val()].purchase_price);
        });
    });
</script>
@endsection
