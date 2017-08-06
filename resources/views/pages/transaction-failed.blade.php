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
                        <p class="medium lh-1-5 mb-0"><span class="badge badge-danger">FAILED</span> TRANSACTION</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('transaction.failed.index') }}" class="btn btn-secondary">Refresh</a>
                            </section>
                        </section>
                        <form action="{{ route('transaction.sort.index') }}" method="POST" class="input-group input-group-sm ml-3" role="form">
                            {{ csrf_field() }}
                            <input type="hidden" name="route" value="transaction.failed.index" />
                            <input type="hidden" name="page" value="transaction-failed" />
                            <section class="input-group input-group-sm">
                                <input id="search" name="search" type="search" class="form-control" placeholder="Search by service, sender or receiver" style="width:240px!important;">
                                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">Find</button>
                                </span>
                            </section>
                        </form>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $transactions->previousPageUrl() }}" class="btn btn-secondary {{ ($transactions->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $transactions->nextPageUrl() }}" class="btn btn-secondary {{ ($transactions->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                                <tr class="medium">
                                    <th>TRANS. ID</th>
                                    <th class="text-center">SERVICE</th>
                                    <th>AMOUNT</th>
                                    <th>SENDER ACCOUNT</th>
                                    <th>RECEIVER ACCOUNT</th>
                                    <th class="text-center">TRANS. TIME</th>
                                    {{-- <th></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at }}</td>
                                    <td class="text-center"><code>{{ $transaction->service->name }}</code></td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->sender_account_number }}</td>
                                    <td>{{ $transaction->receiver_account_number }}</td>
                                    <td>{{ $transaction->created_at->format('j F Y H:i:s') }}</td>
                                    {{-- <td class="text-right">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Tools">
                                            <a href="#" class="btn btn-secondary py-0 small-caps">details</a>
                                        </div>
                                    </td> --}}
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