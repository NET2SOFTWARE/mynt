<fieldset class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
    <label for="old_password" class="sr-only">Old Password</label>
    <input id="old_password" type="password" class="form-control" name="old_password" value="{{ $email or old('old_password') }}" placeholder="Old password" required autofocus>
    @if ($errors->has('old_password'))<section class="form-control-feedback">{{ $errors->first('old_password') }}</section>@endif
    <small class="form-text small text-muted d-flex justify-content-between" id="phoneHelp">Please insert your old password <span class="text-grey">Required</span></small>
</fieldset>
<fieldset class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
    <label for="password" class="sr-only">New password</label>
    <input id="password" type="password" class="form-control" name="password" placeholder="New password" required>
    @if ($errors->has('password'))<section class="form-control-feedback">{{ $errors->first('password') }}</section>@endif
    <small class="form-text small text-muted d-flex justify-content-between" id="phoneHelp">New password, alphanumeric, min.6-16 characters long <span class="text-grey">Required</span></small>
</fieldset>
<fieldset class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    <label for="password-confirm" class="sr-only">Confirm new password</label>
    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
    @if ($errors->has('password_confirmation'))<section class="form-control-feedback">{{ $errors->first('password_confirmation') }}</section>@endif
</fieldset>
{{-- <fieldset class="form-group{{ $errors->has('captcha') ? ' has-danger' : '' }}">
    <label for="amount" class="col-form-label">Security code</label>
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
</fieldset> --}}
<fieldset class="form-group mt-5 mb-0">
    <button type="submit" class="btn btn-block btn-primary" role="button">Change password</button>
</fieldset>