@extends('layouts.app')

@section('nav')
    @component('components.nav-company')
    @endcomponent
@endsection

@section('content')
    <article class="col">
        <section class="row">
            @component('components.aside-company', ['active' => 'management'])@endcomponent
            <section class="col-md-9">
                <section class="card mt-3" style="min-height:624px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('company.management.account') }}">Personal Account</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.management.bank') }}">Bank Account</a></li>
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="row">
                            <section class="col-sm-8 col-md-8 px-md-5">
                                <h6 class="medium d-flex justify-content-between">
                                    <small class="text-uppercase text-warning mb-1">IDENTITY</small>
                                    <span><a href="{{ route('company.management.edit.identity') }}" class="btn btn-sm btn-outline-success py-0" data-toggle="tooltip" data-placement="top" title="Update personal data">Update</a></span>
                                </h6>
                                <hr class="mt-0 mb-1">
                                <ul class="list-group list-group-flush medium-small lh-1-2 mb-5">
                                    <li class="list-group-item justify-content-between border-top-0">
                                        Full name
                                        <span>{{ Auth::user()->name }}</span>
                                    </li>
                                    <li class="list-group-item justify-content-between">
                                        Phone
                                        <span>{{ Auth::user()->phone }}</span>
                                    </li>
                                </ul>
                                <h6 class="medium d-flex justify-content-between align-items-baseline">
                                    <small class="text-uppercase text-warning mb-1">CREDENTIAL</small>
                                    <span><a href="{{ route('company.management.edit.password') }}" class="btn btn-sm btn-outline-success py-0" data-toggle="tooltip" data-placement="top" title="Update credential data">Change password</a></span>
                                </h6>
                                <hr class="mt-0 mb-1">
                                <ul class="list-group list-group-flush medium-small lh-1-2 mb-5">
                                    <li class="list-group-item justify-content-between border-top-0">
                                        E-mail address
                                        <span>{{ Auth::user()->email }}</span>
                                    </li>
                                    <li class="list-group-item justify-content-between">
                                        Password
                                        <span>
                                            <strong>&#42;&#42;&#42;&#42;&#42;</strong>
                                        </span>
                                    </li>
                                </ul>
                                <h6 class="medium d-flex justify-content-between align-items-baseline lh-1-5">
                                    <small class="text-uppercase text-warning mb-1">BANK</small>
                                    <span>
                                        <a href="{{ route('company.management.bank.create') }}" class="btn btn-sm btn-outline-success py-0" data-toggle="tooltip" data-placement="top" title="Register new bank account">Add new bank</a>
                                    </span>
                                </h6>
                                <hr class="mt-0">
                                @if(count(Auth::user()->companies->first()['banks']) >= 1)
                                    <p class="mb-0 d-flex justify-content-between medium-small lh-1-2">
                                        <span>{{ Auth::user()->companies->first()['banks'][0]['bank_code'] }}</span>
                                        <span>{{ strtoupper(Auth::user()->companies->first()['banks'][0]['bank_name']) }}</span>
                                        <span>{{ Auth::user()->companies->first()['banks'][0]['pivot']['account_number'] }}</span>
                                    </p>
                                @else
                                    <p class="medium-small text-grey">No registered bank account yet.</p>
                                @endif
                            </section>
                            <section class="col-sm-4 col-md-4">
                                <section class="card medium">
                                    <section class="card-img-top text-center mt-3">
                                        <img src="{{ asset('img/company/' . Auth::user()->companies->first()->image) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" id="avatar" style="max-width: 80%; max-height: 230px;">
                                    </section>
                                    <section class="card-block text-center">
                                        <section class="text-center mb-3">
                                            <a href="#" class="btn btn-sm py-0 btn-outline-success" data-toggle="modal" data-target="#modalUploadPhoto">Upload Photo</a>
                                        </section>
                                    </section>
                                    <ul class="list-group list-group-flush medium-small lh-1-2">
                                        <li class="list-group-item justify-content-between">No. Acc <span class="text-muted">{{ Auth::user()->companies->first()['accounts'][0]['number'] }}</span></li>
                                        <li class="list-group-item justify-content-between">MYNT ID <span class="text-muted">{{ Auth::user()->companies->first()['accounts'][0]['mynt_id'] }}</span></li>
                                        <li class="list-group-item justify-content-between border-bottom-0">Register date<span class="text-muted">{{ date('d-m-Y', strtotime(Auth::user()->created_at)) }}</span></li>
                                    </ul>
                                    <section class="card-footer">
                                        <small class="text-muted">Last updated {{ Auth::user()->updated_at }}</small>
                                    </section>
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </article>

    <!-- Modal : #modalUploadPhoto -->
    <div class="modal fade" id="modalUploadPhoto" tabindex="-1" role="dialog" aria-labelledby="modalUploadPhotoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('api.company.update.upload', [Auth::user()->companies->first()['id']]) }}" accept-charset="utf-8" enctype="multipart/form-data" role="form" id="formUploadPhoto">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUploadPhotoLabel">Upload photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <fieldset class="form-group mb-0">
                        <section class="clearfix">
                            <label class="custom-file w-100">
                                <input type="file" id="photo" name="photo" class="custom-file-input" aria-describedby="photoHelp" required>
                                <span class="custom-file-control"></span>
                            </label>
                        </section>
                        <section class="form-control-feedback" style="display: none;" id="photoError">
                            <p></p>
                        </section>
                        <small class="form-text text-muted d-flex justify-content-between" id="photoHelp">
                            Please upload your photo <span class="text-grey">Required</span>
                        </small>
                    </fieldset>
                </div>
                <div class="modal-footer justify-content-between">
                    <button role="button" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button role="button" type="submit" class="btn btn-primary" id="btnUploadPhoto">Save changes</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
$(function(){
    var $formUploadPhoto = $('#formUploadPhoto');
    var $modalUploadPhoto = $('#modalUploadPhoto');
    var $avatar = $('#avatar');
    var $leftAvatar = $('section.media-left img');

    $formUploadPhoto.on('submit', function (e) {
        e.preventDefault();

        $(this).validate();

        if ($(this).valid())
        {
            $.ajax({
                async   : false,
                cache   : false,
                contentType : false,
                processData : false,
                type    : $(this).attr('method'),
                url     : $(this).attr('action'),
                data    : new FormData(this),
                success : function(data, textStatus, jqXhr) {
                    $avatar.attr('src', '{{ asset('img/company') }}/' + data.data.company.image);
                    $leftAvatar.attr('src', '{{ asset('img/company') }}/' + data.data.company.image);
                    $modalUploadPhoto.modal('hide');
                }
            });
        }
    });
});
</script>
@endsection