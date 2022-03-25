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
                                <a href="{{ route('dashboard.welcome') }}">
                                    <i class="fa fa-home"></i>
                                    @lang('dashboard.dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.drivers.index') }}">
                                    @lang('dashboard.drivers')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@lang('dashboard.edit')</li>
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
                                <h3 class="card-title">@lang('dashboard.edit')</h3>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('dashboard.drivers.update', $driver->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}

                                    <div class="form-group">
                                        <label class="control-label" for="name"> @lang('dashboard.name')</label>
                                        <input type="text" name="name" value="{{ $driver->name }}"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            placeholder="@lang('dashboard.name')">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @for ($i = 0; $i < 2; $i++)
                                        <div class="form-group">
                                            <label class="control-label" for="phone"> @lang('dashboard.phone')</label>
                                            <input type="number" min="1" name="phone[]"
                                                value="{{ $driver->phone[$i] ?? '' }}"
                                                class="form-control @error('phone.' . $i) is-invalid @enderror" id="phone"
                                                placeholder="@lang('dashboard.phone')">
                                            @error('phone.' . $i)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endfor
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                            @lang('dashboard.edit')
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
