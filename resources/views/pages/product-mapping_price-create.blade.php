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
                        <p class="medium lh-1-5 mb-0">MAPPING PRODUCT</p>
                    </section>
                </section>
                <section class="col-sm-6 offset-sm-3 p-5">
                    @if (session('success'))
                        <section class="alert alert-success">{{ session('success') }}</section>
                    @endif
                    @if (session('warning'))
                        <section class="alert alert-danger">{{ session('warning') }}</section>
                    @endif
                    <h5>Create new product mapping</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>
                    <form method="post" action="{{ route('product.mapping_price.store') }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        <fieldset class="form-group{{ $errors->has('account_id') ? ' has-danger' : '' }}">
                            <label for="account_id">Seller</label>
                            <select id="account_id" name="account_id[]" class="form-control w-100" multiple>
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
                        <fieldset class="form-group">
                            <label>Default Price</label>
                            <input id="default_price" class="form-control" type="number" disabled />
                            <small class="form-text text-muted d-flex justify-content-between">
                                Numeric. Minimum price to sell. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label for="price">Price for Seller</label>
                            <input id="price" name="price" class="form-control" value="{{ old('price')  }}" type="number" />
                            @if ($errors->has('price'))
                                <section class="form-control-feedback">{{ $errors->first('price') }}</section>
                            @endif
                            <small class="form-text text-muted d-flex justify-content-between">
                                Numeric. Min. default price for selected product. <span class="text-grey">Required</span>
                            </small>
                        </fieldset>
                        <a href="{{ route('product.mapping_price.index') }}" tabindex="-1" class="btn btn-secondary small-caps">cancel</a>
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
    $default_price = $('#default_price');
    $price = $('#price');

    @if(count(old('account_id')) > 0)
    $accounts.multiselect('select', {!! json_encode(old('account_id')) !!});
    @endif

    $product.on('change', function() {
        $.getJSON('{{ route('api.product.show', [null]) }}/' + $product.val(), function (data) {
            $default_price.val(data.product.price);
            $price.val(data.product.price);
            $price.attr('min', data.product.price);
        });
    });
});
</script>
@endsection