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
                        <p class="medium lh-1-5 mb-0">DEACTIVATE ACCESS</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('administrator.deactivate.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('administrator.deactivate.sort') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <input name="extra" type="hidden" value="deactivate" />
                                <input name="page" type="hidden" value="pages.administrator-deactivate" />
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by co-brand code, name, account no." style="width:240px!important;" />
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $administrators->previousPageUrl() }}" class="btn btn-secondary {{ ($administrators->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $administrators->nextPageUrl() }}" class="btn btn-secondary {{ ($administrators->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                                <tr class="medium">
                                    <th>STATUS</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>CREATED DATE</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($administrators as $administrator)
                                <tr>
                                    <td>
                                        @if ($administrator->is_active)
                                            <span class="badge small-caps badge-success">active</span>
                                        @else
                                            <span class="badge small-caps badge-danger">inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $administrator->name }}
                                    </td>
                                    <td>
                                        {{ $administrator->email }}
                                    </td>
                                    <td>
                                        {{ $administrator->created_at->format('j F Y') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                            <a href="{{ route('administrator.deactivate.process', [$administrator->id]) }}" 
                                                class="btn btn-secondary py-0 small-caps">
                                                {{ $administrator->is_active == false ? '' : 'de' }}activate
                                            </a>
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