<!DOCTYPE html>
<html class="no-js" lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MYNT | E-Money</title>
    <meta name="description" content="Mynt e-money is a secure online financial service to transact anytime and anywhere with bank connectivity in Indonesia by PT. Artajasa Pembayaran Elektronik">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link href="{{ asset('css/all.32f284e3bfdac4c187576560f9216b1d.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
    <style type="text/css">
        .multiselect-native-select .btn-group,
        .multiselect-native-select .btn-group button.multiselect {
            width: 100%;
        }
        .multiselect-native-select .btn-group button.multiselect {
            background: transparent;
            border: 1px solid #d1d5da;
        }
        .multiselect-native-select .multiselect-selected-text {
            float: left;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            width: 95%;
            text-align: left;
        }
        .multiselect-native-select .multiselect.dropdown-toggle::after {
            float: right;
            margin-top: .7em;
        }
        span.custom-file-control.changed::after {
            content: attr(data-file-name);
        }
        #document_extra.custom-file-control::before{
            height: auto;
            line-height:1.25;
        }
    </style>
</head>
<body>
    @component('components.modal')@endcomponent
    @yield('modal')
    @yield('nav')
    <main id="app" role="main">
        @yield('content')
    </main>
    <script src="{{ asset('js/tether.min.js') }}"></script>
    <script src="{{ asset('js/app.cf855400ba521f241761.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('select[multiple]').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                includeSelectAllOption: true
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @yield('script')
</body>
</html>