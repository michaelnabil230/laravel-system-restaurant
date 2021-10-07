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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i>@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.setting.audit-logs.index') }}"> @lang('site.audit_logs')</a>
                            </li>
                            <li class="breadcrumb-item active">@lang('site.show')</li>
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
                    <div class="col-md-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">@lang('site.show')</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                    <tr>
                                        <th>
                                            @lang('site.id')
                                        </th>
                                        <td>
                                            {{ $auditLog->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @lang('site.description')
                                        </th>
                                        <td>
                                            {{ $auditLog->description }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @lang('site.subject_id')
                                        </th>
                                        <td>
                                            {{ $auditLog->subject_id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @lang('site.subject_type')
                                        </th>
                                        <td>
                                            {{ $auditLog->subject_type }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @lang('site.user_name')
                                        </th>
                                        <td>
                                            {{ $auditLog->user->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @lang('site.properties')
                                        </th>
                                        <td>
                                            {{ $auditLog->properties }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @lang('site.host')
                                        </th>
                                        <td>
                                            {{ $auditLog->host }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @lang('site.created_at')
                                        </th>
                                        <td>
                                            {{ $auditLog->created_at }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.card -->
                    </div><!-- /.col-->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div><!-- end of content wrapper -->
@endsection
