@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('dashboard.reports')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.welcome') }}"><i class="fa fa-home"></i>
                                    @lang('dashboard.dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@lang('dashboard.reports')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('dashboard.reports')</h3>
                                <div class="input-group input-group-sm">
                                    <input type="date" class="form-control from_at"
                                        value="{{ date('Y-m-d', strtotime('- 1 days')) }}">
                                    <input type="date" class="form-control to_at" value="{{ date('Y-m-d') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-filter btn-default">
                                            <i class="fa fa-search"></i>
                                            @lang('dashboard.filter_data')
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                                    <div class="loader"></div>
                                    <p style="margin-top: 10px">@lang('dashboard.loading')</p>
                                </div>
                                <div id="print-area"></div>
                                <button class="btn btn-block btn-primary print-btn">
                                    <i class="fa fa-print"></i>
                                    @lang('dashboard.print')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).on('click', '.print-btn', function() {
            $('#print-area').printThis();
        });

        $(document).on('click', '.btn-filter', function(e) {
            e.preventDefault();
            $('#loading').css('display', 'flex');
            var from_at = $('.from_at').val();
            var to_at = $('.to_at').val();
            var type = $('.type').val();
            var url = "{{ route('dashboard.setting.reports.post') }}";
            var data = {
                from_at: from_at,
                to_at: to_at,
                type: type,
            };
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function(data) {
                    $('#loading').css('display', 'none');
                    $('#print-area').empty();
                    $('#print-area').append(data);
                }
            })
        });
    </script>
@endpush
