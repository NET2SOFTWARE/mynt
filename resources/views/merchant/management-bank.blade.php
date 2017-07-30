@extends('layouts.app')

@section('nav')
    @component('components.nav-merchant')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-merchant', ['active' => 'management'])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3" style="min-height:620px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('merchant.management.account') }}">Personal Account</a></li>
                            <li class="nav-item"><a class="nav-link active" href="{{ route('merchant.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <p class="d-flex medium justify-content-end mb-3">
                            <a href="{{ route('merchant.management.bank.create') }}" class="btn btn-sm btn-success">Register bank account</a>
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
                                                <i class="fa fa-trash-o"></i>
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
