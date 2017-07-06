@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'admin'])
    @endcomponent
@endsection

@section('content')
    <article class="container-fluid">
        <section class="row">
            @component('components.aside')
            @endcomponent
                <section class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2 p-0">
                    <section class="row">
                        <section class="col-sm-8 offset-sm-2 py-3">
                            <section class="mt-3 mb-5">
                                <section class="mb-4">
                                    <h4><small>Create new company</small></h4>
                                    <p class="small text-grey">Please insert with valid data.</p>
                                    @if (session('success'))<section class="alert alert-success">{{ session('success') }}</section>@endif
                                    @if (session('warning'))<section class="alert alert-danger">{{ session('warning') }}</section>@endif
                                </section>
                                <form class="mb-3" method="post" action="{{ route('company.store') }}" accept-charset="utf-8" enctype="multipart/form-data" role="form">
                                    {{ csrf_field() }}
                                    <section class="card card-block p-5">
                                        <h6 class="mb-0 medium-small text-warning">COMPANY DATA</h6>
                                        <section><hr/></section>
                                        <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label for="name">Name</label>
                                            <input id="name" name="name" class="form-control" value="{{ old('name')  }}" placeholder="Company name" type="text" aria-describedby="nameHelp">
                                            @if ($errors->has('name'))<section class="form-control-feedback">{{ $errors->first('name') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="nameHelp">Full company name. Max. 40 characters, eg. PT. Example <span class="text-grey">Required</span></small>
                                        </fieldset>
                                        <fieldset class="form-group{{ $errors->has('brand') ? ' has-danger' : '' }}">
                                            <label for="brand">Brand</label>
                                            <textarea id="brand" name="brand" class="form-control" rows="2" placeholder="Company brand" aria-describedby="brandHelp">{{ old('brand') }}</textarea>
                                            @if ($errors->has('brand'))<section class="form-control-feedback">{{ $errors->first('brand') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="brandHelp">Describe about company here or company brand or company slogan. <span class="text-grey">Optional</span></small>
                                        </fieldset>
                                        <fieldset class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <label for="email">Phone</label>
                                            <input id="phone" name="phone" class="form-control" value="{{ old('phone')  }}" placeholder="Phone number" type="text" aria-describedby="phoneHelp">
                                            @if ($errors->has('phone'))<section class="form-control-feedback">{{ $errors->first('phone') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="phoneHelp">Company contact number, numeric characters only. E.g : 021xxxxxx <span class="text-grey">Required</span></small>
                                        </fieldset>
                                        <fieldset class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                            <label for="website">Website</label>
                                            <input id="website" name="website" class="form-control" value="{{ old('website')  }}" placeholder="URL website" type="url" aria-describedby="websiteHelp">
                                            @if ($errors->has('website'))<section class="form-control-feedback">{{ $errors->first('website') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="websiteHelp">Company url website, numeric characters only. E.g : http or https://example.com <span class="text-grey">Optional</span></small>
                                        </fieldset>
                                        <fieldset class="form-group{{ $errors->has('industry_id') ? ' has-danger' : '' }}">
                                            <label for="industry_id">Institution</label>
                                            <select id="industry_id" name="industry_id" class="custom-select w-100" value="{{ old('industry_id') }}" aria-describedby="industryHelp">
                                                <option selected disabled>Choose one industry</option>
                                                @foreach($industries as $industry)
                                                    <option value="{{ $industry->id }}" {{ (old('industry_id') == $industry->id) ? ' selected' : '' }}>{{ $industry->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('industry_id'))<section class="form-control-feedback">{{ $errors->first('industry_id') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="industryHelp">Please choose one related of company industry <span class="text-grey">Required</span></small>
                                        </fieldset>
                                        <fieldset class="form-group{{ $errors->has('logo') ? ' has-danger' : '' }}">
                                            <label for="logo">Company logo</label>
                                            <section class="clearfix">
                                                <label class="custom-file w-100">
                                                    <input type="file" id="logo" name="logo" class="custom-file-input" aria-describedby="logoHelp">
                                                    <span class="custom-file-control"></span>
                                                </label>
                                            </section>
                                            @if ($errors->has('logo'))<section class="form-control-feedback">{{ $errors->first('logo') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="logoHelp">Please insert company logo <span class="text-grey">Optional</span></small>
                                        </fieldset>

                                        <h6 class="mb-0 medium-small text-warning mt-4">COMPANY PARTNERSHIP</h6>
                                        <section><hr/></section>
                                        <fieldset class="form-group{{ $errors->has('partnership_id') ? ' has-danger' : '' }}">
                                            <label for="partnership_id">Partnership</label>
                                            <select id="partnership_id" name="partnership_id[]" class="form-control w-100" placeholder="Company Partnership(s)" multiple="multiple">
                                                @foreach($partnerships as $partnership)
                                                    <option value="{{ $partnership->id }}">{{ $partnership->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('partnership_id'))<section class="form-control-feedback">{{ $errors->first('partnership_id') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="partnershipHelp">Please select one or more partnership <span class="text-grey">Required</span></small>
                                        </fieldset>

                                        <h6 class="mb-0 medium-small text-warning mt-4">COMPANY IDENTITY</h6>
                                        <section><hr/></section>
                                        <fieldset id="code-wrapper" class="form-group{{ $errors->has('code') ? ' has-danger' : '' }}">
                                            <label for="code">Company Referral Code</label>
                                            <input id="code" name="code" class="form-control" value="{{ old('code')  }}" placeholder="Referral code" type="number" min="0" maxlength="3" aria-describedby="codeHelp">
                                            @if ($errors->has('code'))<section class="form-control-feedback" id="check-message">{{ $errors->first('code') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="codeHelp">This code would be an identity of this company, please insert unique number. Max. 3 digits numeric only, e.g : 303 <span class="text-grey ml-5">Required</span></small>
                                        </fieldset>


                                        <h6 class="mb-0 medium-small text-warning mt-4">COMPANY CREDENTIAL</h6>
                                        <section><hr/></section>
                                        <fieldset class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label for="email">Email</label>
                                            <input id="email" name="email" class="form-control" value="{{ old('email')  }}" placeholder="E-mail address" type="email" aria-describedby="emailHelp">
                                            @if ($errors->has('email'))<section class="form-control-feedback">{{ $errors->first('email') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="emailHelp">Valid company email, max. 40 characters. E.g : dummy@example.com <span class="text-grey">Required</span></small>
                                        </fieldset>
                                        <fieldset class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                            <label for="password">Password</label>
                                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" aria-describedby="passwordHelp">
                                            @if ($errors->has('code'))<section class="form-control-feedback">{{ $errors->first('code') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="passwordHelp">Insert unique new company password. Min. 6~16 alpha numeric character. <span class="text-grey ml-5">Required</span></small>
                                        </fieldset>
                                        <fieldset class="form-group">
                                            <label for="password-confirm">Confirm password</label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" aria-describedby="confirmPasswordHelp">
                                            <small class="form-text text-muted d-flex justify-content-between" id="confirmPasswordHelp">Re-type company password <span class="text-grey ml-5">Required</span></small>
                                        </fieldset>


                                        <h6 class="mb-0 medium-small text-warning mt-4">COMPANY DOCUMENTS</h6>
                                        <section><hr/></section>
                                        <fieldset class="form-group{{ $errors->has('logo') ? ' has-danger' : '' }}">
                                            <label for="documents">Document</label>
                                            <section class="clearfix dropzone" id="document-dropzone" url="#">
                                                {{-- <div class="dropzone-previews"></div> --}}
                                                <div class="fallback">
                                                    <input name="documents" type="file" multiple />
                                                </div>
                                                {{-- <label class="custom-file w-100">
                                                    <input type="file" id="documents" name="documents" class="custom-file-input" aria-describedby="documentsHelp">
                                                    <span class="custom-file-control"></span>
                                                </label> --}}
                                            </section>
                                            @if ($errors->has('documents'))<section class="form-control-feedback">{{ $errors->first('documents') }}</section>@endif
                                            <small class="form-text text-muted d-flex justify-content-between" id="documentsHelp">Please insert company documents <span class="text-grey">Optional</span></small>
                                        </fieldset>
                                    </section>
                                    <section class="form-group mt-4">
                                        <a href="{{ route('company.index', ['all']) }}" class="btn btn-secondary">Back to Company</a>
                                        <button type="submit" class="btn btn-primary float-right" role="button">Save Company</button>
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
<script>
$(function(){
    var $code = $('#code');
    var $codeWrapper = $('#code-wrapper');
    var $checkMessage = $('#check-message');

    $code.on('input', function (e) { checkAvalibility(); });

    function checkAvalibility() {
        if ($code.val())
        {
            $.getJSON('{{ route('api.company.check') }}/' + $code.val(), function (data) {
                if (data.status == true) markAvailable(); else markUnavailable();
            });
        } else {
            markUnavailable();
        }
    }

    function markAvailable() {
        $codeWrapper
            .removeClass('has-danger')
            .addClass('has-success');

        if ($checkMessage.length < 1)
        {
            $checkMessage = $('<section class="form-control-feedback" id="check-message" />');
            $checkMessage.insertBefore('#codeHelp');
        }

        $checkMessage.html('Referral code `'+ $code.val() +'` is available.');
    }

    function markUnavailable() {
        $codeWrapper
            .removeClass('has-success')
            .addClass('has-danger');

        if ($checkMessage.length < 1)
        {
            $checkMessage = $('<section class="form-control-feedback" id="check-message" />');
            $checkMessage.insertBefore('#codeHelp');
        }

        if ($code.val()) $checkMessage.html('Referral code `'+ $code.val() +'` is unavailable.');
        else $checkMessage.html('Referral code cannot be empty.');
    }

    // Dropzone.options.documentDropzone = false;
    // $("#document-dropzone").dropzone({
    // // Dropzone.options.documentDropzone = { // The camelized version of the ID of the form element
    //     url: '#',
    //     // The configuration we've talked about above
    //     autoProcessQueue: false,
    //     uploadMultiple: true,
    //     parallelUploads: 100,
    //     maxFiles: 100,

    //     // The setting up of the dropzone
    //     init: function() {
    //         var myDropzone = this;

    //         // First change the button to actually tell Dropzone to process the queue.
    //         this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
    //           // Make sure that the form isn't actually being sent.
    //           e.preventDefault();
    //           e.stopPropagation();
    //           myDropzone.processQueue();
    //         });

    //         // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
    //         // of the sending event because uploadMultiple is set to true.
    //         this.on("sendingmultiple", function() {
    //           // Gets triggered when the form is actually being sent.
    //           // Hide the success button or the complete form.
    //         });
    //         this.on("successmultiple", function(files, response) {
    //           // Gets triggered when the files have successfully been sent.
    //           // Redirect user or notify of success.
    //         });
    //         this.on("errormultiple", function(files, response) {
    //           // Gets triggered when there was an error sending the files.
    //           // Maybe show form again, and notify user of error
    //         });
    //     },
    //     sending: function(file, xhr, formData) {
    //         var formValues = $('form').serializeObject()
    //         $.each(formValues, function(key, value){
    //             formData.append(key,value);
    //         });
    //     }
    // });
});
</script>
@endsection