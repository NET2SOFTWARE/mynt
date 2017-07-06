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
                    @component('components.aside-member-register', ['active' => 'token'])@endcomponent
                @else
                    @component('components.aside-member-unregister', ['active' => 'token'])@endcomponent
                @endif
            @else
                @component('components.aside-member-child', ['active' => 'token'])@endcomponent
            @endif
            <section class="col-md-9 py-3">
                <h6 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">
                    Request Token For Payment
                    <span>
                        @if(count(Auth::user()->members->first()['profiles']) < 1 && (!Auth::user()->members->first()->isChildAccount()))
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif(Auth::user()->members->first()->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </h6>
                <section class="card" style="min-height:540px">
                    <section class="card-block py-5">
                        <section class="col-sm-6 offset-sm-3">
                            <section class="card card-block py-3">
                                <h6 class="medium-small text-muted text-uppercase mt-0 mb-3">Request new token</h6>
                                @if (session('warning'))
                                    <section class="alert small alert-success lh-1-2">{{ session('warning') }}</section>
                                    <br/>
                                @elseif(session('success'))
                                    <section class="alert small alert-success lh-1-2">{{ session('success') }}</section>
                                    <br/>
                                @endif
                                <form action="{{ route('member.token.store') }}" method="POST" accept-charset="utf-8" role="form">

                                    {{ csrf_field() }}
                                    <fieldset class="form-group{{ $errors->has('account_number') ? ' has-danger' : '' }}">
                                        <label for="account-number">Account number</label>
                                        <select id="account-number" name="account_number" class="custom-select w-100">
                                            <option value="{{ $member->accounts->first()->number }}" selected>{{ $member->accounts->first()->number }}</option>
                                        </select>
                                        @if ($errors->has('account_number'))<section class="form-control-feedback">{{ $errors->first('account_number') }}</section>@endif
                                        <small class="form-text text-muted d-flex justify-content-between">The account number you are currently using. <i class="lh-1-2 text-grey">Required</i></small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                        <label for="amount">Amount</label>
                                        <input id="amount" name="amount" type="text" value="{{ old('amount') }}" class="form-control" placeholder="Amount">
                                        @if ($errors->has('amount'))<section class="form-control-feedback">{{ $errors->first('amount') }}</section>@endif
                                        <small class="form-text lh-1-2 text-muted d-flex justify-content-between">Please enter the nominal amount.<i class="lh-1-2 text-grey">Required</i></small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('captcha') ? ' has-danger' : '' }}">
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
                                                <small class="form-text lh-1-2 text-muted d-flex justify-content-between" id="captchaHelp">Enter security code <i class="text-grey">Required</i></small>
                                                @if ($errors->has('captcha'))<span class="form-control-feedback">{{ $errors->first('captcha') }}</span>@endif
                                            </section>
                                        </section>
                                    </fieldset>
                                    <section class="form-group mt-4 text-right">
                                        <button class="btn btn-block btn-primary" type="submit" role="button">Request New Token</button>
                                    </section>
                                </form>
                            </section>
                        </section>
                    </section>
                    <section class="card-footer lh-1-2">
                        <small class="text-muted"><span class="badge badge-default">Note </span> Every transaction, you have to request a new token from the server. It aims to protect your balance from suspicious transaction actions. Token will be sent to email and your phone to activate your future transactions that you will do. Token will only be valid within 15 minutes. When the token has passed the time limit, please request a new token again.</small>
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
