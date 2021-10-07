@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.audit_logs')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i> @lang('site.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item active">@lang('site.audit_logs')</li>
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
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('site.audit_logs')
                                    <small> {{ $auditLogs->total() }}</small>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('site.description')</th>
                                            <th>@lang('site.subject_id')</th>
                                            <th>@lang('site.subject_type')</th>
                                            <th>@lang('site.user_name')</th>
                                            <th>@lang('site.host')</th>
                                            <th>@lang('site.created_at')</th>
                                            <th>@lang('site.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($auditLogs as $auditLog)
                                            <tr>
                                                <td>{{ $loop->index++ }}</td>
                                                <td>{{ $auditLog->description }}</td>
                                                <td>{{ $auditLog->subject_id }}</td>
                                                <td>{{ $auditLog->subject_type }}</td>
                                                <td>{{ $auditLog->user->name ?? '' }}</td>
                                                <td>{{ $auditLog->host }}</td>
                                                <td>{{ $auditLog->created_at }}</td>
                                                <td class="py-0 align-middle">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('dashboard.setting.audit-logs.show', $auditLog->id) }}"
                                                           class="btn btn-info"><i
                                                                class="fa fa-eye"></i> @lang('site.show')</a>
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
                                    {{ $auditLogs->links() }}
                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div><!-- end of content wrapper -->
@endsection
