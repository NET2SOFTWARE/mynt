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
                    <section>&nbsp;</section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('role.create') }}" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Create new">
                                    <i class="icon icon-dark ion-document mr-2"></i>New
                                </a>
                                <a href="{{ route('role.index') }}" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="icon icon-dark ion-android-refresh"></i></a>
                            </section>
                        </section>
                        <form action="{{ route('member.sort.index') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <section class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <a href="{{ route('role.index') }}" class="btn icon-btn-24 btn-secondary" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="icon icon-dark icon-24 ion-android-refresh"></i></a>
                                </span>
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by name..." style="width:240px!important;">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $roles->previousPageUrl() }}" class="btn btn-secondary {{ ($roles->previousPageUrl() != null) ?: ' disabled' }}" data-toggle="tooltip" data-placement="top" title="Previous"><i class="icon icon-dark ion-android-arrow-back"></i></a>
                            <a href="{{ $roles->nextPageUrl() }}" class="btn btn-secondary {{ ($roles->hasMorePages() == true) ?: ' disabled' }}" data-toggle="tooltip" data-placement="top" title="Next"><i class="icon icon-dark ion-android-arrow-forward"></i></a>
                        </section>
                    </section>
                </section>
                <section class="table-sm table-responsive medium mt-3 px-3">
                    <table class="table medium-small lh-1-2">
                        <thead>
                        <tr class="medium">
                            <th style="width:24px">ID</th>
                            <th class="text-center" style="width:180px">CREATED DATETIME</th>
                            <th>NAME</th>
                            <th style="width:68px">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <th class="rows" style="font-weight:normal!important;">{{ $role->id }}</th>
                                <td class="text-center" style="width:180px">{{ date('d-m-Y H:i:s', strtotime($role->created_at)) }}</td>
                                <td>{{ $role->name }}</td>
                                <td style="width:68px">
                                    <a class="badge badge-default" href="{{ route('role.edit', [$role->id]) }}" data-toggle="tooltip" data-placement="left" title="Setting" style="padding-top:2px;padding-bottom:2px">
                                        <i class="icon ion-compose"></i>
                                    </a>
                                    <a class="badge badge-default" href="#" data-toggle="tooltip" data-placement="left" title="Delete" style="padding-top:2px;padding-bottom:2px">
                                        <i class="icon ion-android-delete"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </article>
@endsection