@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => 'report'])@endcomponent
                <section class="col-md-9">
                    <section class="card mt-3" style="min-height:620px">
                        <section class="card-header">
                            <ul class="nav nav-tabs card-header-tabs medium-small">
                                <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.report') }}">Overview</a></li>
                            </ul>
                        </section>
                        <section class="card-block">

                        </section>
                    </section>
                </section>
        </section>
    </article>
@endsection