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
                    @component('components.aside-member-register', ['active' => 'management'])@endcomponent
                @else
                    @component('components.aside-member-unregister', ['active' => 'management'])@endcomponent
                @endif
            @else
                @component('components.aside-member-child', ['active' => 'management'])@endcomponent
            @endif
            <section class="col-md-9 py-3">
                <h5 class="mb-4 d-flex flex-row justify-content-between align-items-baseline">
                    Management
                    <span>
                        @if(count(Auth::user()->members->first()['profiles']) < 1 && (!Auth::user()->members->first()->isChildAccount()))
                            <a href="{{ route('upgrade') }}" class="btn btn-sm btn-block btn-success">Upgrade account</a>
                        @elseif(Auth::user()->members->first()->isPendingUpgrade())
                            <span class="badge badge-info medium-small lh-1-2 mb-0">The process of upgrading your account is still awaiting confirmation from the admin.</span>
                        @endif
                    </span>
                </h5>
                <section class="card mt-3" style="min-height:560px">
                    <section class="card-header">
                        <ul class="nav nav-tabs card-header-tabs medium-small">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('member.management') }}">Personal Account</a></li>
                            @if(!Auth::user()->members->first()->isChildAccount())
                                <li class="nav-item"><a class="nav-link" href="{{ route('member.management.bank') }}">Bank Account</a></li>
                            @endif
                            @if(Auth::user()->members->first()->isRegistered())
                                <li class="nav-item"><a class="nav-link" href="{{ route('member.management.child') }}">Child Account</a></li>
                            @endif
                        </ul>
                    </section>
                    <section class="card-block">
                        <section class="row">
                            <section class="col-sm-8 col-md-8 px-md-5">
                                <h6 class="d-flex justify-content-between lh-1-5 align-items-baseline my-3">
                                    <small class="text-uppercase text-warning mb-1">CHANGE PASSWORD</small>
                                    <span><a href="{{ route('member.management') }}" class="btn btn-sm btn-outline-success py-0">Back</a></span>
                                </h6>
                                <section style="display: none;" class="alert mb-3 small alert-danger lh-1-2">Failed updating personal data.</section>
                                <section style="display: none;" class="alert mb-3 small alert-success lh-1-2">Success updating personal data.</section>
                                @if (session('warning'))
                                    <section class="alert mb-3 small alert-success lh-1-2">{{ session('warning') }}</section>
                                @elseif(session('success'))
                                    <section class="alert mb-3 small alert-success lh-1-2">{{ session('success') }}</section>
                                @endif
                                <form action="{{ route('api.member.update', [Auth::user()->members()->first()->id]) }}" method="POST" accept-charset="utf-8" role="form" id="formUpdate">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    @include('forms.edit-password')
                                </form>
                            </section>
                            <section class="col-sm-4 col-md-4">
                                <section class="card medium">
                                    <section class="card-img-top text-center mt-3">
                                        <img src="{{ asset('img/member/' . Auth::user()->members->first()->image) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" id="avatar" style="max-width: 80%; max-height: 230px;">
                                    </section>
                                    <section class="card-block text-center">
                                        <section class="text-center mb-3">
                                            <a href="#" class="btn btn-sm py-0 btn-outline-success" data-toggle="modal" data-target="#modalUploadPhoto">Upload Photo</a>
                                        </section>
                                        <h6 class="card-title"><strong>{{ Auth::user()->name }}</strong></h6>
                                    </section>
                                    <ul class="list-group list-group-flush medium-small lh-1-2">
                                        <li class="list-group-item justify-content-between">No. Acc <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['number'] }}</span></li>
                                        <li class="list-group-item justify-content-between">MYNT ID <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['mynt_id'] }}</span></li>
                                        <li class="list-group-item justify-content-between">Balance Limit <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['limit_balance'] }}</span></li>
                                        <li class="list-group-item justify-content-between">Transaction Limit <span class="text-muted">{{ Auth::user()->members->first()['accounts'][0]['limit_balance_transaction'] }}</span></li>
                                        <li class="list-group-item justify-content-between border-bottom-0">Register <span class="text-muted">{{ date('d-m-Y', strtotime(Auth::user()->created_at)) }}</span></li>
                                    </ul>
                                    <section class="card-footer">
                                        <small class="text-muted">Last updated {{ Auth::user()->updated_at }}</small>
                                    </section>
                                </section>
                            </section>
                        </section>
                    </section>
                    <section class="card-footer">
                        <small class="text-muted">Note : If you have a trouble, please contact our cumtumer service.</small>
                    </section>
                </section>
            </section>
        </section>
    </article>

    <!-- Modal : #modalUploadPhoto -->
    <div class="modal fade" id="modalUploadPhoto" tabindex="-1" role="dialog" aria-labelledby="modalUploadPhotoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('api.member.update', [Auth::user()->members->first()['id']]) }}" accept-charset="utf-8" enctype="multipart/form-data" role="form" id="formUploadPhoto">
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
    $('#reload_captcha').on('click', function () {
        $.ajax({
            method: 'GET',
            url: '/get_captcha',
        }).done(function (response) {
            $('#img_captcha').prop('src', response);
        });
    });

    var $formUpdate = $('#formUpdate');

    $formUpdate.on('submit', function (e) {
        e.preventDefault();

        $('.alert').hide();

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
                    $('.alert-success').fadeIn();
                }
            })
            .fail(function(){
                $('.alert-danger').fadeIn();
            });
        }
    });

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
                    $avatar.attr('src', '{{ asset('img/member') }}/' + data.data.member.image);
                    $leftAvatar.attr('src', '{{ asset('img/member') }}/' + data.data.member.image);
                    $modalUploadPhoto.modal('hide');
                }
            });
        }
    });
});
</script>
@endsection