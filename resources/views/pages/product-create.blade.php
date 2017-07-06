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
                <section class="col-sm-6 offset-sm-3 p-5">
                    @if (session('success'))
                        <section class="alert alert-success">{{ session('success') }}</section>
                    @endif
                    @if (session('warning'))
                        <section class="alert alert-danger">{{ session('warning') }}</section>
                    @endif
                    <h5>Create new product</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    <form method="post" action="{{ route('product.store') }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        <fieldset class="form-group">
                            <label for="name">Name</label>
                            <input id="name" name="name" class="form-control" value="{{ old('name')  }}" type="text" />
                            @if ($errors->has('name'))
                                <section class="form-control-feedback">{{ $errors->first('name') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Alphanumeric, unique, max. 40 characters, eg. `Transfer`. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="price">Default Price</label>
                            <input id="price" name="price" class="form-control" value="{{ old('price')  }}" type="number" />
                            @if ($errors->has('price'))
                                <section class="form-control-feedback">{{ $errors->first('price') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Numeric, min. 0. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control"
                            	id="description"
                            	name="description"
                            	rows="3">
                            	{{ old('description') }}	
                        	</textarea>
                            @if ($errors->has('description'))
                                <section class="form-control-feedback">{{ $errors->first('description') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Alphanumeric, max. 120 characters. <span class="text-grey">Optional</span>
                            </small>
                        </fieldset>
                        <a href="{{ route('product.index') }}" tabindex="-1" class="btn btn-secondary small-caps">cancel</a>
                        <button type="submit" class="btn btn-primary float-right small-caps" role="button">save</button>
                        <br>
                        <br>
                    </form>
                </section>
            </section>
        </section>
    </article>
@endsection