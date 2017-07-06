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
                        <p class="medium lh-1-5 mb-0">ALL SERVICE</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('service.create') }}" class="btn btn-secondary">New</a>
                            </section>
                        </section>
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('service.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('service.sort.index') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by name" style="width:240px!important;">
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $services->previousPageUrl() }}" class="btn btn-secondary {{ ($services->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $services->nextPageUrl() }}" class="btn btn-secondary {{ ($services->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                <th>ID</th>
                                <th>NAME</th>
                                <th>DATE</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{ $service->id }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->created_at->format('j F Y') }}</td>
                                    <td class="text-right">
                                        <section class="btn-group btn-group-sm">
                                            <a class="btn btn-secondary small-caps py-0" href="{{ route('service.edit', [$service->id]) }}">edit</a>
                                            <a class="btn btn-secondary small-caps py-0" href="{{ route('service.delete', [$service->id]) }}" onclick="event.preventDefault();document.getElementById('service-delete-{{ $service->id }}').submit();">delete</a>
                                            <form id="service-delete-{{ $service->id }}" action="{{ route('service.delete', [$service->id]) }}" method="POST" class="sr-only">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </section>
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