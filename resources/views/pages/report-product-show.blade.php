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
                        <p class="medium lh-1-5 mb-0">REPORT PRODUCT</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="mr-2">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('report.product.index') }}" class="btn btn-secondary">Back</a>
                            </section>
                        </section>
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                {{-- <a href="{{ route('report.product.print') }}" class="btn btn-secondary">Print</a> --}}
                                <a href="{{ route('report.product.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                    </section>
                </section>
                {{-- Chart : start --}}
                <div class="container p-0">
                    <div class="card m-3">
                        <div class="row p-0" style="min-height:200px;">
                            <div class="col-md-8">
                                <table class="table small mb-0 h-100" style="border-right: 1px solid #e9eaec;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                <p class="lead m-0 p-2">
                                                    Product by Supplier
                                                </p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['companies'] as $company)
                                        <tr>
                                            <td class="p-3"><strong>{{ $company->name  }}</strong></td>
                                            <td class="p-3 text-right">{{ number_format($company->product_purchase->count()) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="p-3 text-muted"><strong>Total Products</strong></td>
                                            <td class="p-3 text-right text-muted"><strong>{{ number_format($data['products']->count()) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-4" style="overflow: hidden;">
                                <div id="chart-1" style="position:absolute; width: auto; left: 0; right: 20px; top: 50%; margin-top: -25%;"></div>
                                {!! Lava::render('PieChart', 'Products', 'chart-1') !!}
                            </div>
                        </div>
                    </div>

                    <div class="card m-3">
                        <div class="row p-0" style="min-height:200px;">
                            <div class="col-md-8">
                                <table class="table small mb-0 h-100" style="border-right: 1px solid #e9eaec;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                <p class="lead m-0 p-2">
                                                    Fees
                                                </p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['products'] as $product)
                                        <tr>
                                            <td class="p-3"><strong>{{ $product->name  }}</strong></td>
                                            <td class="p-3 text-right">{{ sprintf('Rp %s', number_format(0)) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="p-3 text-muted"><strong>Total Fees</strong></td>
                                            <td class="p-3 text-right text-muted"><strong>{{ sprintf('Rp %s', number_format(0)) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-4" style="overflow: hidden;">
                                <div id="chart-2" style="position:absolute; width: auto; left: 0; right: 20px; top: 50%; margin-top: -25%;"></div>
                                {!! Lava::render('PieChart', 'Fees', 'chart-2') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </article>
@endsection
