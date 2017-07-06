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
                <section class="row m-0">
                    <section class="col-sm-10 col-md-10 offset-sm-1 offset-md-1 mb-4">
                        @if (session('success'))
                            <section class="alert mb-3 alert-success">{{ session('success') }}</section>
                        @elseif(session('warning'))
                            <section class="alert mb-3 alert-success">{{ session('warning') }}</section>
                        @endif
                        <section class="mt-4 mb-3">
                            <h4 class="mb-1"><small>Create new role</small></h4>
                            <h6 class="medium-small">Please insert with valid data.</h6>
                        </section>
                        <form method="post" action="{{ route('role.store') }}" accept-charset="utf-8" role="form">
                            {{ csrf_field() }}

                            <section class="card card-block mb-3">
                                <h6 class="mb-4 medium-small text-warning">ROLE IDENTITY</h6>
                                <section class="d-flex justify-content-between">
                                    <fieldset class="form-group w-50">
                                        <label for="name">Name of Role</label>
                                        <input id="name" name="name" class="form-control" value="{{ old('name')  }}" type="text" placeholder="Role name" aria-describedby="nameHelp">
                                        @if ($errors->has('name'))
                                            <section class="form-control-feedback">{{ $errors->first('name') }}</section>
                                        @endif
                                        <small class="form-text text-muted d-flex justify-content-between" id="nameHelp">
                                            Role name characters only, max. 40 <span class="text-grey">Required</span>
                                        </small>
                                    </fieldset>
                                    <fieldset class="form-group w-50 ml-3">
                                        <label for="level">Level of Role</label>
                                        <select id="level" name="level" class="custom-select w-100">
                                            <option selected disabled>Choose Level</option>
                                            <option value="1">Administrator</option>
                                            <option value="2">Member</option>
                                            <option value="3">Merchant</option>
                                            <option value="3">Company</option>
                                        </select>
                                        @if ($errors->has('name'))
                                            <section class="form-control-feedback">{{ $errors->first('name') }}</section>
                                        @endif
                                        <small class="form-text text-muted d-flex justify-content-between" id="nameHelp">
                                            Choose one level of role <span class="text-grey">Required</span>
                                        </small>
                                    </fieldset>
                                </section>
                            </section>

                            <section class="card card-block">
                                <h6 class="mb-4 medium-small text-warning">ADMIN&nbsp;&nbsp;|&nbsp;&nbsp;ACCESS CONFIGURATION</h6>
                                <ul class="list-group list-group-flush medium lh-1-5 mb-2">
                                    @foreach($accesses as $item)
                                        <li class="list-group-item justify-content-between p-0">
                                            {{ ucwords($item->access_name) }}
                                            <section>
                                                @foreach($item->access_action as $index => $value)
                                                    <label class="custom-control custom-checkbox mb-0">
                                                        <input id="{{ str_replace(' ', '-', $item->access_name).'-'.$index }}" name="data[{{ $item->access_name }}][{{ $index }}]" type="checkbox" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description lh-1-5">&nbsp;{{ $index }}</span>
                                                    </label>
                                                @endforeach
                                            </section>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>

                            <section class="form-group text-right mt-4">
                                <button type="submit" class="btn btn-primary" role="button">Save role with configuration</button>
                            </section>
                        </form>
                    </section>
                </section>
            </section>
        </section>
    </article>
@endsection