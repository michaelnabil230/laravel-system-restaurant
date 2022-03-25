@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('dashboard.setting')</h1>
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
                                <a href="{{ route('dashboard.setting.index') }}">
                                    @lang('dashboard.setting')
                                </a>
                            </li>
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
                                <h3 class="card-key">@lang('dashboard.update')</h3>
                            </div>
                            <div class="card-body">

                                <form action="{{ route('dashboard.setting.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('Post')
                                    <div class="form-group">
                                        <label class="control-label" for="name">
                                            @lang('dashboard.name')
                                        </label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            value="{{ setting('name') }}" placeholder="@lang('dashboard.name')">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="logo">@lang('dashboard.logo')
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" name="logo"
                                                class="custom-file-input @error('logo') is-invalid @enderror" id="logo">
                                            <label class="custom-file-label" for="logo">@lang('dashboard.choose_logo')
                                            </label>
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="version">
                                            @lang('dashboard.version')
                                        </label>
                                        <input type="text" name="version" value="{{ setting('version') }}"
                                            class="form-control @error('version') is-invalid @enderror" id="version"
                                            placeholder="@lang('dashboard.version')">
                                        @error('version')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-plus"></i>
                                            @lang('dashboard.add')
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