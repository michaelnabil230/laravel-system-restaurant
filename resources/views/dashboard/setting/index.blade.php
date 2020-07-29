@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.setting')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i>@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.setting.index') }}"> @lang('site.setting')</a></li>
                            <li class="breadcrumb-item active">@lang('site.edit')</li>
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
                            <div class="card-header"><h3 class="card-title">@lang('site.edit')</h3></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('dashboard.setting.post') }}" method="post"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('post') }}

                                    <div class="form-group">
                                        <label class="control-label"
                                               for="name"> @lang('site.name')</label>
                                        <input type="text" name="name"
                                               value="{{ old('name',$setting->name) }}"
                                               class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                               id="name"
                                               placeholder="@lang('site.name')">
                                        @if ($errors->has('name'))
                                            <div
                                                class="invalid-feedback">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="value_added"> @lang('site.value_added')</label>
                                        <div class="input-group mb-3">
                                            <input type="number" name="value_added"
                                                   value="{{ old('value_added',$setting->value_added) }}"
                                                   class="form-control {{ $errors->has('value_added') ? ' is-invalid' : '' }}"
                                                   id="value_added"
                                                   placeholder="@lang('site.value_added')"
                                                   step="0.01" min="1">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-percent"></i></span>
                                            </div>
                                            @if ($errors->has('value_added'))
                                                <div class="invalid-feedback">{{ $errors->first('value_added') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="logo">@lang('site.logo')</label>
                                        <div class="custom-file">
                                            <input type="file" name="logo"
                                                   class="custom-file-input {{ $errors->has('logo') ? ' is-invalid' : '' }}"
                                                   id="logo">
                                            <label class="custom-file-label"
                                                   for="logo">@lang('site.choose_logo')</label>
                                            @if ($errors->has('logo'))
                                                <div class="invalid-feedback">{{ $errors->first('logo') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-edit"></i> @lang('site.edit')</button>
                                    </div>

                                </form><!-- end of form -->
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col-->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div><!-- end of content wrapper -->
@endsection
