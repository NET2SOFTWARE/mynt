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
                        <p class="medium lh-1-5 mb-0">MAPPING CHARGE</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('mapping_charge.create') }}" class="btn btn-secondary">New</a>
                            </section>
                        </section>
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('mapping_charge.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('mapping_charge.sort.index') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by charge, service or implement type" style="width:240px!important;">
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $mapping_charges->previousPageUrl() }}" class="btn btn-secondary {{ ($mapping_charges->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $mapping_charges->nextPageUrl() }}" class="btn btn-secondary {{ ($mapping_charges->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3" style="overflow: visible;">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                {{-- <th>FEE SHARING STATUS</th> --}}
                                <th>SERVICE</th>
                                <th>CHARGE</th>
                                <th>IMPLEMENT TO</th>
                                <th>AMOUNT</th>
                                <th>CREATED DATE</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mapping_charges as $mapping_charge)
                                <tr>
                                    {{-- <td>
                                        <span class="badge badge-{{ $mapping_charge->amount - $mapping_charge->mapping_fee()->sum('amount') == 0 ? 'info' : 'danger' }} small-caps">
                                            {{ $mapping_charge->amount - $mapping_charge->mapping_fee()->sum('amount') == 0 ? 'complete' : 'incomplete' }}
                                        </span>
                                    </td> --}}
                                    <td>
                                        <span class="badge badge-default small-caps">{{ strtolower($mapping_charge->service()->first()['name']) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-default small-caps">{{ strtolower($mapping_charge->charge()->first()['name']) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-default small-caps" style="width: 80px;">{{ $mapping_charge->account_type()->first()['name'] }}</span>
                                        @if ($mapping_charge->account_type()->first()['name'] == 'company')
                                            {{ $mapping_charge->account()->first()->companies()->first()['name'] }}
                                        @else
                                            {{ $mapping_charge->account()->first()->merchants()->first()['name'] }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ sprintf('Rp %s', number_format($mapping_charge->amount)) }}
                                    </td>
                                    <td>{{ $mapping_charge->created_at->format('j F Y') }}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                            <a class="btn btn-secondary py-0 small-caps" href="{{ route('mapping_charge.edit', [$mapping_charge->id]) }}">edit</a>
                                            <a class="btn btn-secondary py-0 small-caps" href="{{ route('mapping_charge.delete', [$mapping_charge->id]) }}" onclick="event.preventDefault();document.getElementById('mapping_charge-delete-{{ $mapping_charge->id }}').submit();">delete</a>
                                            <form id="mapping_charge-delete-{{ $mapping_charge->id }}" action="{{ route('mapping_charge.delete', [$mapping_charge->id]) }}" method="POST" class="sr-only">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </div>
                                        {{-- <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle small-caps" type="button" data-toggle="dropdown" style="margin-top: -.12em; line-height: 1.6em">
                                                actions
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a href="{{ route('mapping_fee.index', [$mapping_charge->id]) }}"
                                                    class="dropdown-item small-caps">
                                                    manage fees
                                                </a>
                                                <a class="dropdown-item small-caps" href="{{ route('mapping_charge.edit', [$mapping_charge->id]) }}">edit</a>
                                                <a class="dropdown-item small-caps" href="{{ route('mapping_charge.delete', [$mapping_charge->id]) }}" onclick="event.preventDefault();document.getElementById('mapping_charge-delete-{{ $mapping_charge->id }}').submit();">delete</a>
                                                <form id="mapping_charge-delete-{{ $mapping_charge->id }}" action="{{ route('mapping_charge.delete', [$mapping_charge->id]) }}" method="POST" class="sr-only">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                </form>
                                            </div>
                                        </div> --}}
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