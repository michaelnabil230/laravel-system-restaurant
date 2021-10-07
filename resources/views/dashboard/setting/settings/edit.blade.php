@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.settings')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i>@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.settings.index') }}">
                                    @lang('site.settings')</a></li>
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
                    @include('dashboard.setting.settings._inc.help')
                    <div class="col-md-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">@lang('site.edit')</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('dashboard.settings.update', $setting->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <div class="form-group">
                                        <label class="control-label" for="locale"> @lang('site.locale')</label>
                                        <select name="locale" id="locale" placeholder="@lang('site.locale')"
                                                class="form-control @error('locale') is-invalid @enderror">
                                            <option value="all">@lang('site.all_locale')</option>
                                            @foreach (config('config_me.locales') as $locale)
                                                <option value="{{ $locale }}"
                                                    {{ $setting->locale == $locale ? 'selected' : '' }}>{{ $locale }}</option>
                                            @endforeach
                                        </select>
                                        @error ('locale')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="gender"> @lang('site.gender')</label>
                                        <select id="gender" name="gender"
                                                class="form-control @error('gender') is-invalid @enderror">
                                            <option
                                                {{ $setting->gender == 'all_genders' ? 'selected' : '' }} value="all_genders">@lang('site.all_genders')</option>
                                            <option
                                                {{ $setting->gender == 'male' ? 'selected' : '' }} value="male">@lang('site.genders.male')</option>
                                            <option
                                                {{ $setting->gender == 'female' ? 'selected' : '' }} value="female">@lang('site.genders.female')</option>
                                        </select>
                                        @error ('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="key"> @lang('site.key')</label>
                                        <input type="text" name="key" value="{{ $setting->key }}"
                                               class="form-control @error('key') is-invalid @enderror" id="key"
                                               placeholder="@lang('site.key')">
                                        @error ('key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="value"> @lang('site.value')</label>
                                        <textarea name="value" id="value"
                                                  class="form-control @error('value') is-invalid @enderror"
                                                  placeholder="@lang('site.value')">{{ $setting->value }}</textarea>
                                        @error ('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-edit"></i> @lang('site.edit')</button>
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
