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
            <section class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                <section class="row">
                    <section class="col-sm-8 col-md-8 offset-sm-2 offset-md-2">
                        <section class="mt-4 mb-4">
                            <h4><small>Create new merchant</small></h4>
                            <p class="small text-grey">Please insert with valid data.</p>
                            @if (session('success'))<section class="alert alert-success">{{ session('success') }}</section>@endif
                            @if (session('warning'))<section class="alert alert-success">{{ session('warning') }}</section>@endif
                        </section>
                        <form class="mb-5" method="post" action="{{ route('merchant.store') }}" accept-charset="utf-8" enctype="multipart/form-data" role="form">
                            {{ csrf_field() }}
                            <section class="card">
                                <section class="card-block p-4">
                                    <h6 class="mb-0 medium-small text-warning">MERCHANT DATA</h6>
                                    <hr class="mt-1 mb-4"/>
                                    <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label for="name">Name</label>
                                        <input id="name" name="name" class="form-control" value="{{ old('name')  }}" placeholder="Full name" type="text" aria-describedby="nameHelp" required>
                                        @if ($errors->has('name'))<section class="form-control-feedback">{{ $errors->first('name') }}</section>@endif
                                        <small class="form-text text-muted" id="websiteHelp">Please insert this field with full name of merchant.</small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('brand') ? ' has-danger' : '' }}">
                                        <label for="brand">Brand</label>
                                        <textarea id="brand" class="form-control" name="brand" rows="3" placeholder="Merchant brand or slogan" aria-describedby="brandHelp">{{ old('brand') }}</textarea>
                                        @if ($errors->has('brand'))<section class="form-control-feedback">{{ $errors->first('brand') }}</section>@endif
                                        <small class="form-text text-muted" id="brandHelp">Describe about merchant here.</small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                        <label for="phone">Phone</label>
                                        <div class="input-group">
                                                <span class="input-group-addon medium-small lh-1-5" style="padding-top:.125rem;padding-bottom:.125rem">+62</span>
                                                <input id="phone" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Merchant phone" required>
                                            </div>
                                        @if ($errors->has('phone'))<section class="form-control-feedback">{{ $errors->first('phone') }}</section>@endif
                                        <small class="form-text text-muted" id="phoneHelp">Please insert field with valid contact phone.</small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label for="email">Email</label>
                                        <input id="email" name="email" class="form-control" value="{{ old('email')  }}" placeholder="Eg. dummy@example.com" type="email" required aria-describedby="emailHelp">
                                        @if ($errors->has('email'))<section class="form-control-feedback">{{ $errors->first('email') }}</section>@endif
                                        <small class="form-text text-muted" id="emailHelp">Please insert field with valid e-mail address.</small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                        <label for="website">Website</label>
                                        <input id="website" name="website" type="text" class="form-control" value="{{ old('website')  }}" placeholder="Eg. : http://example.com" aria-describedby="websiteHelp">
                                        @if ($errors->has('website'))<section class="form-control-feedback">{{ $errors->first('website') }}</section>@endif
                                        <small class="form-text text-muted" id="websiteHelp">Please insert field with valid website URL address.</small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('merchant.type') ? ' has-danger' : '' }}">
                                        <label>Merchant account type :</label>
                                        <section class="custom-controls-stacked">
                                            <label class="custom-control custom-radio">
                                                <input id="merchant_type" name="merchant[type]" type="radio" value="group" class="custom-control-input" aria-describedby="merchantTypeHelp" {{ old('merchant.type') == 'group' ? 'checked' : '' }} required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Group</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="merchant_type" name="merchant[type]" type="radio" value="individual" class="custom-control-input" aria-describedby="merchantTypeHelp" {{ old('merchant.type') == 'individual' ? 'checked' : '' }} required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Individual</span>
                                            </label>
                                        </section>
                                        @if ($errors->has('merchant.type'))<section class="form-control-feedback">{{ $errors->first('merchant.type') }}</section>@endif
                                        <small class="form-text text-muted" id="merchantTypeHelp">Please choose what is type of merchant account type.</small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('merchant.company') ? ' has-danger' : '' }}">
                                        <label for="merchant_company">Company</label>
                                        <select id="merchant_company" name="merchant[company]" class="custom-select w-100" aria-describedby="merchantCompanyHelp">
                                            <option selected disabled>Choose merchant company</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}"{{ old('merchant.company') == $company->id ? ' selected' : '' }}>{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('merchant.company'))
                                            <section class="form-control-feedback">{{ $errors->first('merchant.company') }}</section>
                                        @endif
                                        <small class="form-text text-muted" id="merchantCompanyHelp">Please choose company of this merchant, if this merchant has a company, otherwise let this empty.</small>
                                    </fieldset>
                                    <fieldset class="form-group{{ $errors->has('photo') ? ' has-danger' : '' }}">
                                        <label for="photo">Photo</label>
                                        <section class="clearfix">
                                            <label class="custom-file w-100">
                                                <input id="photo" name="photo" type="file" class="custom-file-input" aria-describedby="photoHelp">
                                                <span class="custom-file-control"></span>
                                            </label>
                                        </section>
                                        <small class="form-text text-muted" id="photoHelp">Merchant photo, min : 160 x 160 pixel, Ext : jpeg, jpg, png, gif, bmp</small>
                                        @if ($errors->has('photo'))<section class="form-control-feedback">{{ $errors->first('photo') }}</section>@endif
                                    </fieldset>
                                    <h6 class="mb-0 medium-small text-warning mt-4">MERCHANT CREDENTIAL</h6>
                                    <hr class="mt-1 mb-4"/>
                                    <fieldset class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <label for="password">Password</label>
                                        <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required>
                                        @if ($errors->has('password'))
                                            <section class="form-control-feedback">{{ $errors->first('password') }}</section>
                                        @endif
                                        <small class="form-text text-muted d-flex justify-content-between" id="passwordHelp">Insert unique new merchant password. Min. 6~16 alpha numeric character. <span class="text-grey ml-5">Required</span></small>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="password-confirm">Confirm password</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm password" required>
                                        <small class="form-text text-muted d-flex justify-content-between" id="confirmPasswordHelp">Re-type merchant password <span class="text-grey ml-5">Required</span></small>
                                    </fieldset>
                                </section>
                            </section>
                            <section class="mt-3 text-right">
                                <button type="submit" class="btn btn-primary" role="button">Save merchant</button>
                            </section>
                        </form>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection