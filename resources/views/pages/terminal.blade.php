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
                        <p class="medium lh-1-5 mb-0">TERMINAL</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('terminal.create') }}" class="btn btn-secondary">New</a>
                            </section>
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('terminal.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('terminal.sort') }}" method="POST" class="input-group input-group-sm ml-3">
                            {{ csrf_field() }}
                            <input id="search" name="search" type="search" class="form-control" placeholder="Search by code or merchant name" style="max-width:240px!important;width:240px!important;">
                            <span class="input-group-btn">
                                <button ty class="btn btn-secondary" type="submit">Find</button>
                            </span>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $terminals->previousPageUrl() }}" class="btn btn-secondary {{ ($terminals->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $terminals->nextPageUrl() }}" class="btn btn-secondary {{ ($terminals->previousPageUrl() != null) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                <th>CODE</th>
                                <th>MERCHANT</th>
                                <th>CREATED DATE</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($terminals as $terminal)
                                <tr>
                                    <td>{{ $terminal->code }}</td>
                                    <td>
                                        <span class="badge badge-default small-caps">
                                            {{ strtolower($terminal->merchants()->first()['name']) }}
                                        </span>
                                    </td>
                                    <td>{{ $terminal->created_at->format('j F Y') }}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                            <a href="{{ route('terminal.edit', [$terminal->id]) }}"
                                                class="btn btn-secondary py-0 small-caps">
                                                edit
                                            </a>
                                            <a href="#"
                                                onclick="event.preventDefault();document.getElementById('terminal-delete-{{$terminal->id}}').submit();"
                                                class="btn btn-secondary py-0 small-caps">
                                                delete
                                            </a>
                                            <form id="terminal-delete-{{$terminal->id}}"
                                                action="{{ route('terminal.delete', [$terminal->id]) }}"
                                                method="POST" class="sr-only">
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