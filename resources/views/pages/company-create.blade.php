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
                                            <label for="phone">Phone</label>
                                            <div class="input-group">
                                                <span class="input-group-addon medium-small lh-1-5" style="padding-top:.125rem;padding-bottom:.125rem">+62</span>
                                                <input id="phone" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Mobile number" required>
                                            </div>
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

                                        <div class="card card-block p-0 mb-2">
                                            <table class="table mb-0">
                                                <thead class="thead-default">
                                                    <tr>
                                                        <th>Type</th>
                                                        <th colspan="2">Document</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="document_list" class="small" style="vertical-align: middle;">
                                                    <tr id="document_first_row">
                                                        <td colspan="3" class="bg-faded text-muted text-center">
                                                            <p class="lead m-0 small-caps">empty</p>
                                                            <p class="mb-2">There is no uploaded document yet</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-5">
                                                <fieldset class="form-group">
                                                    <label>Type</label>
                                                    <select id="document_type" class="custom-select w-100">
                                                        <option value="" selected disabled>Choose one document type</option>
                                                        <option value="ANDAL">ANDAL</option>
                                                        <option value="IMB">IMB</option>
                                                        <option value="NPWP">NPWP</option>
                                                        <option value="NRP">NRP</option>
                                                        <option value="NRB">NRB</option>
                                                        <option value="SITU">SITU</option>
                                                        <option value="SIUP">SIUP</option>
                                                        <option value="SKDU">SKDU</option>
                                                        <option value="TDP">TDP</option>
                                                    </select>
                                                    <small class="form-text text-muted d-flex justify-content-between">
                                                        Please choose one document type <span class="text-grey">Optional</span>
                                                    </small>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-5">
                                                <fieldset class="form-group">
                                                    <label>Document</label>
                                                    <section class="clearfix">
                                                        <label class="custom-file w-100" style="height: 34px;">
                                                            <input type="file" id="document_file" class="custom-file-input">
                                                            <span id="document_extra" class="custom-file-control h-100 extra" style="padding: 6px 12px;"></span>
                                                        </label>
                                                    </section>
                                                    <small class="form-text text-muted d-flex justify-content-between">
                                                        Please insert company document <span class="text-grey">Optional</span>
                                                    </small>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" role="button" class="btn btn-secondary btn-block btn-sm small-caps" style="margin-top: 31px; padding: 4px;" id="document_add">
                                                    add
                                                </button>
                                            </div>
                                        </div>

                                        <h6 class="mb-0 medium-small text-warning mt-4">COMPANY PIC</h6>
                                        <section><hr/></section>

                                        <div class="card card-block p-0 mb-2">
                                            <table class="table mb-0">
                                                <thead class="thead-default">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th colspan="2">Position</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="pic_list" class="small" style="vertical-align: middle;">
                                                    <tr id="pic_first_row">
                                                        <td colspan="5" class="bg-faded text-muted text-center">
                                                            <p class="lead m-0 small-caps">empty</p>
                                                            <p class="mb-2">There is no PIC yet</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-5">
                                                <fieldset class="form-group">
                                                    <label>Name</label>
                                                    <input id="pic_name" class="form-control" type="text">
                                                    <small class="form-text text-muted d-flex justify-content-between">
                                                        Please type PIC name <span class="text-grey">Optional</span>
                                                    </small>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-5">
                                                <fieldset class="form-group">
                                                    <label>Email</label>
                                                    <input id="pic_email" class="form-control" type="text">
                                                    <small class="form-text text-muted d-flex justify-content-between">
                                                        Please type PIC email <span class="text-grey">Optional</span>
                                                    </small>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" role="button" class="btn btn-secondary btn-block btn-sm small-caps" style="margin-top: 31px; padding: 4px;" id="pic_add" tabindex="-1">
                                                    add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <fieldset class="form-group">
                                                    <label>Phone</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon medium-small lh-1-5" style="padding-top:.125rem;padding-bottom:.125rem">+62</span>
                                                        <input id="pic_phone" class="form-control" type="text">
                                                    </div>
                                                    <small class="form-text text-muted d-flex justify-content-between">
                                                        Please type PIC phone <span class="text-grey">Optional</span>
                                                    </small>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-5">
                                                <fieldset class="form-group">
                                                    <label>Position</label>
                                                    <select id="pic_position" class="custom-select w-100">
                                                        <option value="" selected disabled>Choose one PIC position</option>
                                                        @foreach($positions as $position)
                                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-muted d-flex justify-content-between">
                                                        Please choose PIC position <span class="text-grey">Optional</span>
                                                    </small>
                                                </fieldset>
                                            </div>
                                        </div>
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
    
    var $documentAdd = $('#document_add');
    var $documentList = $('#document_list');
    var $documentFirstRow = $('#document_first_row');
    var documents = [];
    var documentIndex = 0;

    var $picAdd = $('#pic_add');
    var $picList = $('#pic_list');
    var $picFirstRow = $('#pic_first_row');
    var pics = [];
    var picIndex = 0;

    $code.on('input', function (e) { checkAvalibility(); });

    $documentAdd.on('click', function() {
        var $type = $('#document_type');
        var $file = $('#document_file');
        var $name = $('#document_extra');

        if ($type.val() && $file.val())
        {
            documents.push({
                type : $type,
                file : $file
            });

            $documentFirstRow.hide();

            var html = '';
                html += '<tr>';
                html += '<td>'+ $type.val() +'</td>';
                html += '<td>'+ $name.attr('data-file-name') +'</td>';
                html += '<td class="text-right" style="padding: 6px;">';
                html += '<button type="button" role="button" class="btn btn-sm btn-danger" data-delete="'+ documentIndex +'">';
                html += '<i class="fa fa-trash"></i>';
                html += '</button>';
                html += '</td>';
                html += '</tr>';
            
            var $row = $(html).appendTo($documentList);

            $row.find('button').on('click', function (e) {
                $btn = $(this);

                $type.remove();
                $file.remove();
                documents.splice(documents.indexOf($btn.attr('data-delete')), 1);

                if (documents.length < 1) $documentFirstRow.show();
                
                $row.remove();
            });

            documentIndex++;

            var $cloneType = $type.clone(true);
            var $cloneFile = $file.clone(true);

            $type.hide().removeAttr('id').attr('name', 'document_type[]');
            $file.hide().removeAttr('id').attr('name', 'document_file[]');

            $name.attr('data-file-name', null).removeClass('changed');
            $cloneType.val('').insertAfter($type);
            $cloneFile.val('').insertAfter($file);
        } else {
            alert('Please select document type and file before adding document.')
        }
    });

    $picAdd.on('click', function() {
        var $pic_name = $('#pic_name');
        var $pic_email = $('#pic_email');
        var $pic_phone = $('#pic_phone');
        var $pic_position = $('#pic_position');
        var $pic_position_text = $('#pic_position option:selected').text();

        if ($pic_name.val() && $pic_email.val() && $pic_phone.val() && $pic_position.val())
        {
            pics.push({
                name : $pic_name,
                email : $pic_email,
                phone : $pic_phone,
                position : $pic_position
            });

            $picFirstRow.hide();

            var html = '';
                html += '<tr>';
                html += '<td>'+ $pic_name.val() +'</td>';
                html += '<td>'+ $pic_email.val() +'</td>';
                html += '<td>'+ $pic_phone.val() +'</td>';
                html += '<td>'+ $pic_position_text +'</td>';
                html += '<td class="text-right" style="padding: 6px;">';
                html += '<button type="button" role="button" class="btn btn-sm btn-danger" data-delete="'+ picIndex +'">';
                html += '<i class="fa fa-trash"></i>';
                html += '</button>';
                html += '</td>';
                html += '</tr>';
            
            var $row = $(html).appendTo($picList);

            $row.find('button').on('click', function (e) {
                $btn = $(this);

                $pic_name.remove();
                $pic_email.remove();
                $pic_phone.remove();
                $pic_position.remove();
                pics.splice(documents.indexOf($btn.attr('data-delete')), 1);

                if (pics.length < 1) $picFirstRow.show();
                
                $row.remove();
            });

            picIndex++;

            var $clone_pic_name = $pic_name.clone(true);
            var $clone_pic_email = $pic_email.clone(true);
            var $clone_pic_phone = $pic_phone.clone(true);
            var $clone_pic_position = $pic_position.clone(true);

            $pic_name.hide().removeAttr('id').attr('name', 'pic_name[]');
            $pic_email.hide().removeAttr('id').attr('name', 'pic_email[]');
            $pic_phone.hide().removeAttr('id').attr('name', 'pic_phone[]');
            $pic_position.hide().removeAttr('id').attr('name', 'pic_position[]');

            $clone_pic_name.val('').insertAfter($pic_name);
            $clone_pic_email.val('').insertAfter($pic_email);
            $clone_pic_phone.val('').insertAfter($pic_phone);
            $clone_pic_position.val('').insertAfter($pic_position);
        } else {
            alert('Please select PIC type and file before adding PIC.')
        }
    });

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
});
</script>
@endsection