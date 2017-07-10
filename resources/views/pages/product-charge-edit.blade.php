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
                        <p class="medium lh-1-5 mb-0">PRODUCT CHARGE</p>
                    </section>
                </section>
                <section class="col-sm-6 offset-sm-3 p-5">
                    @if (session('success'))
                        <section class="alert alert-success">{{ session('success') }}</section>
                    @endif
                    @if (session('warning'))
                        <section class="alert alert-danger">{{ session('warning') }}</section>
                    @endif
                    <h5>Set product charge</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    <form method="post" action="{{ route('product.charge.update', [$data->id]) }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <fieldset class="form-group">
                            <label>Product</label>
                            <input id="product" class="form-control" type="text" value="{{ $data->product_purchase()->first()->products()->first()->name }}" disabled>
                            <small class="form-text text-muted d-flex justify-content-between">
                                Product to be charged. <span class="text-grey">Info</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Merchant</label>
                            <input id="merchant" class="form-control" type="text" value="{{ $data->merchants()->first()->name }}" disabled>
                            <small class="form-text text-muted d-flex justify-content-between">
                                Seller of selected product. <span class="text-grey">Info</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Sales Price</label>
                            <input id="price" class="form-control" type="number" value="{{ $data->price }}" disabled>
                            <small class="form-text text-muted d-flex justify-content-between">
                                Product sales price on selected merchant. <span class="text-grey">Info</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="charge">Charge</label>
                            <input id="charge" name="charge" class="form-control" value="{{ $data->product_charge()->first() ? $data->product_charge()->first()->charge : 0 }}" type="number" />
                            @if ($errors->has('charge'))
                                <section class="form-control-feedback">{{ $errors->first('charge') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Numeric, min. 0. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <a href="{{ route('product.charge.index') }}" tabindex="-1" class="btn btn-secondary small-caps">back</a>
                        <button type="submit" class="btn btn-primary float-right small-caps" role="button">save</button>
                        <br>
                        <br>
                    </form>
                </section>
            </section>
        </section>
    </article>
@endsection
