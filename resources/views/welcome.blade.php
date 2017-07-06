@extends('layouts.app')

@section('nav')
    @component('components.nav', ['guard' => 'user'])
    @endcomponent
@endsection

@section('content')
    <article>

    </article>
    @component('components.footer')
    @endcomponent
@endsection