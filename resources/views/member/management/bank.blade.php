@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'user'])
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @if(Auth::user()->role() == 3)
                @if(Auth::user()->members->first()->isRegistered())
                    @component('components.aside-member-register', ['active' => 'management'])@endcomponent
                @else
                    @component('components.aside-member-unregister', ['active' => 'management'])@endcomponent
                @endif
            @else
                @component('components.aside-member-child', ['active' => 'management'])@endcomponent
            @endif
            <section class="col-md-9 py-3">
                <h5 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">
                    Management
                    <span>
                        @if(count(Auth::user()->members->first()['profiles']) < 1 && (!Auth::user()->members->first()->isChildAccount()))
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif(Auth::user()->members->first()->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </h5>
                <section class="card" style="min-height:620px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('member.management') }}">Personal Account</a></li>
                            @if(!Auth::user()->members->first()->isChildAccount())
                                <li class="nav-item"><a class="nav-link active" href="{{ route('member.management.bank') }}">Bank Account</a></li>
                            @endif
                            @if(Auth::user()->members->first()->isRegistered())
                                <li class="nav-item"><a class="nav-link" href="{{ route('member.management.child') }}">Child Account</a></li>
                            @endif
                        </ul>
                    </section>
                    <section class="card-block">
                        <p class="d-flex medium justify-content-end mb-3">
                            <a href="{{ route('member.management.create') }}" class="btn btn-sm btn-success">Register bank account</a>
                        </p>
                        <section class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>BANK NAME</th>
                                        <th>INITIAL BANK ACCOUNT</th>
                                        <th class="text-center">BANK CODE</th>
                                        <th>ACCOUNT BANK NAME</th>
                                        <th>REGISTERED AT</th>
                                    </tr>
                                </thead>
                                <tbody class="medium-small lh-1-2">
                                @foreach(Auth::user()->remittances as $data)
                                    <tr>
                                        <td>{{ strtoupper($data->bank->bank_name)  }}</td>
                                        <td>{{ strtoupper($data->bank->bank_name).'-'.$data->accountid1 }}</td>
                                        <td class="text-center">{{ $data->instid1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime($data->created_at)) }}</td>
                                        <td style="width:32px">
                                            <a class="badge badge-default" href="{{ route('delete.remittance', [$data->id]) }}"  data-toggle="tooltip" data-placement="left" title="Delete" style="font-size:14px;padding-top:3px;padding-bottom:3px">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
