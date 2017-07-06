@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => 'transaction'])@endcomponent
            <section class="col-md-9 mt-3">
                <section class="card" style="min-height:600px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.transaction.account') }}">Transfer To Account</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.transaction.bank') }}">Transfer To Bank</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.transaction.remittance') }}">Remittance ( MYNT to Cash )</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.transaction.redeem') }}">Redeem</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        @if (session('warning'))
                            <section class="alert small alert-success lh-1-2">{{ session('warning') }}</section>
                            <br/>
                        @elseif(session('success'))
                            <section class="alert small alert-success lh-1-2">{{ session('success') }}</section>
                            <br/>
                        @endif
                        <section class="col-md-8 offset-md-2">
                            <form class="my-5" action="{{ route('merchant.transaction.account.store') }}" method="POST" accept-charset="utf-8" role="form">
                                {{ csrf_field() }}

                                <section class="form-group row{{ $errors->has('sender') ? ' has-danger' : '' }}">
                                    <label for="sender" class="col-sm-4 col-form-label">From</label>
                                    <section class="col-sm-8">
                                        <input id="sender" type="text" name="sender" class="form-control disabled" value="{{ Auth::user()->merchants->first()['accounts'][0]['number'] }}" placeholder="Sender account number" aria-describedby="senderHelp" readonly>
                                        <small class="form-text small text-muted" id="senderHelp">Your account number.</small>
                                        @if ($errors->has('sender'))<span class="form-control-feedback">{{ $errors->first('sender') }}</span>@endif
                                    </section>
                                </section>
                                <section class="form-group row{{ $errors->has('recipient') ? ' has-danger' : '' }}">
                                    <label for="recipient" class="col-sm-4 col-form-label">To</label>
                                    <section class="col-sm-8">
                                        <input id="recipient" name="recipient" type="text" class="form-control" value="{{ old('recipient') }}" placeholder="Account number or MYNT ID" required>
                                        @if ($errors->has('recipient'))<span class="form-control-feedback">{{ $errors->first('recipient') }}</span>@endif
                                        <small class="form-text text-muted">Recipient account number</small>
                                    </section>
                                </section>
                                <section class="form-group row{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                    <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                                    <section class="col-sm-8">
                                        <input name="amount" type="text" class="form-control" id="amount" value="{{ old('amount') }}" placeholder="0000000" required>
                                        @if ($errors->has('amount'))<span class="form-control-feedback">{{ $errors->first('amount') }}</span>@endif
                                        <small class="form-text text-muted">Min: 500, only numeric characters</small>
                                    </section>
                                </section>
                                <section class="form-group row{{ $errors->has('token') ? ' has-danger' : '' }}">
                                    <label for="token" class="col-sm-4 col-form-label">Token</label>
                                    <section class="col-sm-8">
                                        <section class="d-flex justify-content-between">
                                            <input name="token" type="text" class="form-control" id="token" value="{{ old('token') }}" placeholder="Token transaction" aria-describedby="tokenHelp" style="display: inline-block; width: 70%;">
                                            <a href="{{ route('generate.token', [Auth::user()->members->first()['accounts'][0]['number']]) }}" class="btn btn-primary">Generate</a>
                                        </section>
                                        @if ($errors->has('amount'))<span class="form-control-feedback">{{ $errors->first('amount') }}</span>@endif
                                        <small class="form-text text-muted" id="">Request new transaction token first.</small>
                                    </section>
                                </section>
                                <section class="form-group row{{ $errors->has('captcha') ? ' has-danger' : '' }}">
                                    <label for="amount" class="col-sm-4 col-form-label">Security code</label>
                                    <section class="col-sm-8">
                                        <section class="d-flex justify-content-between">
                                            <figure class="col-auto mb-0">
                                                <img class="img-thumbnail" style="padding:3px!important;min-height:33px" id="img_captcha" src="{{ captcha_src('default') }}" height="28" width="112" alt="Captcha"/>
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
                                                    <input id="captcha" type="text" class="form-control" name="captcha" value="{{ old('captcha') }}" placeholder="Captcha code" required>
                                                </section>
                                            </section>
                                        </section>
                                        @if ($errors->has('captcha'))<span class="form-control-feedback">{{ $errors->first('captcha') }}</span>@endif
                                        <small class="form-text text-muted">Please enter valid security text code in the image</small>
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
                </section>
            </section>
        </section>
    </article>
@endsection


@section('script')
    <script type="text/javascript">
        (function ($) {
            $('#reload_captcha').on('click', function () {
                $.ajax({
                    method: 'GET',
                    url: '/get_captcha',
                }).done(function (response) {
                    $('#img_captcha').prop('src', response);
                });
            });
        })(jQuery);
    </script>
@endsection