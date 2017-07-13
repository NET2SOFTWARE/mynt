<section class="row">
    <section class="col-sm-6 col-md-6">
        <section class="form-group{{ $errors->has('bank') ? ' has-danger' : '' }}">
            <label for="bank">Bank</label>
            <select id="bank" name="bank" class="custom-select w-100">
                <option selected disabled>Choose one bank</option>
                @foreach($banks as $bank)
                    <option value="{{ $bank->id }}"{{ collect(Auth::user()->members->first()['banks'])->contains('id', $bank->id) ? ' selected' : '' }}>{{ $bank->bank_code.'&nbsp;&nbsp;&nbsp;'.strtoupper($bank->bank_name) }}</option>
                @endforeach
            </select>
            <small class="form-text small text-muted d-flex justify-content-between" id="bankHelp">Please choose one bank. <span class="text-grey">Required</span></small>
            @if ($errors->has('bank'))<span class="form-control-feedback">{{ $errors->first('bank') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('account_number') ? ' has-danger' : '' }}">
            <label for="account_number">Bank account number</label>
            <input id="account_number" type="text" name="account_number" class="form-control" placeholder="000000000000" aria-describedby="accountNumberHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="accountNumberHelp">Please entry your bank account number. Numeric only <span class="text-grey">Required</span></small>
            @if ($errors->has('bank_account_name'))<span class="form-control-feedback">{{ $errors->first('bank_account_name') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
            <label for="name">Bank account name</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Bank account name" aria-describedby="nameHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="nameHelp">Please entry your bank account name. Max: 40 <span class="text-grey">Required</span></small>
            @if ($errors->has('name'))<span class="form-control-feedback">{{ $errors->first('name') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
            <label for="phone">Phone number</label>
            <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Phone number" aria-describedby="phoneHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="phoneHelp">Valid phone number format, Eg. 62081xxxxx <span class="text-grey">Required</span></small>
            @if ($errors->has('phone'))<span class="form-control-feedback">{{ $errors->first('phone') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
            <label for="email">E-mail address</label>
            <input id="email" type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="E-mail address" aria-describedby="emailHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="emailHelp">Email address format, Eg. example&amp;email.com <span class="text-grey">Required</span></small>
            @if ($errors->has('email'))<span class="form-control-feedback">{{ $errors->first('email') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('birthplace') ? ' has-danger' : '' }}">
            <label for="birthplace">Birthplace</label>
            <input id="birthplace" type="text" name="birthplace" class="form-control" value="{{ old('birthplace') }}" placeholder="Birth place" aria-describedby="birthplaceHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="birthplaceHelp">Birth place, Eg. Sibolga <span class="text-grey">Required</span></small>
            @if ($errors->has('birthplace'))<span class="form-control-feedback">{{ $errors->first('birthplace') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('birthdate') ? ' has-danger' : '' }}">
            <label for="birthdate">Birth date</label>
            <input id="birthdate" type="text" name="birthdate" class="form-control" value="{{ old('birthdate') }}" placeholder="0000-00-00" aria-describedby="birthplaceHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="birthdateHelp">Birth date format, Eg. 1990-04-23 <span class="text-grey">Required</span></small>
            @if ($errors->has('birthdate'))<span class="form-control-feedback">{{ $errors->first('birthdate') }}</span>@endif
        </section>
        <section class="form-group mb-0 {{ $errors->has('identitynumber') ? ' has-danger' : '' }}">
            <label for="identitynumber">Identity number</label>
            <input id="identitynumber" type="text" name="identitynumber" class="form-control" value="{{ old('identitynumber') }}" placeholder="Identity number" aria-describedby="identityNumberHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="identityNumberHelp">Identity (KTP/PASSPORT) number. <span class="text-grey">Required</span></small>
            @if ($errors->has('identitynumber'))<span class="form-control-feedback">{{ $errors->first('identitynumber') }}</span>@endif
        </section>
    </section>
    <section class="col-sm-6 col-md-6">
        <section class="form-group{{ $errors->has('occupation') ? ' has-danger' : '' }}">
            <label for="occupation">Occupation</label>
            <input id="occupation" type="text" name="occupation" class="form-control" value="{{ old('occupation') }}" placeholder="Occupation" aria-describedby="occupationHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="occupationHelp">Occupation, numeric only Eg. 0101011xxxx <span class="text-grey">Required</span></small>
            @if ($errors->has('occupation'))<span class="form-control-feedback">{{ $errors->first('occupation') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
            <label for="address">Address street</label>
            <textarea id="address" name="address" rows="3" class="form-control" placeholder="Address street" aria-describedby="addressHelp" required>{{ old('address') }}</textarea>
            <small class="form-text small text-muted d-flex justify-content-between" id="addressHelp">Valid address street <span class="text-grey">Required</span></small>
            @if ($errors->has('address'))<span class="form-control-feedback">{{ $errors->first('address') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('regency') ? ' has-danger' : '' }}">
            <label for="regency">Regency</label>
            <select id="regency" name="regency" class="custom-select w-100" aria-describedby="regencyHelp" required>
                <option selected disabled>Choose one regency</option>
                @foreach($regencies as $regency)
                    <option value="{{ $regency->id }}">{{ ucwords($regency->name) }}</option>
                @endforeach
            </select>
            <small class="form-text small text-muted d-flex justify-content-between" id="regencyHelp">Please choose one of regency <span class="text-grey">Required</span></small>
            @if ($errors->has('regency'))<span class="form-control-feedback">{{ $errors->first('regency') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('province') ? ' has-danger' : '' }}">
            <label for="province">Province</label>
            <select id="province" name="province" class="custom-select w-100" aria-describedby="provinceHelp" required>
                <option selected disabled>Choose one province</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}">{{ ucwords($province->name) }}</option>
                @endforeach
            </select>
            <small class="form-text small text-muted d-flex justify-content-between" id="provinceHelp">Please choose one of province <span class="text-grey">Required</span></small>
            @if ($errors->has('province'))<span class="form-control-feedback">{{ $errors->first('province') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
            <label for="country">Country</label>
            <input id="country" type="text" name="country" class="form-control" value="{{ old('country') }}" placeholder="Country code" aria-describedby="countryHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="countryHelp">Please choose one of province <span class="text-grey">Required</span></small>
            @if ($errors->has('country'))<span class="form-control-feedback">{{ $errors->first('country') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('fundresource') ? ' has-danger' : '' }}">
            <label for="fundresource">Country</label>
            <textarea id="fundresource" name="fundresource" class="form-control" rows="3" placeholder="Fund resource">{{ old('fundresource') }}</textarea>
            <small class="form-text small text-muted d-flex justify-content-between" id="countryHelp">Please choose one of province <span class="text-grey">Required</span></small>
            @if ($errors->has('country'))<span class="form-control-feedback">{{ $errors->first('country') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('captcha') ? ' has-danger' : '' }}">
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
        </section>
    </section>
</section>
<section class="mt-5">
    <button class="btn btn-block btn-primary" type="submit" role="button">Register bank account</button>
</section>