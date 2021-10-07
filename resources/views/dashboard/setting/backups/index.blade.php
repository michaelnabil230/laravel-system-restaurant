@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.backups')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i> @lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('site.backups')</li>
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
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('site.backups')
                                    <small> {{ count($backups) }}</small>
                                </h3>
                                <div class="card-tools">
                                    <form action="{{ route('dashboard.setting.backups.create') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-plus"></i> @lang('site.generate_backup')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('site.name')</th>
                                            <th>@lang('site.size')</th>
                                            <th>@lang('site.time')</th>
                                            <th>@lang('site.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($backups as $index => $backup)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $backup['name'] }}</td>
                                                <td>{{ $backup['size'] }}</td>
                                                <td>{{ $backup['time'] }}</td>
                                                <td class="py-0 align-middle">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="?file={{ $backup['name'] }}"
                                                           class="btn btn-primary"><i
                                                                class="fa fa-download"></i> @lang('site.download')</a>
                                                        <a href="#" class="btn delete btn-danger"><i
                                                                class="fa fa-trash"></i> @lang('site.delete')</a>
                                                        <form
                                                            action="{{ route('dashboard.setting.backups.delete',['file' => $backup['name']]) }}"
                                                            method="post" style="display: inline-block">
                                                            @csrf
                                                        </form><!-- end of form -->
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="15" class="text-center">@lang('site.no_data_found')</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table><!-- end of table -->
                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div><!-- end of content wrapper -->
@endsection