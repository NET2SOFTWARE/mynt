<aside class="col-md-3 py-3">
    <figure class="media mb-3">
        <section class="media-left">
            <img class="d-flex" src="{{ asset('img/img.jpg') }}" width="80" height="80" alt="{{ Auth::user()->name }}">
        </section>
        <figcaption class="media-body pl-3">
            <h6 class="mt-0"><strong>{{ Auth::user()->name }}</strong></h6>
            <ul class="list-group list-group-flush medium-small">
                <li class="list-group-item p-0 justify-content-between">NO. ACC <span>{{ Auth::user()->merchants->first()['accounts'][0]['number'] }}</span></li>
                <li class="list-group-item p-0 justify-content-between">MYNT-ID <span>{{ Auth::user()->merchants->first()['accounts'][0]['mynt_id'] }}</span></li>
            </ul>
        </figcaption>
    </figure>
    <section class="card mb-3">
        <section class="card-block py-2 px-3">
            <p class="card-text medium-small text-muted">Balance :</p>
        </section>
        <section class="card-footer py-2">
            <h5 class="card-title text-right medium m-0"><strong>{{ number_format(count(Auth::user()->merchants->first()['accounts'][0]['passbooks']) > 0 ? Auth::user()->merchants->first()['accounts'][0]->passbooks->last()['balance'] : 0) }}</strong></h5>
        </section>
    </section>
    <nav class="list-group medium mb-3">
        <a href="{{ route('merchant.accounting') }}" class="list-group-item list-group-item-action py-2{{ $active == 'accounting' ? ' active' : ''}}">Account Sheet</a>
        <a href="{{ route('merchant.transaction.account') }}" class="list-group-item list-group-item-action py-2{{ $active == 'transaction' ? ' active' : ''}}">Transaction</a>
        <a href="{{ route('merchant.summary.product') }}" class="list-group-item list-group-item-action py-2{{ $active == 'summary' ? ' active' : ''}}">Summary Transaction</a>
        <a href="{{ route('merchant.accessibility.notification') }}" class="list-group-item list-group-item-action py-2{{ $active == 'accessibility' ? ' active' : ''}}">Accessibility</a>
        <a href="{{ route('merchant.management.account') }}" class="list-group-item list-group-item-action py-2{{ $active == 'management' ? ' active' : ''}}">Account Management</a>
    </nav>
</aside>