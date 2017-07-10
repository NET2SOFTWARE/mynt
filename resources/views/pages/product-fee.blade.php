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
                        <p class="medium lh-1-5 mb-0">
							<a href="{{ route('product.fee.all') }}" class="btn btn-sm btn-secondary small-caps mr-1 py-0">
								<span class="glyphicon glyphicon-arrow-left"></span> back
							</a>
                        	MANAGE PRODUCT FEES
                        </p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
	                    @if ($product->charge - $rows->sum('fee') > 0)
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('product.fee.create', [$product->id]) }}" class="btn btn-secondary">New</a>
                            </section>
                        </section>
                        @endif
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('product.fee.index', [$product->id]) }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="#" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search ..." style="width:240px!important;" />
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $rows->previousPageUrl() }}" class="btn btn-secondary {{ ($rows->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $rows->nextPageUrl() }}" class="btn btn-secondary {{ ($rows->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <section class="card mx-3 mt-3 mb-0">
                	<div class="card-block p-0">
                		<section class="table-sm table-responsive medium">
                			<table class="table mb-0">
                				<thead>
                					<tr>
                						<th colspan="4" class="px-3 py-2 text-white rounded-top" style="background: rgba(0,0,0,.7)">
                							<b>MAPPING PRODUCT CHARGE INFO</b>
                						</th>
                					</tr>
                				</thead>
                				<tbody>
	                				<col width="180px">
	                				<col>
	                				<col width="180px">
									<tr>
										<td class="px-3 py-2 small-caps">fee sharing status</td>
										<td class="px-3 py-2 small-caps" style="border-right: 1px solid #e9eaec;">
											@if ($product->charge - $rows->sum('fee') == 0)
											<span class="badge badge-info">complete</span>
											@elseif ($product->charge > $rows->sum('fee'))
                                            <span class="badge badge-danger">incomplete</span>
                                            @else
											<span class="badge badge-warning">overlimit</span>
											@endif
										</td>
										<td class="px-3 py-2 small-caps">product name</td>
										<td class="px-3 py-2">{{ $product->product_sales()->first()->product_purchase()->first()->products()->first()->name }}</td>
									</tr>
                                    <tr>
                                        <td class="px-3 py-2 small-caps">supplier</td>
                                        <td class="px-3 py-2" style="border-right: 1px solid #e9eaec;">
                                            <span class="badge badge-default">
                                                {{ $product->product_sales()->first()->product_purchase()->first()->companies()->first()->name }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 small-caps">
                                            purchase price
                                        </td>
                                        <td class="px-3 py-2 small-caps">
                                            {{ sprintf('Rp %s', number_format($product->product_sales()->first()->product_purchase()->first()->price)) }}
                                        </td>
                                    </tr>
									<tr>
										<td class="px-3 py-2 small-caps">merchant</td>
										<td class="px-3 py-2" style="border-right: 1px solid #e9eaec;">
											<span class="badge badge-default">
                                                {{ $product->product_sales()->first()->merchants()->first()->name }}
											</span>
                                        </td>
                                        <td class="px-3 py-2 small-caps">
                                            sales price
                                        </td>
                                        <td class="px-3 py-2 small-caps">
                                            {{ sprintf('Rp %s', number_format($product->product_sales()->first()->price)) }}
										</td>
									</tr>
									<tr>
										<td class="px-3 py-2 small-caps">charge amount</td>
										<td class="px-3 py-2" style="border-right: 1px solid #e9eaec;">
                                            {{ sprintf('Rp %s', number_format($product->charge)) }}
                                        </td>
										<td class="px-3 py-2 small-caps">remaining amount</td>
										<td class="px-3 py-2">
                                            {{ sprintf('Rp %s', number_format($product->charge - $rows->sum('fee'))) }}
                                        </td>
									</tr>
                				</tbody>
							</table>
                		</section>
                	</div>
                </section>
                <section class="table-sm table-responsive medium p-3">
                    <table class="table">
                        <thead>
	                        <tr class="medium">
								<th>FEE RECEIVER TYPE</th>
								<th>FEE RECEIVER NAME</th>
								<th>FEE RECEIVER ACCOUNT</th>
								<th>FEE AMOUNT</th>
								<th>CREATED DATE</th>
	                            <th></th>
	                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $fee)
                            <tr>
								<td>
									<span class="badge badge-default small-caps">
										{{ $fee->account()->first()->account_type()->first()['name'] }}
									</span>
								</td>
								<td>
									{{ $fee->account()->first()->companies()->first()['name'] }}
									{{ $fee->account()->first()->merchants()->first()['name'] }}
								</td>
								<td>{{ $fee->account()->first()['number'] }}</td>
								<td>{{ sprintf('Rp %s', number_format($fee->fee)) }}</td>
								<td>{{ $fee->created_at->format('j F Y') }}</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                        {{-- <a href="{{ route('product.fee.edit', [$product->id, $fee->id]) }}"
                                            class="btn btn-secondary py-0 small-caps">
                                            edit
                                        </a> --}}
                                        <a href="#" 
                                        	class="btn btn-secondary py-0 small-caps"
                                        	onclick="event.preventDefault();document.getElementById('product.fee-delete-{{ $fee->id }}').submit();">
                                        	delete
                                        </a>
                                        <form id="product.fee-delete-{{ $fee->id }}" action="{{ route('product.fee.delete', [$product->id, $fee->id]) }}" method="POST" class="sr-only">
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
            </section>
        </section>
    </article>
@endsection