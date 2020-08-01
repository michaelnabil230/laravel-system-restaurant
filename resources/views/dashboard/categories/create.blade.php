@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.categories')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i>@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.categories.index') }}"> @lang('site.categories')</a></li>
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
                                <form action="{{ route('dashboard.categories.store') }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('post') }}

                                    @foreach (config('config_me.locales') as $locale)
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="name_{{ $locale }}"> @lang('site.' . $locale . '.name')</label>
                                            <input type="text" name="name_{{ $locale }}"
                                                   value="{{ old('name_'.$locale) }}"
                                                   class="form-control @error ('name_'.$locale) is-invalid @enderror"
                                                   id="name_{{ $locale }}"
                                                   placeholder="@lang('site.'.$locale . '.name')">
                                            @error ('name_'.$locale)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="position"> @lang('site.position')</label>
                                        <input type="number" min="1" name="position" value="{{ old('position') }}"
                                               class="form-control @error ('position') is-invalid @enderror"
                                               id="position"
                                               placeholder="@lang('site.position')">
                                        @error ('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> @lang('site.add')</button>
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
