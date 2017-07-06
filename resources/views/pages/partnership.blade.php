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
                        <p class="medium lh-1-5 mb-0">PARTNERSHIP</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('partnership.create') }}" class="btn btn-secondary">New</a>
                            </section>
                        </section>
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('partnership.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('partnership.sort.index') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by name or description" style="width:240px!important;">
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $partnerships->previousPageUrl() }}" class="btn btn-secondary {{ ($partnerships->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $partnerships->nextPageUrl() }}" class="btn btn-secondary {{ ($partnerships->hasMorePages() == true) ?: ' disabled' }}">Next</a>
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
                                <th>DESCRIPTION</th>
                                <th>CREATED DATE</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($partnerships as $partnership)
                                <tr>
                                    <td>
                                        {{ $partnership->id }}
                                    </td>
                                    <td>
                                        {{ $partnership->name }}
                                    </td>
                                    <td>
                                        {{ $partnership->description }}
                                    </td>
                                    <td>
                                        {{ $partnership->created_at->format('j F Y') }}
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                            <a href="{{ route('partnership.edit', [$partnership->id]) }}"
                                                class="btn btn-secondary py-0 small-caps">
                                                edit
                                            </a>
                                            <a href="{{ route('partnership.delete', [$partnership->id]) }}"
                                                onclick="event.preventDefault();document.getElementById('partnership-delete-{{$partnership->id}}').submit();"
                                                class="btn btn-secondary py-0 small-caps">
                                                delete
                                            </a>
                                            <form id="partnership-delete-{{$partnership->id}}" action="{{ route('partnership.delete', [$partnership->id]) }}" method="POST" class="sr-only">
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