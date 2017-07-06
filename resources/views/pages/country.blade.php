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
                        <p class="medium lh-1-5 mb-0">Country</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('country.create') }}" class="btn btn-secondary">New</a>
                            </section>
                        </section>
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('country.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('country.sort.index') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by country name, ISO or currency" style="width:240px!important;">
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $countries->previousPageUrl() }}" class="btn btn-secondary {{ ($countries->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $countries->nextPageUrl() }}" class="btn btn-secondary {{ ($countries->hasMorePages() == true) ?: ' disabled' }}">Next</a>
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
                                <th>ISO</th>
                                <th>CURRENCY</th>
                                <th>CREATED DATE</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($countries as $country)
                                <tr>
                                    <td>
                                        {{ $country->id }}
                                    </td>
                                    <td>
                                        {{ $country->name }}
                                    </td>
                                    <td>
                                        {{ $country->iso }}
                                    </td>
                                    <td>
                                        {{ $country->currency }}
                                    </td>
                                    <td>
                                        {{ $country->created_at->format('j F Y') }}
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                            <a href="{{ route('country.edit', [$country->id]) }}"
                                                class="btn btn-secondary py-0 small-caps">
                                                edit
                                            </a>
                                            <a href="{{ route('country.delete', [$country->id]) }}"
                                                onclick="event.preventDefault();document.getElementById('country-delete-{{$country->id}}').submit();"
                                                class="btn btn-secondary py-0 small-caps">
                                                delete
                                            </a>
                                            <form id="country-delete-{{$country->id}}" action="{{ route('country.delete', [$country->id]) }}" method="POST" class="sr-only">
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
                </transition>
            </section>

        </section>
    </article>
@endsection