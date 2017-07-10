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
                        <br/>
                    @endif
                    @if (session('warning'))
                        <section class="alert alert-danger">{{ session('warning') }}</section>
                        <br/>
                    @endif

                    <h5>Update product purchase</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>

                    <form method="post" action="{{ route('product.purchase.update', [$data->id]) }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <fieldset class="form-group">
                            <label>Product</label>
                            <input class="form-control" value="{{ $data->products()->first()->name }}" type="text" disabled>
                            <small class="form-text text-muted d-flex justify-content-between">
                                Full product name. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Supplier</label>
                            <input class="form-control" value="{{ $data->companies()->first()->name }}" type="text" disabled>
                            <small class="form-text text-muted d-flex justify-content-between">
                                Full supplier name. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="price">Purchase Price</label>
                            <input id="price" name="price" class="form-control" value="{{ $data->price }}" type="number">
                            @if ($errors->has('price'))
                                <section class="form-control-feedback">{{ $errors->first('price') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Product purchase price. Value must be greater than 0. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>

                        <section class="form-group mt-4">
                            <a href="{{ route('product.purchase.index') }}" class="btn btn-secondary small-caps">back</a>
                            <button type="submit" class="btn btn-primary float-right small-caps" role="button">save</button>
                        </section>
                    </form>
                </section>
            </section>

        </section>
    </article>
@endsection