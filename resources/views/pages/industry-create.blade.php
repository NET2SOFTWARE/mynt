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
                <section class="header-content justify-content-between align-items-baseline">
                    <section>
                        <p class="medium lh-1-5 mb-0">INSTITUTION</p>
                    </section>
                </section>
                <section class="row">
                    <section class="col-sm-8 offset-sm-2 py-3">
                        <section class="mt-3 mb-5">
                            <section class="mb-4">
                                <h4><small>Create new instution</small></h4>
                                <p class="small text-grey">Please insert with valid data.</p>
                                @if (session('success'))<section class="alert alert-success">{{ session('success') }}</section>@endif
                                @if (session('warning'))<section class="alert alert-danger">{{ session('warning') }}</section>@endif
                            </section>
                            <form class="mb-3" method="post" action="{{ route('industry.store') }}" accept-charset="utf-8" role="form">
                                {{ csrf_field() }}
                                <section class="card card-block p-5">
                                    <h6 class="mb-0 medium-small text-warning">INSTITUTION DATA</h6>
                                    <section><hr/></section>
                                    <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label for="name">Name</label>
                                        <input id="name" name="name" class="form-control" value="{{ old('name')  }}" placeholder="industry name" type="text" aria-describedby="nameHelp">
                                        @if ($errors->has('name'))<section class="form-control-feedback">{{ $errors->first('name') }}</section>@endif
                                        <small class="form-text text-muted d-flex justify-content-between" id="nameHelp">Full institution name. Max. 40 characters, eg. Banking <span class="text-grey">Required</span></small>
                                    </fieldset>
                                </section>
                                <section class="form-group mt-4">
                                    <a href="{{ route('industry.index') }}" class="btn btn-secondary">Back to institution</a>
                                    <button type="submit" class="btn btn-primary float-right" role="button">Save institution</button>
                                </section>
                            </form>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </article>
@endsection