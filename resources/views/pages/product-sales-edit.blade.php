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
                    <form method="post" action="{{ route('product.sales.update', [$data->id]) }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <fieldset class="form-group">
                            <label>Product</label>
                            <input id="product" class="form-control" type="text" disabled value="{{ $data->product_purchase->products->name }}">
                            <small class="form-text text-muted d-flex justify-content-between">
                                Product sales name. <span class="text-grey">Info</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Supplier</label>
                            <input id="supplier" class="form-control" type="text" disabled value="{{ $data->product_purchase->companies->name }}">
                            <small class="form-text text-muted d-flex justify-content-between">
                                Product supplier. <span class="text-grey">Info</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Purchase Price</label>
                            <input id="product_purchase" class="form-control" type="number" disabled value="{{ $data->product_purchase->price }}">
                            <small class="form-text text-muted d-flex justify-content-between">
                                Product purchase price from selected supplier. <span class="text-grey">Info</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Merchant</label>
                            <input id="merchant" class="form-control" type="text" disabled value="{{ $data->merchants->name }}">
                            <small class="form-text text-muted d-flex justify-content-between">
                                Product seller. <span class="text-grey">Info</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="price">Sales Price</label>
                            <input id="price" name="price" class="form-control" value="{{ $data->price }}" type="number" min="1">
                            @if ($errors->has('price'))
                                <section class="form-control-feedback">{{ $errors->first('price') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Numeric, value must be greater than 0. <span class="text-grey">Required</span>
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
