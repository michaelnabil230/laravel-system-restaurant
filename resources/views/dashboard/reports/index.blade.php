@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.reports')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i> @lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('site.reports')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('site.reports')</h3>
                                {{-- <div class="card-tools"> --}}
                                <div class="input-group input-group-sm">
                                    <input type="date" class="form-control from_at"
                                           value="{{ date('Y-m-d', strtotime('- 1 days')) }}">
                                    <input type="date" class="form-control to_at"
                                           value="{{ date('Y-m-d') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-filter btn-default"><i
                                                class="fa fa-search"></i> @lang('site.filter_data')</button>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                                    <div class="loader"></div>
                                    <p style="margin-top: 10px">@lang('site.loading')</p>
                                </div>

                                <div id="print-area"></div><!-- end of list -->
                                <button class="btn btn-block btn-primary print-btn"><i
                                        class="fa fa-print"></i> @lang('site.print')</button>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div><!-- end of content wrapper -->
@endsection
@push('scripts')
    <script>
        //print order
        $(document).on('click', '.print-btn', function () {

            $('#print-area').printThis();

        });//end of click function
        $(document).on('click', '.btn-filter', function (e) {

            e.preventDefault();

            $('#loading').css('display', 'flex');
            var from_at = $('.from_at').val();
            var to_at = $('.to_at').val();
            var url = "{{ route('dashboard.reports.post') }}";
            var data = {
                from_at: from_at,
                to_at: to_at,
            };
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (data) {

                    $('#loading').css('display', 'none');
                    $('#print-area').empty();
                    $('#print-area').append(data);

                }
            })
        });//end of order products click
    </script>
@endpush
