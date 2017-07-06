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
                    @component('components.aside-member-register', ['active' => 'transaction'])@endcomponent
                @else
                    @component('components.aside-member-unregister', ['active' => 'transaction'])@endcomponent
                @endif
            @else
                @component('components.aside-member-child', ['active' => 'transaction'])@endcomponent
            @endif
            <section class="col-md-9 py-3">
                <h5 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">
                    Transaction
                    <span>
                        @if(count(Auth::user()->members->first()['profiles']) < 1 && (!Auth::user()->members->first()->isChildAccount()))
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif(Auth::user()->members->first()->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </h5>
                <section class="card my-3" style="min-height:560px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link" href="{{ route('member.transactions.account') }}">Transfer to Account</a></li>
                            @if(Auth::user()->members->first()->isRegistered() && (!Auth::user()->isChildAccount()))
                                <li class="nav-item"><a class="nav-link" href="{{ route('member.transactions.bank') }}">Transfer to Bank</a></li>
                                <li class="nav-item"><a class="nav-link active" href="{{ route('member.transactions.remittance') }}">Remittance</a></li>
                            @endif
                            <li class="nav-item"><a class="nav-link" href="{{ route('member.transactions.redeem') }}">Reedem</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="col-md-8 offset-md-2">
                            <form class="py-4" accept-charset="utf-8" role="form">
                                {{ csrf_field() }}
                                <section class="form-group row{{ $errors->has('sender') ? ' has-danger' : '' }}">
                                    <label for="sender" class="col-sm-4 col-form-label">From</label>
                                    <section class="col-sm-8">
                                        <input id="sender" type="text" name="sender" class="form-control disabled" value="{{ Auth::user()->members->first()['accounts'][0]['number'] }}" placeholder="Sender account number" aria-describedby="senderHelp" readonly>
                                        <small class="form-text small text-muted d-flex justify-content-between" id="senderHelp">Your account number. <span class="text-grey">Required</span></small>
                                        @if ($errors->has('sender'))<span class="form-control-feedback">{{ $errors->first('sender') }}</span>@endif
                                    </section>
                                </section>
                                <section class="form-group row">
                                    <label for="inputHorizontalDnger" class="col-sm-4 col-form-label">Bank code</label>
                                    <section class="col-sm-8">
                                        <input type="email" class="form-control form-control-danger" id="inputHorizontalDnger" placeholder="Bank code, e.g : 001">
                                        <small class="form-text text-muted d-flex justify-content-between">Bank code, numeric character only, e.g : 001 <span class="text-grey">Required</span></small>
                                    </section>
                                </section>
                                <section class="form-group row">
                                    <label for="amount" class="col-sm-4 col-form-label">Bank name</label>
                                    <section class="col-sm-8">
                                        <input name="amount" type="text" class="form-control" id="amount" placeholder="Bank name">
                                        <small class="form-text text-muted d-flex justify-content-between">Initial bank name or full bank name <span class="text-grey">Required</span></small>
                                    </section>
                                </section>
                                <section class="form-group row">
                                    <label for="amount" class="col-sm-4 col-form-label">Bank Account</label>
                                    <section class="col-sm-8">
                                        <input name="amount" type="text" class="form-control" id="amount" placeholder="000-00-000000">
                                        <small class="form-text text-muted d-flex justify-content-between">Bank account number, numeric character only <span class="text-grey">Required</span></small>
                                    </section>
                                </section>
                                <section class="form-group row">
                                    <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                                    <section class="col-sm-8">
                                        <input name="amount" type="text" class="form-control" id="amount" placeholder="00000">
                                        <small class="form-text text-muted d-flex justify-content-between">Min: 500, only numeric characters <span class="text-grey">Required</span></small>
                                    </section>
                                </section>
                                <section class="form-group row{{ $errors->has('token') ? ' has-danger' : '' }}">
                                    <label for="token" class="col-sm-4 col-form-label">Token</label>
                                    <section class="col-sm-8">
                                        <section class="d-flex justify-content-between">
                                            <input name="token" type="text" class="form-control" id="token" value="{{ old('token') }}" placeholder="Token transaction" aria-describedby="tokenHelp" style="display: inline-block; width: 70%;">
                                            <a class="btn btn-primary" href="{{ route('generate.token', [Auth::user()->members->first()['accounts'][0]['number']]) }}">Generate</a>
                                        </section>
                                        @if ($errors->has('amount'))<span class="form-control-feedback">{{ $errors->first('amount') }}</span>@endif
                                        <small class="form-text text-muted d-flex justify-content-between" id="">Request new transaction token first <span class="text-grey">Required</span></small>
                                    </section>
                                </section>
                                <section class="form-group row{{ $errors->has('captcha') ? ' has-danger' : '' }}">
                                    <label for="amount" class="col-sm-4 col-form-label">Security code</label>
                                    <section class="col-sm-8">
                                        <section class="d-flex justify-content-between">
                                            <figure class="col-auto mb-0">
                                                <img class="img-thumbnail" style="padding:3px!important;min-height:33px" id="img_captcha" src="{{ captcha_src('default') }}" height="44" width="158" alt="Captcha"/>
                                            </figure>
                                            <section class="col pr-0">
                                                <section class="input-group">
                                                    <section class="input-group-btn">
                                                        <a id="reload_captcha" href="javascript:void(0)" class="btn btn-sm btn-secondary d-flex px-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path d="M12 6v3l4-4-4-4v3c-4.42 0-8 3.58-8 8 0 1.57.46 3.03 1.24 4.26L6.7 14.8c-.45-.83-.7-1.79-.7-2.8 0-3.31 2.69-6 6-6zm6.76 1.74L17.3 9.2c.44.84.7 1.79.7 2.8 0 3.31-2.69 6-6 6v-3l-4 4 4 4v-3c4.42 0 8-3.58 8-8 0-1.57-.46-3.03-1.24-4.26z"/>
                                                            </svg>
                                                        </a>
                                                    </section>
                                                    <input id="captcha" type="text" class="form-control" name="captcha" value="{{ old('captcha') }}" placeholder="Captcha code" aria-describedby="captchaHelp" required>
                                                </section>
                                                <small class="form-text lh-1-2 text-muted d-flex justify-content-between" id="captchaHelp">Enter security code <span class="text-grey">Required</span></small>
                                                @if ($errors->has('captcha'))<span class="form-control-feedback">{{ $errors->first('captcha') }}</span>@endif
                                            </section>
                                        </section>
                                    </section>
                                </section>
                                <section class="form-group row mt-4">
                                    <section class="col-sm-8 offset-sm-4">
                                        <button class="btn btn-block btn-primary" type="submit" role="button">Process</button>
                                    </section>
                                </section>
                            </form>
                        </section>
                    </section>
                    <section class="card-footer">
                        <small class="text-muted">Note : If you have a trouble, please contact our cumtumer service.</small>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection
