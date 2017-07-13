@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => 'management'])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3" style="min-height:620px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.management.account') }}">Personal Account</a></li>
                            <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="clearfix d-flex justify-content-end align-items-baseline">
                            <a href="{{ route('merchant.management.bank.create') }}" class="btn btn-sm btn-outline-success">Register Bank Account</a>
                        </section>
                        <hr class="clearfix"/>
                        <section class="list-group list-group-flush mt-3">
                            {{--<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">--}}
                                {{--<section class="d-flex w-100 justify-content-between">--}}
                                    {{--<h6 class="mb-1">List group item heading</h6>--}}
                                    {{--<small>3 days ago</small>--}}
                                {{--</section>--}}
                                {{--<p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>--}}
                                {{--<small>Donec id elit non mi porta.</small>--}}
                            {{--</a>--}}
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
