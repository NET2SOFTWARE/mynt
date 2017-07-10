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
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('product.charge.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('product.charge.sort') }}" method="POST" class="input-group input-group-sm ml-3">
                            {{ csrf_field() }}
                            <input id="search" name="search" type="search" class="form-control" placeholder="Search ..." style="max-width:240px!important;width:240px!important;">
                            <span class="input-group-btn">
                                <button ty class="btn btn-secondary" type="submit">Find</button>
                            </span>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $rows->previousPageUrl() }}" class="btn btn-secondary {{ ($rows->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $rows->nextPageUrl() }}" class="btn btn-secondary {{ ($rows->previousPageUrl() != null) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                                <tr class="medium">
                                    <th>FEE STATUS</th>
                                    <th>PRODUCT NAME</th>
                                    <th>SUPPLIER</th>
                                    <th>MERCHANT</th>
                                    <th>SALES PRICE</th>
                                    <th>CHARGE</th>
                                    <th>CREATED DATE</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $row)
                                <tr>
                                    <td>
                                        @if ($row->product_charge()->count() > 0)
                                            @if ($row->product_charge()->first()->product_fees()->sum('fee') < $row->product_charge()->first()->charge)
                                                <span class="small-caps badge badge-danger">incomplete</span>
                                            @elseif ($row->product_charge()->first()->product_fees()->sum('fee') > $row->product_charge()->first()->charge)
                                                <span class="small-caps badge badge-warning">overlimit</span>
                                            @else
                                                <span class="small-caps badge badge-success">complete</span>
                                            @endif
                                        @else
                                            <span class="small-caps badge badge-primary">no charge</span>
                                        @endif
                                    </td>
                                    <td>{{ $row->product_purchase()->first()->products()->first()->name }}</td>
                                    <td>{{ $row->product_purchase()->first()->companies()->first()->name }}</td>
                                    <td>{{ $row->merchants()->first()->name }}</td>
                                    <td>{{ sprintf('Rp %s', number_format($row->price)) }}</td>
                                    <td>
                                        @if ($row->product_charge()->count() > 0)
                                            {{ sprintf('Rp %s', number_format($row->product_charge()->first()->charge )) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $row->created_at->format('j F Y') }}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                            <a href="{{ route('product.charge.edit', [$row->id]) }}"
                                                class="btn btn-secondary py-0 small-caps text-center"
                                                style="width:100px">
                                                @if ($row->product_charge()->count() > 0)
                                                    edit charge
                                                @else
                                                    set charge
                                                @endif
                                            </a>
                                            <a href="#"
                                                onclick="event.preventDefault();document.getElementById('product-delete-{{$row->id}}').submit();"
                                                class="btn btn-secondary py-0 small-caps {{ $row->product_charge()->count() < 1 ? 'disabled' : '' }}">
                                                remove charge
                                            </a>
                                            <form id="product-delete-{{$row->id}}"
                                                action="{{ route('product.charge.delete', [$row->product_charge()->first() ? $row->product_charge()->first()->id : 0]) }}"
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