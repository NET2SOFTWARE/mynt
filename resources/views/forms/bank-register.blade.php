<section class="row">
    <section class="col-sm-6 col-md-6">
        <section class="form-group{{ $errors->has('referral') ? ' has-danger' : '' }}">
            <label for="referral" class="sr-only">Account number</label>
            <input id="referral" name="referral" value="{{ $referral }}" class="form-control" readonly>
        </section>
        <section class="form-group{{ $errors->has('mynt_account_number') ? ' has-danger' : '' }}">
            <label for="mynt_account_number" class="sr-only">Account number</label>
            <input id="mynt_account_number" name="mynt_account_number" value="{{ $mynt_acc_num }}" class="form-control" readonly>
        </section>
        <section class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
            <label for="name" class="sr-only">Name</label>
            <input id="name" name="name" class="form-control" value="{{ ucwords(Auth::user()->name) }}" readonly>
        </section>
        <section class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
            <label for="phone" class="sr-only">Phone number</label>
            <section class="input-group">
                <span class="input-group-addon medium-small lh-1-5" style="padding-top:.125rem;padding-bottom:.125rem">+62</span>
                <input id="phone" class="form-control" name="phone" value="{{ Auth::user()->phone }}" placeholder="Mobile number" readonly>
            </section>
        </section>
        <section class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
            <label for="email" class="sr-only">E-mail address</label>
            <input id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
        </section>
        <section class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
            <label for="address">Address</label>
            <textarea id="address" name="address" class="form-control" rows="2" placeholder="Address" aria-describedby="addressHelp"></textarea>
            @if ($errors->has('address'))<span class="form-control-feedback">{{ $errors->first('address') }}</span>@endif
            <small class="form-text small text-muted d-flex justify-content-between" id="addressHelp">Complete address, max. 100 characters <span class="text-grey">Required</span></small>
        </section>
        <section class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
            <label for="country">Country</label>
            <select id="country" name="country" class="custom-select w-100" aria-describedby="countryHelp">
                <option selected disabled>Choose one country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->iso }}">{{ ucwords($country->name) }}</option>
                @endforeach
            </select>
            <small class="form-text small text-muted d-flex justify-content-between" id="countryHelp">Please choose one of country <span class="text-grey">Optional</span></small>
            @if ($errors->has('country'))<span class="form-control-feedback">{{ $errors->first('country') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('birthdate') ? ' has-danger' : '' }}">
            <label for="birthdate">Birth date</label>
            <section id="born-date">
                <input id="birthdate" name="birthdate" class="form-control" value="{{ old('birthdate') }}" placeholder="00-00-0000" aria-describedby="birthDateHelp">
            </section>
            <small class="form-text small text-muted d-flex justify-content-between" id="birthdateHelp">Birth date format, Eg. 1990-04-23 <span class="text-grey">Required</span></small>
            @if ($errors->has('birthdate'))<span class="form-control-feedback">{{ $errors->first('birthdate') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('birthplace') ? ' has-danger' : '' }}">
            <label for="birthplace">Birth Place</label>
            <input id="birthplace" name="birthplace" class="form-control" value="{{ old('birthplace') }}" placeholder="Birth place" aria-describedby="birthPlaceHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="birthplaceHelp">Birth place, Eg. Sibolga <span class="text-grey">Optional</span></small>
            @if ($errors->has('birthplace'))<span class="form-control-feedback">{{ $errors->first('birthplace') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('occupation') ? ' has-danger' : '' }}">
            <label for="occupation">Occupation</label>
            <select id="occupation" name="occupation" class="custom-select w-100" aria-describedby="occupationHelp" required>
                <option selected disabled>Choose one occupation</option>
                <option value="businessman">Businessman</option>
                <option value="employee">Employee</option>
                <option value="supervisor">Supervisor</option>
                <option value="manager">Manager</option>
                <option value="director">Director</option>
            </select>
            <small class="form-text small text-muted d-flex justify-content-between" id="occupationHelp">Please choose one occupation <span class="text-grey">Required</span></small>
            @if ($errors->has('occupation'))<span class="form-control-feedback">{{ $errors->first('occupation') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('citizenship') ? ' has-danger' : '' }}">
            <label for="birthplace">Citizenship</label>
            <input id="citizenship" name="citizenship" class="form-control" value="{{ old('citizenship') }}" placeholder="Citizenship" aria-describedby="citizenshipHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="citizenshipHelp">Eg. Indonesia <span class="text-grey">Required</span></small>
            @if ($errors->has('citizenship'))<span class="form-control-feedback">{{ $errors->first('citizenship') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('idnumber') ? ' has-danger' : '' }}">
            <label for="idnumber">Identity I.D Number</label>
            <input id="idnumber" name="idnumber" class="form-control" value="{{ old('idnumber') }}" placeholder="Identity I.D number" aria-describedby="idnumberHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="idnumberHelp">KTP | Passport number <span class="text-grey">Required</span></small>
            @if ($errors->has('idnumber'))<span class="form-control-feedback">{{ $errors->first('idnumber') }}</span>@endif
        </section>
    </section>

    <section class="col-sm-6 col-md-6">
        <section class="form-group{{ $errors->has('bank') ? ' has-danger' : '' }}">
            <label for="bank">Bank</label>
            <select id="bank" name="bank" class="custom-select w-100" required aria-describedby="bankHelp">
                <option selected disabled>Choose bank</option>
                @foreach($banks as $bank)
                    <option value="{{ $bank->bank_code }}"{{ collect(Auth::user()->members->first()['banks'])->contains('id', $bank->id) ? ' selected' : '' }}>{{ $bank->bank_code.'&nbsp;&nbsp;&nbsp;'.strtoupper($bank->bank_name) }}</option>
                @endforeach
            </select>
            <small class="form-text small text-muted d-flex justify-content-between" id="bankHelp">Please choose one bank. <span class="text-grey">Required</span></small>
            @if ($errors->has('bank'))<span class="form-control-feedback">{{ $errors->first('bank') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('bank_account_name') ? ' has-danger' : '' }}">
            <label for="bank_account_name">Bank account name</label>
            <input id="bank_account_name" name="bank_account_name" class="form-control" value="{{ old('bank_account_name') }}" placeholder="Bank account name" aria-describedby="bankAccountNameHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="bankAccountNameHelp">Please entry your valid bank account name <span class="text-grey">Required</span></small>
            @if ($errors->has('bank_account_name'))<span class="form-control-feedback">{{ $errors->first('bank_account_name') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('account_number') ? ' has-danger' : '' }}">
            <label for="account_number">Bank account number</label>
            <input id="account_number" name="account_number" class="form-control" value="{{ old('account_number') }}" placeholder="000000000000" aria-describedby="bankAccountNumberHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="accountNumberHelp">Please entry your bank account number. Numeric only <span class="text-grey">Required</span></small>
            @if ($errors->has('bank_account_name'))<span class="form-control-feedback">{{ $errors->first('bank_account_name') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('relationship') ? ' has-danger' : '' }}">
            <label for="relationship">What is your relationship with the owner of this bank account ?</label>
            <select id="relationship" name="relationship" class="custom-select w-100" aria-describedby="relationshipHelp" required>
                <option selected disabled>Choose relationship</option>
                <option value="owner">Owner</option>
                <option value="owner">Family</option>
                <option value="owner">Business partner</option>
                <option value="owner">Other partner</option>
            </select>
            <small class="form-text small text-muted d-flex justify-content-between" id="relationshipHelp">Please choose one of partnership <span class="text-grey">Required</span></small>
            @if ($errors->has('relationship'))<span class="form-control-feedback">{{ $errors->first('relationship') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('regency') ? ' has-danger' : '' }}">
            <label for="regency">Regency of the bank where the account is registered.</label>
            <select id="regency" name="regency" class="custom-select w-100" aria-describedby="regencyHelp" required>
                <option selected disabled>Choose one regency</option>
                <option value="tna">Kota ADM Jakarta Pusat</option>
                <option value="tjp">Kota ADM Jakarta Utara</option>
                <option value="ggp">Kota ADM Jakarta Barat</option>
                <option value="kyb">Kota ADM Jakarta Selatan</option>
                <option value="ckg">Kota ADM Jakarta Timur</option>
                <option value="cbi">Kab. Bogor</option>
                <option value="ckr">Kab. Bekasi</option>
                <option value="tgr">Kab. Tangerang</option>
                <option value="dpk">Kota Depok</option>
            </select>
            <small class="form-text small text-muted d-flex justify-content-between" id="regencyHelp">Please choose one of regency <span class="text-grey">Required</span></small>
            @if ($errors->has('regency'))<span class="form-control-feedback">{{ $errors->first('regency') }}</span>@endif
        </section>
        <section class="form-group{{ $errors->has('fundresource') ? ' has-danger' : '' }}">
            <label for="fundresource">Fund resource</label>
            <textarea id="fundresource" name="fundresource" class="form-control" rows="4" placeholder="Fund resource" aria-describedby="fundresourceHelp"></textarea>
            @if ($errors->has('fundresource'))<span class="form-control-feedback">{{ $errors->first('fundresource') }}</span>@endif
            <small class="form-text small text-muted d-flex justify-content-between" id="fundresourceHelp">Fund resource description, max. 50 characters <span class="text-grey">Required</span></small>
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
                        <input id="captcha" class="form-control" name="captcha" value="{{ old('captcha') }}" placeholder="Captcha code" aria-describedby="captchaHelp" required>
                    </section>
                    <small class="form-text lh-1-2 text-muted d-flex justify-content-between" id="captchaHelp">Enter security code <span class="text-grey">Required</span></small>
                    @if ($errors->has('captcha'))<span class="form-control-feedback">{{ $errors->first('captcha') }}</span>@endif
                </section>
            </section>
        </section>
    </section>
</section>
<hr/>
<section class="mt-5">
    <button class="btn btn-block btn-primary">Register bank account</button>
</section>