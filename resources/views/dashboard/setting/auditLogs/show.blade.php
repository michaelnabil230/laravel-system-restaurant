@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('dashboard.audit_logs')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.welcome') }}">
                                    <i class="fa fa-home"></i>
                                    @lang('dashboard.dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.setting.audit-logs.index') }}">
                                    @lang('dashboard.audit_logs')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@lang('dashboard.show')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.show')</h3>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>
                                                @lang('dashboard.id')
                                            </th>
                                            <td>
                                                {{ $auditLog->id }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                @lang('dashboard.description')
                                            </th>
                                            <td>
                                                {{ $auditLog->description }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                @lang('dashboard.subject_id')
                                            </th>
                                            <td>
                                                {{ $auditLog->subject_id }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                @lang('dashboard.subject_type')
                                            </th>
                                            <td>
                                                {{ $auditLog->subject_type }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                @lang('dashboard.user_name')
                                            </th>
                                            <td>
                                                {{ $auditLog->user->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                @lang('dashboard.properties')
                                            </th>
                                            <td>
                                                {{ $auditLog->properties }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                @lang('dashboard.host')
                                            </th>
                                            <td>
                                                {{ $auditLog->host }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                @lang('dashboard.created_at')
                                            </th>
                                            <td>
                                                {{ $auditLog->created_at }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
