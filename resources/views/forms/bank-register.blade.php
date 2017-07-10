<section class="row">
    <section class="col-sm-6 col-md-6">
        <section class="form-group{{ $errors->has('bank') ? ' has-danger' : '' }}">
            <label for="bank">Bank</label>
            <select id="bank" name="bank" class="custom-select w-100">
                <option selected disabled>Choose bank</option>
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
        <section class="form-group{{ $errors->has('identitynumber') ? ' has-danger' : '' }}">
            <label for="identitynumber">Birth date</label>
            <input id="identitynumber" type="text" name="identitynumber" class="form-control" value="{{ old('identitynumber') }}" placeholder="Identity number" aria-describedby="identityNumberHelp">
            <small class="form-text small text-muted d-flex justify-content-between" id="identityNumberHelp">Identity (KTP/PASSPORT) number. <span class="text-grey">Required</span></small>
            @if ($errors->has('identitynumber'))<span class="form-control-feedback">{{ $errors->first('identitynumber') }}</span>@endif
        </section>
    </section>
    <section class="col-sm-6 col-md-6">
        <section class="form-group{{ $errors->has('occupation') ? ' has-danger' : '' }}">
            <label for="occupation">Birth date</label>
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
                <option selected disabled>Choose regency</option>
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
                <option selected disabled>Choose regency</option>
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
    </section>
</section>