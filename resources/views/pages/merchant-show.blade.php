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
            <section class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                <section class="row">
                    <section class="col-sm-4 col-md-4 py-3">
                        <section class="media medium">
                            <img class="d-flex mr-3" src="{{ asset('img/merchant/'. $merchant->photo) }}" alt="{{ $merchant->name }}" width="64" height="64">
                            <section class="media-body">
                                <p class="mt-0 mb-1">{{ $merchant->name }}</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item p-0 justify-content-between">Acc. number <span>{{ $merchant->accounts->first()['number'] }}</span></li>
                                    <li class="list-group-item p-0 justify-content-between">Phone <span>{{ $merchant->phone }}</span></li>
                                </ul>
                            </section>
                        </section>
                    </section>
                    <section class="col-sm-8"></section>
                    <section class="col-sm-12 col-md-12">
                        <section class="card mb-3">
                            <section class="card-header medium py-2">
                                <span>Merchant</span>
                            </section>
                            <section class="card-block">
                                <h6 class="small text-muted text-uppercase mb-2">ABOUT</h6>
                                <hr class="mt-0 clearfix"/>
                                <section class="card-block">
                                    <form accept-charset="utf-8" role="form">
                                        <section class="form-group row">
                                            <label for="name" class="col-3 col-form-label">Name</label>
                                            <section class="col-9">
                                                <input class="form-control" type="text" id="name" name="name" value="{{ $merchant->name }}">
                                            </section>
                                        </section>
                                        <section class="form-group row">
                                            <label for="name" class="col-3 col-form-label">Email</label>
                                            <section class="col-9">
                                                <input class="form-control" type="email" id="email" name="email" value="{{ $merchant->email }}">
                                            </section>
                                        </section>
                                    </form>
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection