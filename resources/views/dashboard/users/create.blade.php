@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.users')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i>@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.users.index') }}"> @lang('site.users')</a></li>
                            <li class="breadcrumb-item active">@lang('site.add')</li>
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
                            <div class="card-header"><h3 class="card-title">@lang('site.add')</h3></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('dashboard.users.store') }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('post') }}

                                    <div class="form-group">
                                        <label class="control-label"
                                               for="name"> @lang('site.name')</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="name"
                                               placeholder="@lang('site.name')">

                                        @error ('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="email"> @lang('site.email')</label>
                                        <input type="text" name="email" value="{{ old('email') }}"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email"
                                               placeholder="@lang('site.email')">

                                        @error ('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="password"> @lang('site.password')</label>
                                        <input type="text" name="password" value="{{ old('password') }}"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="password"
                                               placeholder="@lang('site.password')">

                                        @error ('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="password_confirmation"> @lang('site.password_confirmation')</label>
                                        <input type="text" name="password_confirmation"
                                               value="{{ old('password_confirmation') }}"
                                               class="form-control @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation"
                                               placeholder="@lang('site.password_confirmation')">

                                        @error ('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="card card-primary card-tabs">
                                            @php
                                                $models = config('config_me.models');
                                                $maps = config('config_me.maps')
                                            @endphp
                                            <style>.card-header .nav-item .active {color: #495057 !important;}</style>
                                            <div class="card-header p-0 pt-1">
                                                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                                    <li class="pt-2 px-3">
                                                        <h3 class="card-title">@lang('site.permissions')</h3>
                                                    </li>
                                                    @foreach ($models as $index=>$model)
                                                        <li class="nav-item">
                                                            <a class="nav-link {{ $index == 0 ? 'active' : '' }} "
                                                               id="{{ $model }}-tab" data-toggle="pill"
                                                               href="#{{ $model }}" role="tab"
                                                               aria-controls="{{ $model }}"
                                                               aria-selected="true">@lang('site.' .$model)</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="custom-tabs-two-tabContent">
                                                    @foreach ($models as $index=>$model)
                                                        <div
                                                            class="tab-pane fade {{ $index == 0 ? 'show active ' : '' }}"
                                                            id="{{ $model }}" role="tabpanel"
                                                            aria-labelledby="{{ $model }}-tab">
                                                            @foreach ($maps as $map)
                                                                <label><input type="checkbox" name="permissions[]"
                                                                              value="{{ $map . '_' . $model }}"> @lang('site.' .$map)
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> @lang('site.add')</button>
                                    </div>

                                </form><!-- end of form -->
                            </div>
                        </div><!-- /.card -->
                    </div><!-- /.col-->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div><!-- end of content wrapper -->
@endsection
