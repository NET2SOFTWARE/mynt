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
                        <p class="medium lh-1-5 mb-0">PRODUCT PURCHASE</p>
                    </section>
                </section>
                <section class="col-sm-6 offset-sm-3 p-5">
                    @if (session('success'))
                        <section class="alert alert-success">{{ session('success') }}</section>
                    @endif
                    @if (session('warning'))
                        <section class="alert alert-danger">{{ session('warning') }}</section>
                    @endif
                    <h5>Create new product purchase</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    <form method="post" action="{{ route('product.purchase.store') }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}

                        <fieldset class="form-group">
                            <label for="product_id">Product</label>
                            <select id="product_id" name="product_id" class="custom-select w-100" value="{{ old('product_id') }}">
                                <option selected disabled>Choose one product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ (old('product_id') == $product->id) ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('product_id'))
                                <section class="form-control-feedback">{{ $errors->first('product_id') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Select a product.<span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="company_id">Supplier</label>
                            <select id="company_id" name="company_id" class="custom-select w-100" value="{{ old('company_id') }}">
                                <option selected disabled>Choose one supplier</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ (old('company_id') == $company->id) ? 'selected' : '' }}>{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('company_id'))
                                <section class="form-control-feedback">{{ $errors->first('company_id') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Select a supplier.<span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="price">Purchase Price</label>
                            <input id="price" name="price" class="form-control" value="{{ old('price')  }}" type="number" />
                            @if ($errors->has('price'))
                                <section class="form-control-feedback">{{ $errors->first('price') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Numeric, min. 0. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <a href="{{ route('product.purchase.index') }}" tabindex="-1" class="btn btn-secondary small-caps">back</a>
                        <button type="submit" class="btn btn-primary float-right small-caps" role="button">save</button>
                        <br>
                        <br>
                    </form>
                </section>
            </section>
        </section>
    </article>
@endsection