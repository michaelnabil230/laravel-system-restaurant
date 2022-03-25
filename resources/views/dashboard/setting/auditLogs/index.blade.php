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
                                <a href="{{ route('dashboard.welcome') }}"><i class="fa fa-home"></i>
                                    @lang('dashboard.dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@lang('dashboard.audit_logs')</li>
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
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('dashboard.audit_logs')
                                    <small> {{ $auditLogs->total() }}</small>
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('dashboard.description')</th>
                                                <th>@lang('dashboard.subject_id')</th>
                                                <th>@lang('dashboard.subject_type')</th>
                                                <th>@lang('dashboard.user_name')</th>
                                                <th>@lang('dashboard.host')</th>
                                                <th>@lang('dashboard.created_at')</th>
                                                <th>@lang('dashboard.action')</th>
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
                                                                class="btn btn-info"><i class="fa fa-eye"></i>
                                                                @lang('dashboard.show')
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="15" class="text-center">@lang('dashboard.no_data_found')
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $auditLogs->links() }}
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
