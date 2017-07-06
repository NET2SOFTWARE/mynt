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
							<a href="{{ route('mapping_fee.all') }}" class="btn btn-sm btn-secondary small-caps mr-1 py-0">
								<span class="glyphicon glyphicon-arrow-left"></span> back
							</a>
                        	MANAGE FEES
                        </p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
	                    @if ($mapping_charge->amount - $mapping_fees->sum('amount') > 0)
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('mapping_fee.create', [$mapping_charge->id]) }}" class="btn btn-secondary">New</a>
                            </section>
                        </section>
                        @endif
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('mapping_fee.index', [$mapping_charge->id]) }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="#" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by fee receiver type, name or account" style="width:240px!important;" />
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $mapping_fees->previousPageUrl() }}" class="btn btn-secondary {{ ($mapping_fees->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $mapping_fees->nextPageUrl() }}" class="btn btn-secondary {{ ($mapping_fees->hasMorePages() == true) ?: ' disabled' }}">Next</a>
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
                							<b>MAPPING CHARGE INFO</b>
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
											@if ($mapping_charge->amount - $mapping_fees->sum('amount') == 0)
											<span class="badge badge-info">complete</span>
											@else
											<span class="badge badge-danger">incomplete</span>
											@endif
										</td>
										<td class="px-3 py-2 small-caps">service</td>
										<td class="px-3 py-2 small-caps"><code>{{ strtoupper($mapping_charge->service()->first()['name']) }}</code></td>
									</tr>
									<tr>
										<td class="px-3 py-2 small-caps">charge</td>
										<td class="px-3 py-2 small-caps" style="border-right: 1px solid #e9eaec;"><span class="badge badge-default">{{ strtolower($mapping_charge->charge()->first()['name']) }}</span></td>
										<td class="px-3 py-2 small-caps">
											{{ $mapping_charge->account_type()->first()['name'] }}
										</td>
										<td class="px-3 py-2 small-caps">
											<span class="badge badge-default">
												{{ strtolower($mapping_charge->account()->first()->companies()->first()['name']) }}
												{{ strtolower($mapping_charge->account()->first()->merchants()->first()['name']) }}
											</span>
										</td>
									</tr>
									<tr>
										<td class="px-3 py-2 small-caps">amount</td>
										<td class="px-3 py-2" style="border-right: 1px solid #e9eaec;">{{ sprintf('Rp %s', number_format($mapping_charge->amount)) }}</td>
										<td class="px-3 py-2 small-caps">remaining amount</td>
										<td class="px-3 py-2">{{ sprintf('Rp %s', number_format($mapping_charge->amount - $mapping_fees->sum('amount'))) }}</td>
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
                        @foreach($mapping_fees as $fee)
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
								<td>{{ sprintf('Rp %s', number_format($fee->amount)) }}</td>
								<td>{{ $fee->created_at->format('j F Y') }}</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                        <a href="{{ route('mapping_fee.edit', [$mapping_charge->id, $fee->id]) }}"
                                            class="btn btn-secondary py-0 small-caps">
                                            edit
                                        </a>
                                        <a href="#" 
                                        	class="btn btn-secondary py-0 small-caps"
                                        	onclick="event.preventDefault();document.getElementById('mapping_fee-delete-{{ $fee->id }}').submit();">
                                        	delete
                                        </a>
                                        <form id="mapping_fee-delete-{{ $fee->id }}" action="{{ route('mapping_fee.delete', [$fee->id]) }}" method="POST" class="sr-only">
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