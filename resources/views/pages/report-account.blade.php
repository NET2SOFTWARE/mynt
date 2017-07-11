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
                        <p class="medium lh-1-5 mb-0">REPORT ACCOUNT</p>
                    </section>
                </section>

                <form method="POST" action="{{ route('report.account.show') }}" accept-charset="utf-8" role="form">
                {{ csrf_field() }}

                    <section class="col-md-6 offset-md-3 mt-5">
                        <fieldset class="form-group">
                            <label class="pl-2">Filter period</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="custom-control custom-radio mt-2">
                                        <input name="type" type="radio" class="custom-control-input" required checked> 
                                        <span class="custom-control-indicator"></span> 
                                        <span class="custom-control-description">
                                            <span class="badge badge-default small-caps">
                                                daily
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-md-4 pr-0">
                                    <input data-provide="datepicker" name="date" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="custom-control custom-radio mt-2">
                                        <input name="type" type="radio" class="custom-control-input" required> 
                                        <span class="custom-control-indicator"></span> 
                                        <span class="custom-control-description">
                                            <span class="badge badge-default small-caps">
                                                ranged
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control" disabled name="date_from">
                                        <div class="input-group-addon small-caps">to</div>
                                        <input type="text" class="form-control" disabled name="date_to">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-3">
                                    <label class="custom-control custom-radio mt-2">
                                        <input name="type" type="radio" class="custom-control-input" required> 
                                        <span class="custom-control-indicator"></span> 
                                        <span class="custom-control-description">
                                            <span class="badge badge-default small-caps">
                                                monthly
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control custom-select" disabled>
                                        <option value="0" disabled selected>Choose year</option>
                                        @for ($year = 2017; $year <= intval(Carbon\Carbon::now()->format('Y')); $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-5 pl-0">
                                    <select class="form-control custom-select" disabled>
                                        <option value="0" disabled selected>Choose month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
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
        $('input[type="radio"]').on('change', function (e) {
            $('form .row .form-control').prop('disabled', true);
            $('form .row input.form-control').val('');
            $('form .row select.form-control').val(0);
            $(this).parents('.row').first().find('.form-control').prop('disabled', false);
        });

        var startDate = '01-01-2017';
        var FromEndDate = new Date();
        var ToEndDate = new Date('{{ Carbon\Carbon::now()->format('m//d/Y') }}');

        $('input[name="date"]')
            .datepicker({
                weekStart: 1,
                startDate: startDate,
                endDate: FromEndDate, 
                autoclose: true,
                orientation: 'auto bottom'
            });

        $('input[name="date_from"]')
            .datepicker({
                weekStart: 1,
                startDate: startDate,
                endDate: FromEndDate, 
                autoclose: true
            })
            .on('changeDate', function(selected){
                startDate = new Date(selected.date.valueOf());
                startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
                $('input[name="date_to"]').datepicker('setStartDate', startDate);
            }); 
        $('input[name="date_to"]')
            .datepicker({
                weekStart: 1,
                startDate: startDate,
                endDate: ToEndDate,
                autoclose: true
            })
            .on('changeDate', function(selected){
                FromEndDate = new Date(selected.date.valueOf());
                FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
                $('input[name="date_from"]').datepicker('setEndDate', FromEndDate);
            });

        $('button').off('click');
    });
</script>
@endsection
