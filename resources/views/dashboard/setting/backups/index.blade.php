@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('dashboard.backups')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.welcome') }}"><i class="fa fa-home"></i>
                                    @lang('dashboard.dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@lang('dashboard.backups')</li>
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
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('dashboard.backups')
                                    <small> {{ count($backups) }}</small>
                                </h3>
                                <div class="card-tools">
                                    <form action="{{ route('dashboard.setting.backups.create') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>
                                                @lang('dashboard.generate_backup')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('dashboard.name')</th>
                                                <th>@lang('dashboard.size')</th>
                                                <th>@lang('dashboard.time')</th>
                                                <th>@lang('dashboard.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($backups as  $backup)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $backup['name'] }}</td>
                                                    <td>{{ $backup['size'] }}</td>
                                                    <td>{{ $backup['time'] }}</td>
                                                    <td class="py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="?file={{ $backup['name'] }}"
                                                                class="btn btn-primary"><i class="fa fa-download"></i>
                                                                @lang('dashboard.download')
                                                            </a>
                                                            <a href="#" class="btn delete btn-danger"><i
                                                                    class="fa fa-trash"></i> @lang('dashboard.delete')
                                                            </a>
                                                            <form
                                                                action="{{ route('dashboard.setting.backups.delete', ['file' => $backup['name']]) }}"
                                                                method="post" style="display: inline-block">
                                                                @csrf
                                                            </form>
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
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
