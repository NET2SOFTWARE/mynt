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
                        <p class="medium lh-1-5 mb-0">REPORT TRANSACTION TRACING</p>
                    </section>
                </section>

                <form method="POST" action="{{ route('report.tracing.show') }}" accept-charset="utf-8" role="form">
                {{ csrf_field() }}

                    <section class="col-md-6 offset-md-3 mt-5">

                        <fieldset class="form-group">
                            <label class="pl-2">Input transaction</label>
                            <input type="text" name="number" class="form-control">
                        </fieldset>
                        <hr class="my-4">
                        <div class="text-center">
                            <button type="submit" role="button" class="btn btn-primary">Generate Report</button>
                        </div>
                    </section>

                </form>
            </section>
        </section>
    </article>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('button').off('click');
    });
</script>
@endsection
