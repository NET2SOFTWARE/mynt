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
                    @component('components.aside-member-register', ['active' => ''])@endcomponent
                @else
                    @component('components.aside-member-unregister', ['active' => ''])@endcomponent
                @endif
            @else
                @component('components.aside-member-child', ['active' => ''])@endcomponent
            @endif
            <section class="col-md-9 py-3">
                <h6 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">
                    Upgrade Account
                    <span>
                        @if(count(Auth::user()->members->first()['profiles']) < 1)
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif(Auth::user()->members->first()->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </h6>
                <section class="card my-3" style="min-height:540px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('upgrade') }}">Upgrade account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        @if (session('warning'))
                            <section class="alert medium-small text-center alert-warning lh-1-2">{{ session('warning') }}</section>
                        @elseif(session('success'))
                            <section class="alert medium-small text-center alert-success lh-1-2">{{ session('success') }}</section>
                        @endif
                        <section class="col-sm-8 offset-sm-2 py-5">
                            <form action="{{ route('upgrade.member') }}" method="POST" enctype="multipart/form-data" class="card card-block p-4">
                                {{ csrf_field() }}

                                <section class="form-group{{ $errors->has('born_place') ? ' has-danger' : '' }}">
                                    <label for="born_place"><span class="text-danger">*</span> Born place</label>
                                    <input id="born_place" name="born_place" value="{{ old('born_place') }}" class="form-control" placeholder="Born place">
                                    @if ($errors->has('born_place'))<section class="form-control-feedback">{{ $errors->first('born_place') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between">Place of birth of members in accordance with supporting documents. E.g : Sibolga <span class="text-grey pl-2"><span class="text-danger">*</span>Required</span></small>
                                </section>
                                <section class="form-group{{ $errors->has('born_date') ? ' has-danger' : '' }}">
                                    <label for="born-of-date"><span class="text-danger">*</span> Date of Birth</label>
                                    <section id="born-date">
                                        <input id="born-of-date" name="born_date" class="form-control" value="{{ old('born_date') ? old('born_date') : date('d-m-Y') }}" placeholder="00-00-0000">
                                    </section>
                                    @if ($errors->has('born_date'))<section class="form-control-feedback">{{ $errors->first('born_date') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between">Member's birthday in accordance with supporting documents. E.g : 26-06-1994 <span class="text-grey pl-2"><span class="text-danger">*</span>Required</span></small>
                                </section>
                                <section class="form-group">
                                    <label for="gender"><span class="text-danger">*</span> Gender</label>
                                    <section>
                                        <label class="custom-control custom-radio">
                                            <input id="male" name="gender" type="radio" value="male" class="custom-control-input" {{ (old('gender') == 'male') ? ' checked' : '' }}>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Male</span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input id="female" name="gender" type="radio" value="female" class="custom-control-input" {{ (old('gender') == 'female') ? ' checked' : '' }}>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Female</span>
                                        </label>
                                    </section>
                                    @if ($errors->has('gender'))<section class="form-control-feedback">{{ $errors->first('gender') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between">The sex of the members in accordance with the supporting documents. 'Male' or 'Female' <span class="text-grey pl-2"><span class="text-danger">*</span>Required</span></small>
                                </section>
                                <section class="form-group{{ $errors->has('identity.type') ? ' has-danger' : '' }}">
                                    <label for="identity-type"><span class="text-danger">*</span> Document identity type</label>
                                    <select id="identity-type" name="identity[type]" class="custom-select w-100">
                                        <option selected disabled>Document identity</option>
                                        @foreach($identities as $identity)
                                            <option value="{{ $identity->id }}"{{ (old('identity.type') == $identity->id) ? ' selected' : '' }}>{{ $identity->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('identity.type'))<section class="form-control-feedback">{{ $errors->first('identity.type') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between">Please choose one of the legal documents that support the validity of the data. <span class="text-grey pl-2"><span class="text-danger">*</span>Required</span></small>
                                </section>
                                <section class="form-group{{ $errors->has('identity.number') ? ' has-danger' : '' }}">
                                    <label for="identity-number"><span class="text-danger">*</span> Identity number</label>
                                    <input id="born_place" name="identity[number]" value="{{ old('identity.number') }}" class="form-control" placeholder="Identity number">
                                    @if ($errors->has('identity.number'))<section class="form-control-feedback">{{ $errors->first('identity.number') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between">Fill input with identity number of legal document data in accordance with supporting documents. Numeric character only, e.g : 100010101101xxx <span class="text-grey pl-2"><span class="text-danger">*</span>Required</span></small>
                                </section>
                                <section class="form-group{{ $errors->has('identity.date') ? ' has-danger' : '' }}">
                                    <label for="identity-date"><span class="text-danger">*</span> Identity expired date</label>
                                    <section id="identity-date-container">
                                        <label class="custom-control custom-radio">
                                            <input id="implementDate" name="identity_date_type" type="radio" value="date" class="custom-control-input" required {{ is_null(old('identity_date_type')) ? 'checked' : old('identity_date_type') == 'date' ? 'checked' : '' }}> 
                                            <span class="custom-control-indicator"></span> 
                                            <span class="custom-control-description d-flex">
                                                <span class="badge badge-default small-caps" style="height: 22px; margin-top: 1px; margin-right: 8px; width: 145px;">date</span>
                                                <input id="identity-date" name="identity[date]" class="form-control" value="{{ old('identity.date') ? old('identity.date') : date('d-m-Y') }}" placeholder="00-00-0000" style="margin-top: -5px;">
                                            </span>
                                        </label>
                                        <br>
                                        <label class="custom-control custom-radio">
                                            <input id="implementLifetime" name="identity_date_type" type="radio" value="lifetime" class="custom-control-input" required {{ old('identity_date_type') == 'lifetime' ? 'checked' : '' }}> 
                                            <span class="custom-control-indicator"></span> 
                                            <span class="custom-control-description d-flex">
                                                <span class="badge badge-default small-caps" style="height: 22px; margin-top: 1px; width: 100px;">lifetime</span>
                                            </span>
                                        </label>
                                    </section>
                                    @if ($errors->has('identity.date'))<section class="form-control-feedback">{{ $errors->first('identity.date') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between">Fill input with expiry date of legal document data in accordance with the original. E.g : 26-06-2020 <span class="text-grey pl-2"><span class="text-danger">*</span>Required</span></small>
                                </section>
                                <section class="form-group{{ $errors->has('mother_name') ? ' has-danger' : '' }}">
                                    <label for="mother-name"><span class="text-danger">*</span> Mother name</label>
                                    <input id="mother-name" name="mother_name" class="form-control" value="{{ old('mother_name') }}" placeholder="Mother name">
                                    @if ($errors->has('mother_name'))<section class="form-control-feedback">{{ $errors->first('mother_name') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between">Fill input with your real mother's name. E.g : Yuant <span class="text-grey pl-2"><span class="text-danger">*</span>Required</span></small>
                                </section>
                                <section class="form-group{{ $errors->has('document') ? ' has-danger' : '' }}">
                                    <label for="document"><span class="text-danger">*</span> Upload your identity document</label>
                                    <label class="custom-file w-100">
                                        <input id="document" name="document" type="file" class="custom-file-input" placeholder="Identity document">
                                        <span class="custom-file-control"></span>
                                    </label>
                                    @if ($errors->has('document'))<section class="form-control-feedback">{{ $errors->first('document') }}</section>@endif
                                    <small class="form-text text-muted d-flex justify-content-between">Upload your legal documents with a minimum 320 x 320 pixel dimension and the file data type should be : jpg, jpeg, png, bmp, gif. <span class="text-grey pl-2"><span class="text-danger">*</span>Required</span></small>
                                </section>

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
                                                <input id="captcha" class="form-control" name="captcha" value="{{ old('captcha') }}" placeholder="Captcha code" aria-describedby="captchaHelp" required>
                                            </section>
                                            <small class="form-text lh-1-2 text-muted" id="captchaHelp">Enter security code</small>
                                            @if ($errors->has('captcha'))<span class="form-control-feedback">{{ $errors->first('captcha') }}</span>@endif
                                        </section>
                                    </section>
                                    @if ($errors->has('captcha'))<span class="form-control-feedback">{{ $errors->first('captcha') }}</span>@endif
                                </fieldset>

                                <section class="form-group mt-4">
                                    <button class="btn btn-block btn-primary" type="submit" role="button">Upgrade now</button>
                                </section>
                            </form>
                        </section>
                    </section>
                    <section class="card-footer lh-1-2">
                        <small class="text-muted"><span class="badge badge-default">Note:</span> This process must be approved by an administrator first before your account is actually leveling up.</small>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection


@section('script')
    <script type="text/javascript">
        (function ($) {
            'use strict';
            $('#born-date input').each(function() {
                $(this).datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy',
                    clearDates:true
                });
            });

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