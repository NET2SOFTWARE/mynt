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
                    <section class="d-flex px-3 mt-3 justify-content-between align-items-baseline">
                    <section>
                        <p class="medium lh-1-5 mb-0">&nbsp;</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('identity.create') }}" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Create new">
                                    <i class="icon icon-dark ion-document mr-2"></i>New
                                </a>
                            </section>
                        </section>
                        <form action="{{ route('identity.sort.index') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <a href="{{ route('identity.index') }}" class="btn icon-btn-24 btn-secondary" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="icon icon-dark icon-24 ion-android-refresh"></i></a>
                                </span>
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by name" style="width:240px!important;">
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $identities->previousPageUrl() }}" class="btn btn-secondary {{ ($identities->previousPageUrl() != null) ?: ' disabled' }}" data-toggle="tooltip" data-placement="top" title="Previous"><i class="icon icon-dark ion-android-arrow-back"></i></a>
                            <a href="{{ $identities->nextPageUrl() }}" class="btn btn-secondary {{ ($identities->hasMorePages() == true) ?: ' disabled' }}" data-toggle="tooltip" data-placement="top" title="Next"><i class="icon icon-dark ion-android-arrow-forward"></i></a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium mt-3 px-3">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                <th style="width:24px">ID</th>
                                <th class="text-center" style="width:180px">CREATED DATETIME</th>
                                <th>IDENTITY NAME</th>
                                <th style="width:64px">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody class="medium-small lh-1-2">
                            @foreach($identities as $identity)
                                <tr>
                                    <th class="rows" style="font-weight:normal!important;">{{ $identity->id }}</th>
                                    <td class="text-center" style="width:180px">{{ date('d-m-Y H:i:s', strtotime($identity->created_at)) }}</td>
                                    <td>{{ $identity->name }}</td>
                                    <td style="width:64px">
                                        <a class="badge badge-default" href="{{ route('identity.edit', [$identity->id]) }}" data-toggle="tooltip" data-placement="left" title="Edit" style="padding-top:2px;padding-bottom:2px">
                                            <i class="icon ion-compose"></i>
                                        </a>
                                        <a class="badge badge-default" href="{{ route('identity.delete', [$identity->id]) }}" data-toggle="tooltip" data-placement="left" title="Delete" style="padding-top:2px;padding-bottom:2px" onclick="event.preventDefault();document.getElementById('identity-delete-{{$identity->id}}').submit();">
                                            <i class="icon ion-android-delete"></i>
                                        </a>
                                        <form id="identity-delete-{{$identity->id}}" action="{{ route('identity.delete', [$identity->id]) }}" method="POST" class="sr-only">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
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