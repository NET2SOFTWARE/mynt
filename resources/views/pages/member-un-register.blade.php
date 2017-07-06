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
                                <th>No. Account</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th class="text-center">Referral</th>
                                <th class="text-center">TOOLS</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>{{ $member->accounts->first()['number'] }}</td>
                                    <td>{{ $member->created_at }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->phone }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td class="text-center">{{ count($member->companies) < 1 ? '000' : $member->companies->first()['code'] }}</td>
                                    <td style="width:104px">
                                        <section class="btn-group btn-group-sm">
                                            <a class="btn small btn-primary py-0" href="{{ route('member.edit', [$member->id]) }}">View</a>
                                            <a class="btn small btn-primary py-0" href="{{ route('member.delete', [$member->id]) }}" onclick="event.preventDefault();document.getElementById('member-delete').submit();">Delete</a>
                                            <form id="member-delete" action="{{ route('member.delete', [$member->id]) }}" method="POST" class="sr-only">
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