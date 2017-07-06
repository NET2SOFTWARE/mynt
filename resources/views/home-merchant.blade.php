@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => ''])@endcomponent
            <section class="col-md-9 p-3">
                <h4 class="mb-4 medium-small d-flex flex-row justify-content-between align-items-baseline">
                    HOME
                </h4>
                <section class="card">
                    <section class="card-header medium-small py-2">Home</section>
                    <section class="card-block medium">
                        
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection