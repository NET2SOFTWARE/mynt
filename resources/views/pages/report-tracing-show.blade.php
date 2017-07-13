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
                        <p class="medium lh-1-5 mb-0">REPORT TRANSACTION TRACING</p>
                    </section>
                    <section class="d-flex justify-content-between align-content-st align-items-baseline">
                        <section class="d-flex justify-content-between align-content-start">
                            <section class="btn-group btn-group-sm">
                                <a href="{{ route('report.tracing.index') }}" class="btn btn-secondary">Back</a>
                            </section>
                        </section>
                        <section class="btn-group btn-group-sm ml-3">
                            <a href="{{ $data->previousPageUrl() }}" class="btn btn-secondary {{ ($data->previousPageUrl() != null) ?: ' disabled' }}">Previous</a>
                            <a href="{{ $data->nextPageUrl() }}" class="btn btn-secondary {{ ($data->hasMorePages() == true) ?: ' disabled' }}">Next</a>
                        </section>
                    </section>
                </section>
                <transition name="fade">
                    <section class="table-sm table-responsive medium p-3">
                        <table class="table">
                            <thead>
                            <tr class="medium">
                                <th class="text-center">STATUS</th>
                                <th>TRANS. ID</th>
                                <th class="text-center">SERVICE</th>
                                <th>AMOUNT</th>
                                <th>SENDER ACCOUNT</th>
                                <th>RECEIVER ACCOUNT</th>
                                <th>TRANS. TIME</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $transaction)
                                <tr>
                                    <td class="text-center">{!! $transaction->status_badge !!}</td>
                                    <td>{{ $transaction->trx_id }}</td>
                                    <td class="text-center"><code>{{ $transaction->service->name }}</code></td>
                                    <td>{{ sprintf('Rp %s', number_format($transaction->amount)) }}</td>
                                    <td>{{ $transaction->sender_account_number }}</td>
                                    <td>{{ $transaction->receiver_account_number }}</td>
                                    <td>{{ $transaction->created_at->format('j F Y H:i:s') }}</td>
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