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
                    @component('components.aside-member-register', ['active' => 'child'])@endcomponent
                @else
                    @component('components.aside-member-unregister', ['active' => 'child'])@endcomponent
                @endif
            @else
                @component('components.aside-member-child', ['active' => 'child'])@endcomponent
            @endif
            <section class="col-md-9 py-3">
                <h6 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">
                    Create New Child Account
                    <span>
                        @if(count(Auth::user()->members->first()['profiles']) < 1 && (!Auth::user()->members->first()->isChildAccount()))
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif(Auth::user()->members->first()->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </h6>
                <section class="card">
                    <section class="card-block py-4">
                        <section class="col-sm-8 offset-sm-2 px-5">
                            <section class="card card-block p-4">
                                <p class="medium-small lh-1-2 text-warning text-uppercase mb-4">NEW CHILD ACCOUNT</p>
                                @if (session('success'))
                                    <section class="alert small lh-1-2 mb-3 alert-success">{{ session('success') }}</section>
                                @elseif(session('warning'))
                                    <section class="alert small lh-1-2 mb-3 alert-success">{{ session('warning') }}</section>
                                @endif
                                <form method="POST" action="{{ route('child.store') }}" accept-charset="utf-8" role="form">
                                    {{ csrf_field() }}
                                    <section class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label for="name">Full name</label>
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full name" aria-describedby="nameHelp" required autofocus>
                                        @if ($errors->has('name'))<section class="form-control-feedback">{{ $errors->first('name') }}</section>@endif
                                        <small class="form-text small text-muted d-flex justify-content-between" id="nameHelp">Full name, alpha characters only. Max. 40 <span class="text-grey">Required</span></small>
                                    </section>
                                    <fieldset class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label for="email">E-mail address</label>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail address" aria-describedby="emailHelp" required>
                                        @if ($errors->has('email'))<section class="form-control-feedback">{{ $errors->first('email') }}</section>@endif
                                        <small class="form-text small text-muted d-flex justify-content-between" id="emailHelp">E-mail address format, e.g : dummy@example..com <span class="text-grey">Required</span></small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                        <label for="phone">Mobile number</label>
                                        <section class="input-group">
                                            <span class="input-group-addon" id="sizing-addon2 medium-small" style="padding-top:.25rem;padding-bottom:.25rem">+62</span>
                                            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" style="padding-top:.25rem;padding-bottom:.25rem" placeholder="Mobile number" required>
                                        </section>
                                        @if ($errors->has('phone'))<section class="form-control-feedback">{{ $errors->first('phone') }}</section>@endif
                                        <small class="form-text small text-muted d-flex justify-content-between" id="emailHelp">Mobile number format, e.g : 08xxxxxxxx <span class="text-grey">Required</span></small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <label for="password">Password</label>
                                        <input id="password" type="password" class="form-control" name="password" placeholder="New password" aria-describedby="passwordHelp" required>
                                        @if ($errors->has('password'))<section class="form-control-feedback">{{ $errors->first('password') }}</section>@endif
                                        <small class="form-text small text-muted d-flex justify-content-between" id="passwordHelp">Unique password alpha numeric, min. 6~16 characters <span class="text-grey">Required</span></small>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="password-confirm" class="sr-only">Confirm password</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password" aria-describedby="confirmPasswordHelp" required>
                                        <small class="form-text small text-muted d-flex justify-content-between" id="confirmPasswordHelp">Confirm your password <span class="text-grey">Required</span></small>
                                    </fieldset>
                                    <hr class="my-4 clearfix"/>
                                    <fieldset class="form-group{{ $errors->has('limit.balance') ? ' has-danger' : '' }}">
                                        <label for="limit-balance">Child's account balance limit</label>
                                        <input id="limit-balance" type="text" class="form-control" name="limit[balance]" value="{{ old('limit.balance') }}" placeholder="Limit balance" required>
                                        @if ($errors->has('limit.balance'))<section class="form-control-feedback">{{ $errors->first('limit.balance') }}</section>@endif
                                        <section class="form-text text-muted d-flex justify-content-between">Limit the maximum balance held by the child's account. You can also change this nominal in the future through the child account management feature.  <span class="text-grey ml-3">Required</span></section>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('limit.transaction') ? ' has-danger' : '' }}">
                                        <label for="limit-transaction">Maximum monthly transaction limit</label>
                                        <input id="limit-transaction" type="text" class="form-control" name="limit[transaction]" value="{{ old('limit.transaction') }}" placeholder="Limit transaction" required>
                                        @if ($errors->has('limit.transaction'))<section class="form-control-feedback">{{ $errors->first('limit.transaction') }}</section>@endif
                                        <section class="form-text text-muted d-flex justify-content-between">Set an upper limit for child account transactions for each transaction and a nominal compilation for one month.  <span class="text-grey ml-3">Required</span></section>
                                    </fieldset>
                                    <hr class="my-4 clearfix"/>
                                    <fieldset class="form-group mb-4{{ $errors->has('captcha') ? ' has-danger' : '' }}">
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
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('term') ? ' has-danger' : '' }}">
                                        <label class="custom-control custom-checkbox medium lh-1-5 mb-0">
                                            <input id="term" type="checkbox" name="term" class="custom-control-input" {{ old('term') ? 'checked' : '' }}>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">I agree to mynt <a href="{{ url('/term') }}">term and condition</a></span>
                                        </label>
                                        @if ($errors->has('term'))
                                            <section class="form-control-feedback">{{ $errors->first('term') }}</section>
                                        @endif
                                    </fieldset>
                                    <section class="form-group">
                                        <button type="submit" class="btn btn-block btn-primary" role="button">Register</button>
                                    </section>
                                </form>
                            </section>
                        </section>
                    </section>
                    <section class="card-footer">
                        <small class="text-muted"><span class="badge badge-default">Note </span>&nbsp;You can create a child account for your current account, which allows it to form account groups that you can manage and give to your family to use within the limits you specify.</small>
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
