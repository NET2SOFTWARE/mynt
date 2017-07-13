@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => ''])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3" style="min-height:624px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.profile') }}]">Profile</a></li>
                        </ul>
                    </section>
                    <section class="card-block">

                    </section>
                    <section class="card-footer">
                        <small class="text-muted">Note : If you have a trouble, please contact our costumer service.</small>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
