@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => 'management'])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3" style="min-height:624px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.management.account') }}">Personal Account</a></li>
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block d-flex flex-column justify-content-between">
                        <section class="col-auto d-flex justify-content-end align-items-baseline">
                            <a href="{{ route('company.management.bank.create') }}" class="btn btn-sm btn-outline-success">Register Bank Account</a>
                        </section>
                        <section class="col px-0 mt-3 table-sm table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>BANK ACCOUNT NAME</th>
                                    <th>BANK ACCOUNT NUMBER</th>
                                    <th>BANK CODE</th>
                                    <th>BANK NAME</th>

                                </tr>
                                </thead>
                                <tbody class="medium-small lh-1-2">
                                    {{--<tr>--}}
                                        {{--<td>-</td>--}}
                                        {{--<td>-</td>--}}
                                        {{--<td>-</td>--}}
                                    {{--</tr>--}}
                                </tbody>
                            </table>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection