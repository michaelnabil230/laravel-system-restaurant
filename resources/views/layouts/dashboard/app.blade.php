<!DOCTYPE html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ setting('name') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- pace-progress -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/pace-progress/themes/black/pace-theme-flat-top.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/pace.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/adminlte.min.css') }} ">
    <!-- Google Font: Cairo -->
    @if (App::isLocale('ar'))
        <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
        <!-- bootstrap rtl -->
        <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-rtl.min.css') }}">
        <!-- template rtl version -->
        <link rel="stylesheet" href="{{ asset('dashboard/css/custom-style.css') }}">
        <style>
            body,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: 'Cairo', sans-serif !important;
            }

            @media (min-width: 576px) {
                .float-sm-right {
                    float: left !important;
                }
            }

        </style>
    @else
        <style>
            @media (min-width: 576px) {
                .float-sm-left {
                    float: right !important;
                }
            }

            .mr-auto {
                margin-right: inherit !important;
                margin-left: auto !important;
            }

        </style>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @endif
    <style>
        .loader {
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #367FA9;
            width: 60px;
            height: 60px;
            -webkit-animation: spin 1s linear infinite;
            /* Safari */
            animation: spin 1s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

    </style>
    <!-- noty -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/noty/noty.css') }}">
    <script src="{{ asset('dashboard/plugins/noty/noty.min.js') }}"></script>

    <!-- select2 -->
    <link href="{{ asset('dashboard/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />

    <!-- html in ie -->
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

</head>

<body class="hold-transition sidebar-mini pace-primary">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-flag"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-0">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a class="dropdown-item {{ $localeCode == app()->getLocale() ? 'active' : '' }}"
                                hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">@lang('dashboard.logout')
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        @include('layouts.dashboard._aside')

        @yield('content')

        @include('partials._session')

        <footer class="main-footer">
            <div class="float-sm-right hidden-xs">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2020-{{ date('Y') }} <a tel="+201200954866">Michael Nabil</a>.</strong> All
            rights reserved.
        </footer>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('dashboard/plugins/overlayScrollbars/js/OverlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dashboard/js/adminlte.min.js') }}"></script>
    <!-- select2 -->
    <script src="{{ asset('dashboard/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- printThis -->
    <script src="{{ asset('dashboard/js/printThis.js') }}"></script>
    <!-- jquery number -->
    <script src="{{ asset('dashboard/js/jquery.number.min.js') }}"></script>
    <!-- pace-progress -->
    <script src="{{ asset('dashboard/plugins/pace-progress/pace.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.main-sidebar').overlayScrollbars({
                normalizeRTL: true
            });
            $('body').overlayScrollbars({
                normalizeRTL: true
            });
            $('.sidebar').overlayScrollbars({
                normalizeRTL: true
            });
            $('.delete').click(function(e) {
                var that = $(this)
                e.preventDefault();
                var n = new Noty({
                    text: "@lang('dashboard.confirm_delete')",
                    type: "warning",
                    killer: true,
                    buttons: [
                        Noty.button("@lang('dashboard.yes')", 'btn btn-success mr-2',
                    function() {
                            that.parent().find('form').submit();
                        }),
                        Noty.button("@lang('dashboard.no')", 'btn btn-primary mr-2',
                    function() {
                            n.close();
                        })
                    ]
                });
                n.show();
            });

            $('.searchable-field').select2({
                minimumInputLength: 3,
                ajax: {
                    url: '{{ route('dashboard.globalSearch') }}',
                    dataType: 'json',
                    type: 'GET',
                    delay: 200,
                    data: function(term) {
                        return {
                            search: term
                        };
                    },
                    results: function(data) {
                        return {
                            data
                        };
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: formatItem,
                templateSelection: formatItemSelection,
                placeholder: "@lang('dashboard.search') ...",
                language: {
                    inputTooShort: function(args) {
                        var remainingChars = args.minimum - args.input.length;
                        var translation = "@lang('dashboard.search_input_too_short')";

                        return translation.replace(':count', remainingChars);
                    },
                    errorLoading: function() {
                        return "@lang('dashboard.results_could_not_be_loaded')";
                    },
                    searching: function() {
                        return "@lang('dashboard.searching')";
                    },
                    noResults: function() {
                        return "@lang('dashboard.no_results')";
                    },
                }
            });

            function formatItem(item) {
                if (item.loading) {
                    return "@lang('dashboard.searching')...";
                }
                var markup = "<div class='searchable-link' href='" + item.url + "'>";
                markup += "<div class='searchable-title'>" + item.model + "</div>";
                $.each(item.fields, function(key, field) {
                    markup += "<div class='searchable-fields'>" + item.fields_formated[field] + " : " +
                        item[field] + "</div>";
                });
                markup += "</div>";

                return markup;
            }

            function formatItemSelection(item) {
                if (!item.model) {
                    return "@lang('dashboard.search')...";
                }
                return item.model;
            }

            $(document).delegate('.searchable-link', 'click', function() {
                var url = $(this).attr('href');
                window.location = url;
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
