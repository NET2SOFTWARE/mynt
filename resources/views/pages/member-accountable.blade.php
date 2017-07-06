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
            <!-- <member-page></member-page> -->
            <section class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2 p-0">
                <section class="header-content justify-content-between align-items-baseline">
                    <section>
                        <p class="medium lh-1-5 mb-0">MEMBER</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm mr-3">
                                <a href="{{ route('member.create') }}" class="btn btn-secondary">New</a>
                            </section>
                            <section class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-secondary">Print</button>
                                <button type="button" class="btn btn-secondary">Refresh</button>
                            </section>
                        </section>
                        <section class="input-group input-group-sm ml-3">
                            <section class="input-group-btn">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Category
                                </button>
                                <section class="dropdown-menu">
                                    <a class="dropdown-item" href="#">ID</a>
                                    <a class="dropdown-item" href="#">Name</a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Email</a>
                                </section>
                            </section>
                            <input id="search" name="search" type="search" class="form-control" placeholder="Search value" style="max-width:160px!important;width:160px!important;">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button">Find</button>
                            </span>
                        </section>
                        <section class="btn-group btn-group-sm ml-3">
                            <button type="button" class="btn btn-secondary">Previous</button>
                            <button type="button" class="btn btn-secondary">Next</button>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                <th>ID</th>
                                <th>DATE</th>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th class="text-center">TOOLS</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>{{ $member->id }}</td>
                                    <td>{{ $member->created_at }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td style="width:100px">
                                        <a class="badge small py-2 badge-primary" href="{{ route('member.edit', [$member->id]) }}">View</a>
                                        <a class="badge small py-2 badge-danger" href="{{ route('member.delete', [$member->id]) }}" onclick="event.preventDefault();document.getElementById('member-delete').submit();">Delete</a>
                                        <form id="member-delete" action="{{ route('member.delete', [$member->id]) }}" method="POST" class="sr-only">
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