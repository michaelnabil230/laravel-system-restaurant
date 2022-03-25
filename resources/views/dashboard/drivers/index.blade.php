@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('dashboard.drivers')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.welcome') }}"><i class="fa fa-home"></i>
                                    @lang('dashboard.dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@lang('dashboard.drivers')</li>
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
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('dashboard.drivers')
                                    <small> {{ $drivers->total() }}</small>
                                </h3>
                                <form action="{{ route('dashboard.drivers.index') }}" method="get">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search" class="form-control float-right"
                                            value="{{ request()->search }}" placeholder="@lang('dashboard.search')">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fa fa-search"></i>
                                                @lang('dashboard.search')
                                            </button>
                                            @can('create_drivers')
                                                <a href="{{ route('dashboard.drivers.create') }}" class="btn btn-primary">
                                                    <i class="fa fa-plus"></i>
                                                    @lang('dashboard.add')
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('dashboard.name')</th>
                                                <th>@lang('dashboard.phone')</th>
                                                <th>@lang('dashboard.note')</th>
                                                <th>@lang('dashboard.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($drivers as $driver)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $driver->name }}</td>
                                                    <td>{{ is_array($driver->phone) ? implode($driver->phone, '-') : $driver->phone }}
                                                    </td>
                                                    <td>{{ $driver->note }}</td>
                                                    <td class="py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">
                                                            @can('update_drivers')
                                                                <a href="{{ route('dashboard.drivers.edit', $driver->id) }}"
                                                                    class="btn btn-info"><i class="fa fa-edit"></i>
                                                                    @lang('dashboard.edit')
                                                                </a>
                                                            @endcan
                                                            @can('delete_drivers')
                                                                <a href="#" class="btn delete btn-danger">
                                                                    <i class="fa fa-trash"></i>
                                                                    @lang('dashboard.delete')
                                                                </a>
                                                                <form
                                                                    action="{{ route('dashboard.drivers.destroy', $driver->id) }}"
                                                                    method="post" style="display: inline-block">
                                                                    {{ csrf_field() }}{{ method_field('delete') }}
                                                                </form>
                                                            @endcan
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
                                    {{ $drivers->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
