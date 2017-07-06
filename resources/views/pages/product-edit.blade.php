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
                        <p class="medium lh-1-5 mb-0">PRODUCT</p>
                    </section>
                </section>
                <section class="col-sm-8 offset-sm-2 py-3">
                    @if (session('success'))
                        <section class="alert alert-success">{{ session('success') }}</section>
                        <br/>
                    @endif
                    @if (session('warning'))
                        <section class="alert alert-danger">{{ session('warning') }}</section>
                        <br/>
                    @endif

                    <h5>Update product</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>

                    <form method="post" action="{{ route('product.update', [$product->id]) }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <section class="card card-block p-5">
                            <h6 class="mb-0 medium-small text-warning">PRODUCT DATA</h6>
                            <section><hr/></section>
                            <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label for="name">Name</label>
                                <input id="name" name="name" class="form-control" value="{{ $product->name }}" type="text" aria-describedby="nameHelp">
                                @if ($errors->has('name'))<section class="form-control-feedback">{{ $errors->first('name') }}</section>@endif
                                <small class="form-text text-muted d-flex justify-content-between" id="nameHelp">Full product name. Max. 40 characters. <span class="text-grey">Required</span></small>
                            </fieldset>
                            <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label for="price">Default Price</label>
                                <input id="price" name="price" class="form-control" value="{{ $product->price }}" type="number" aria-describedby="priceHelp">
                                @if ($errors->has('price'))<section class="form-control-feedback">{{ $errors->first('price') }}</section>@endif
                                <small class="form-text text-muted d-flex justify-content-between" id="priceHelp">Product price. Min. 0. <span class="text-grey">Required</span></small>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" rows="5" name="description" class="form-control" aria-describedby="descriptionHelp">{{ $product->description }}</textarea>
                                @if ($errors->has('description'))<section class="form-control-feedback">{{ $errors->first('description') }}</section>@endif
                                <small class="form-text text-muted d-flex justify-content-between" id="descriptionHelp">Description about this product. Max. 120 characters. <span class="text-grey">Optional</span></small>
                            </fieldset>
                        </section>
                        <section class="form-group mt-4">
                            <a href="{{ route('product.index') }}" class="btn btn-secondary">Back to product</a>
                            <button type="submit" class="btn btn-primary float-right" role="button">Save product</button>
                        </section>
                    </form>
                </section>
            </section>

        </section>
    </article>
@endsection