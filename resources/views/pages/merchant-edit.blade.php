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
            <!-- <merchant-page></merchant-page> -->
            <section class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2 p-0">
                <section class="header-content justify-content-between align-items-baseline">
                    <section>
                        <p class="medium lh-1-5 mb-0">MERCHANT</p>
                    </section>
                </section>
                <section class="col-sm-6 offset-sm-3 p-5">
                    @if (session('message'))
                        <section class="alert alert-success">{{ session('message') }}</section>
                        <br/>
                    @endif
                    <h5>Update merchant</h5>
                    <h6 class="medium-small">Please insert with valid data.</h6>
                    <hr class="clearfix"/>

                    <form method="post" action="{{ route('merchant.update', [$merchant->id]) }}" accept-charset="utf-8" role="form">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name">Name</label>
                            <input id="name" name="name" class="form-control" value="{{ $merchant->name  }}" placeholder="merchant name" type="text" />
                            @if ($errors->has('name'))
                                <section class="form-control-feedback">{{ $errors->first('name') }}</section>
                            @endif
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('brand') ? ' has-danger' : '' }}">
                            <label for="brand">Brand</label>
                            <input id="brand" name="brand" class="form-control" value="{{ $merchant->brand  }}" placeholder="merchant brand" type="text" />
                            @if ($errors->has('brand'))
                                <section class="form-control-feedback">{{ $errors->first('brand') }}</section>
                            @endif
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="email">Email</label>
                            <input id="email" name="email" class="form-control" value="{{ $merchant->email  }}" placeholder="merchant email" type="mail" />
                            @if ($errors->has('email'))
                                <section class="form-control-feedback">{{ $errors->first('email') }}</section>
                            @endif
                        </fieldset>
                        <fieldset class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                            <label for="website">Website</label>
                            <input id="website" name="website" class="form-control" value="{{ $merchant->website  }}" placeholder="Website url" type="url" />
                            @if ($errors->has('website'))
                                <section class="form-control-feedback">{{ $errors->first('website') }}</section>
                            @endif
                        </fieldset>
                        <button type="submit" class="btn btn-primary" role="button">Update merchant</button>
                        <a href="{{ route('merchant.index', ['all']) }}" class="btn btn-secondary">Back to merchant</a>
                    </form>
                </section>
            </section>
        </section>
    </article>
@endsection