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
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('mapping_product.create') }}" class="btn btn-secondary">New</a>
                            </section>
                        </section>
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('mapping_product.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('mapping_product.sort.index') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by charge, service or implement type" style="width:240px!important;">
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $mapping_products->previousPageUrl() }}" class="btn btn-secondary {{ ($mapping_products->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $mapping_products->nextPageUrl() }}" class="btn btn-secondary {{ ($mapping_products->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3" style="overflow: visible;">
                        <table class="table">
                            <thead>
                                <tr class="medium">
                                    <th>NAME</th>
                                    <th>MAPPED PRICE</th>
                                    <th>TAX</th>
                                    <th>FEE</th>
                                    <th>TOTAL PRICE</th>
                                    <th>FOR</th>
                                    <th>CREATED DATE</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mapping_products as $mapping_product)
                                <tr>
                                    <td>{{ $mapping_product->product()->first()['name'] }}</td>
                                    <td>
                                        @if (count($mapping_product->product()->first()->companies()) > 0)
                                        {{ sprintf('Rp %s', number_format($mapping_product->product()->first()->companies()->first()->pivot->price)) }}
                                        @else
                                        {{ sprintf('Rp %s', number_format($mapping_product->product()->first()->merchants()->first()->pivot->price)) }}
                                        @endif
                                    </td>
                                    <td>{{ sprintf('Rp %s', number_format($mapping_product->tax)) }}</td>
                                    <td>{{ sprintf('Rp %s', number_format($mapping_product->fee)) }}</td>
                                    <td>
                                        @if (count($mapping_product->product()->first()->companies()) > 0)
                                        {{ sprintf('Rp %s', number_format($mapping_product->product()->first()->companies()->first()->pivot->price + $mapping_product->tax + $mapping_product->fee)) }}
                                        @else
                                        {{ sprintf('Rp %s', number_format($mapping_product->product()->first()->merchants()->first()->pivot->price + $mapping_product->tax + $mapping_product->fee)) }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-default small-caps">
                                        {{ count($mapping_product->account()->first()->companies()) > 0 ? 'company' : 'merchant' }}
                                        </span> 
                                        {{ $mapping_product->account()->first()->companies()->first()['name'] }}
                                        {{ $mapping_product->account()->first()->merchants()->first()['name'] }}
                                    </td>
                                    <td>{{ $mapping_product->created_at->format('j F Y') }}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                            <a href="{{ route('mapping_product.edit', [$mapping_product->id]) }}"
                                                class="btn btn-secondary py-0 small-caps">
                                                edit
                                            </a>
                                            <a href="#"
                                                onclick="event.preventDefault();document.getElementById('mapping_product-delete-{{$mapping_product->id}}').submit();"
                                                class="btn btn-secondary py-0 small-caps">
                                                delete
                                            </a>
                                            <form id="mapping_product-delete-{{$mapping_product->id}}"
                                                action="{{ route('mapping_product.delete', [$mapping_product->id]) }}"
                                                method="POST" class="sr-only">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                </transition>
            </section>
        </section>
    </article>
@endsection