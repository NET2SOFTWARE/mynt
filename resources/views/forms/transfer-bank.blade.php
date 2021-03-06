<section class="form-group row{{ $errors->has('sender') ? ' has-danger' : '' }}">
    <label for="sender" class="col-sm-4 col-form-label">From</label>
    <section class="col-sm-8">
        <input id="sender" name="sender" class="form-control disabled" value="{{ Auth::user()->members->first()['accounts'][0]['number'] }}" placeholder="Sender account number" aria-describedby="senderHelp" readonly>
        @if ($errors->has('sender'))<span class="form-control-feedback">{{ $errors->first('sender') }}</span>@endif
        <small class="form-text small text-muted d-flex justify-content-between" id="senderHelp">Your account number. <span class="text-grey">Required</span></small>
    </section>
</section>
    <label for="bank" class="col-sm-4 col-form-label">To</label>
    <section class="col-sm-8">
        <select id="bank" name="bank" class="custom-select w-100" aria-describedby="bankHelp" required>
            <option selected disabled>Choose bank`s account</option>
            @foreach($remittances as $index)
                <option value="{{ $index->id }}"{{ (old('bank') == $index->id) ? ' selected' : '' }}>{{ strtoupper($index->bank->bank_name). ' - '. $index->accountid1 }}</option>
            @endforeach
        </select>
        @if ($errors->has('bank'))<span class="form-control-feedback">{{ $errors->first('bank') }}</span>@endif
        <small class="form-text small text-muted d-flex justify-content-between" id="bankHelp"><span>If the bank account is not yet registered, please register first.</span><span class="text-grey ml-3">Required</span></small>
    </section>
</section>
<section class="form-group row">
    <label for="bank_code" class="col-sm-4 col-form-label">Bank name</label>
    <section class="col-sm-8">
        <select id="bank_code" name="bank_code" class="custom-select w-100" aria-describedby="bankCodeHelp">
            <option selected disabled>Choose bank</option>
            @foreach($banks as $bank)
                <option value="{{ $bank->bank_code }}">{{ $bank->bank_code. '&#32;' .strtoupper($bank->bank_name) }}</option>
            @endforeach
        </select>
        <small class="form-text small text-muted d-flex justify-content-between" id="bankCodeHelp"><span>Please choose one bank.</span><span class="text-grey ml-3">Required</span></small>
    </section>
</section>

<section class="form-group row{{ $errors->has('amount') ? ' has-danger' : '' }}">
    <label for="amount" class="col-sm-4 col-form-label">Amount</label>
    <section class="col-sm-8">
        <input id="amount" name="amount" class="form-control disabled" value="{{ old('amount') }}" placeholder="00000" aria-describedby="amountHelp" required>
        @if ($errors->has('amount'))<span class="form-control-feedback">{{ $errors->first('amount') }}</span>@endif
        <small class="form-text small text-muted d-flex justify-content-between" id="amountHelp">Amount transfer, min. 500 <span class="text-grey">Required</span></small>
    </section>
</section>

<section class="form-group row{{ $errors->has('purposecode') ? ' has-danger' : '' }}">
    <label for="purposecode" class="col-sm-4 col-form-label">Purpose</label>
    <section class="col-sm-8">
        <select id="purposecode" name="purposecode" class="custom-select w-100" aria-describedby="purposecodeHelp">
            <option selected disabled>Choose one of purpose</option>
            <option value="1">Business</option>
            <option value="2">Non-Business - Education</option>
            <option value="3">Non-Business - Other</option>
        </select>
        @if ($errors->has('purposecode'))<span class="form-control-feedback">{{ $errors->first('purposecode') }}</span>@endif
        <small class="form-text text-muted d-flex justify-content-between" id="purposecodeHelp">Please choose one of purpose from the list. <span class="text-grey">Required</span></small>
    </section>
</section>

<section class="form-group row{{ $errors->has('purposedesc') ? ' has-danger' : '' }}">
    <label for="purposedesc" class="col-sm-4 col-form-label">Purpose description</label>
    <section class="col-sm-8">
        <textarea id="purposedesc" name="purposedesc" class="form-control" rows="3" placeholder="Purpose description" aria-describedby="purposedescHelp"></textarea>
        @if ($errors->has('purposedesc'))<span class="form-control-feedback">{{ $errors->first('purposedesc') }}</span>@endif
        <small class="form-text text-muted d-flex justify-content-between" id="purposedescHelp">Purpose description. <span class="text-grey">Required</span></small>
    </section>
</section>

<section class="form-group row{{ $errors->has('token') ? ' has-danger' : '' }}">
    <label for="token" class="col-sm-4 col-form-label">Token</label>
    <section class="col-sm-8">
        <section class="d-flex justify-content-between">
            <input name="token" class="form-control" id="token" value="{{ old('token') }}" placeholder="Token transaction" aria-describedby="tokenHelp" style="display: inline-block; width: 70%;" required>
            <a class="btn btn-primary" href="{{ route('generate.token', [Auth::user()->members->first()['accounts'][0]['number']]) }}">Generate</a>
        </section>
        @if ($errors->has('token'))<span class="form-control-feedback">{{ $errors->first('token') }}</span>@endif
        <small class="form-text text-muted d-flex justify-content-between" id="tokenHelp">Request new transaction token first. <span class="text-grey">Required</span></small>
    </section>
</section>

<section class="form-group row{{ $errors->has('captcha') ? ' has-danger' : '' }}">
    <label for="captcha" class="col-sm-4 col-form-label">Security code</label>
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
                    <input id="captcha" class="form-control" name="captcha" value="{{ old('captcha') }}" placeholder="Captcha code" aria-describedby="captchaHelp" required>
                </section>
                @if ($errors->has('captcha'))<span class="form-control-feedback">{{ $errors->first('captcha') }}</span>@endif
                <small class="form-text lh-1-2 text-muted d-flex justify-content-between" id="captchaHelp">Enter security code <span class="text-grey">Required</span></small>
            </section>
        </section>
    </section>
</section>
<section class="form-group row mt-4">
    <section class="col-sm-8 offset-sm-4">
        <button class="btn btn-block btn-primary">Process</button>
    </section>
</section>