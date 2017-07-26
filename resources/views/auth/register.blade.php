@extends('layouts.app')

@section('content')
    <article class="d-flex justify-content-center py-4">
        <section class="align-self-center con-sign-up">
            <header class="col-md-12">
                <h4>Register</h4>
                <h6 class="medium">Please fill the form below with valid data.</h6>
            </header>
            <section class="col-md-12 py-3">
                @if (session('warning'))
                    <section class="alert medium-small text-center alert-warning">{{ session('warning') }}</section>
                @endif
                <form method="POST" action="{{ route('register') }}" accept-charset="utf-8" role="form">
                    {{ csrf_field() }}
                    <fieldset class="form-group{{ ($errors->has('first_name') or $errors->has('last_name')) ? ' has-danger' : '' }}">
                        <section class="d-flex justify-content-between">
                            <section class="form-group mb-0">
                                <label for="first-name" class="sr-only">First name</label>
                                <input id="name-first" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First name" required autofocus>
                            </section>
                            <section class="form-group ml-3 mb-0">
                                <label for="last-name" class="sr-only">Last name</label>
                                <input id="last-name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" required>
                            </section>
                        </section>
                        @if ($errors->has('first_name') or $errors->has('last_name'))
                            <section class="form-control-feedback">The first name or last name field is required.</section>
                        @endif
                    </fieldset>
                    <fieldset class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="sr-only">E-mail address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail address" required>
                        @if ($errors->has('email'))
                            <section class="form-control-feedback">{{ $errors->first('email') }}</section>
                        @endif
                    </fieldset>
                    <fieldset class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                        <section class="input-group">
                            <span class="input-group-addon medium-small lh-1-5" style="padding-top:.125rem;padding-bottom:.125rem">+62</span>
                            <label for="phone" class="sr-only">Phone</label>
                            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Mobile number" required>
                        </section>
                        @if ($errors->has('phone'))
                            <section class="form-control-feedback">{{ $errors->first('phone') }}</section>
                        @endif
                    </fieldset>
                    <fieldset class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <section class="form-control-feedback">{{ $errors->first('password') }}</section>
                        @endif
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="password-confirm" class="sr-only">Confirm password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
                    </fieldset>
                    <fieldset class="form-group{{ $errors->has('referral') ? ' has-danger' : '' }}">
                        <label for="referral" class="form-text medium-small text-grey" style="line-height:1.3!important;">Enter the company reference code if applicable, otherwise leave it empty</label>
                        <input id="referral" type="text" class="form-control" name="referral" value="{{ old('referral') }}" placeholder="Referral code" aria-describedby="referralHelpText">
                        <section class="form-text medium-small text-grey" id="referralHelpText">Max: 3 characters, e.g : 001</section>
                        @if ($errors->has('referral'))
                            <section class="form-control-feedback">{{ $errors->first('referral') }}</section>
                        @endif
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
                                <small class="form-text lh-1-2 text-muted" id="captchaHelp">Enter security code</small>
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
            <footer class="col-md-12">
                <p class="d-flex justify-content-between medium mb-0">
                    <span>Already have an account ?</span>
                    <a href="{{ url('/login') }}">Sign In here</a>
                </p>
            </footer>
        </section>
    </article>
    @component('components.footer')
    @endcomponent
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
