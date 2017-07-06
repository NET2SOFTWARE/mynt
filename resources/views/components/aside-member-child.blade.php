<aside class="col-md-3 py-3">
    <figure class="media mb-3">
        <section class="media-left">
            <img class="d-flex" src="{{ asset('img/img.jpg') }}" width="80" height="80" alt="{{ Auth::user()->name }}">
        </section>
        <figcaption class="media-body pl-3">
            <h6 class="mt-0"><strong>{{ Auth::user()->name }}</strong></h6>
            <ul class="list-group list-group-flush medium-small">
                <li class="list-group-item p-0 justify-content-between">NO. ACC <span>{{ Auth::user()->members->first()['accounts'][0]['number'] }}</span></li>
                <li class="list-group-item p-0 justify-content-between">MYNT-ID <span>{{ Auth::user()->members->first()['accounts'][0]['mynt_id'] }}</span></li>
            </ul>
        </figcaption>
    </figure>
    <section class="card-group card-group-custome mb-3">
        <section class="card col-xs-6">
            <section class="card-block py-2 px-3">
                <p class="card-text medium-small text-muted">Account :</p>
            </section>
            <section class="card-footer py-2">
                <h5 class="card-title medium m-0"><span class="badge badge-default">Child Account</span></h5>
            </section>
        </section>
        <section class="card col-xs-6">
            <section class="card-block py-2 px-3">
                <p class="card-text medium-small text-muted">Balance :</p>
            </section>
            <section class="card-footer py-2">
                <h5 class="card-title text-right medium m-0"><strong>{{ number_format(count(Auth::user()->members->first()['accounts'][0]['passbooks']) > 0 ? Auth::user()->members->first()['accounts'][0]->passbooks->last()['balance'] : 0) }}</strong></h5>
            </section>
        </section>
    </section>
    <nav class="list-group medium mb-3">
        <a href="{{ route('member.accounting') }}" class="list-group-item list-group-item-action py-2{{ $active == 'accounting' ? ' active' : ''}}">Account Sheet</a>
        <a href="{{ route('member.transactions.account') }}" class="list-group-item list-group-item-action py-2{{ $active == 'transaction' ? ' active' : ''}}">Transaction</a>
        <a href="{{ route('member.purchase') }}" class="list-group-item list-group-item-action py-2{{ $active == 'purchase' ? ' active' : ''}}">Purchase</a>
        <a href="{{ route('member.payment') }}" class="list-group-item list-group-item-action py-2{{ $active == 'payment' ? ' active' : ''}}">Payment</a>
        <a href="{{ route('member.accessibility') }}" class="list-group-item list-group-item-action py-2{{ $active == 'accessibility' ? ' active' : ''}}">Accessibility</a>
        <a href="{{ route('member.management') }}" class="list-group-item list-group-item-action py-2{{ $active == 'management' ? ' active' : ''}}">Account Management</a>
    </nav>
    <section class="card">
        <ul class="list-group list-group-flush medium">
            <li class="list-group-item py-1 justify-content-between">Balance limit <span class="text-grey">{{ number_format(Auth::user()->members->first()['accounts'][0]['limit_balance']) }}</span></li>
            <li class="list-group-item py-1 justify-content-between border-bottom-0">Transaction limit <span class="text-grey">{{ number_format(Auth::user()->members->first()['accounts'][0]['limit_balance_transaction']) }}</span></li>
        </ul>
        <section class="card-footer py-3">
            <p class="mb-0 d-flex justify-content-end"><small class="text-grey">Parent account</small></p>
            <hr class="mt-1 mb-2"/>
            <h6 class="mb-0 d-flex justify-content-between">
                <small>{{ Auth::user()->parentAccounts->first()->user->name }}</small>
                <small>{{ Auth::user()->parentAccounts->first()->user->members->first()['accounts'][0]['number'] }}</small>
            </h6>
        </section>
    </section>
</aside>