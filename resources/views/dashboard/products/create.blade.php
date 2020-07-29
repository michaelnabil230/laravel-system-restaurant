@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.products')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i>@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.products.index') }}"> @lang('site.products')</a></li>
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
                                <form action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data"
                                      method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('post') }}

                                    <div class="form-group">
                                        <label class="control-label" for="categories"> @lang('site.categories')</label>
                                        <select name="category_id" id="categories"
                                                placeholder="@lang('site.categories')"
                                                class="form-control {{ $errors->has('category_id') ? ' is-invalid' : '' }}">
                                            <option value="">@lang('site.all_categories')</option>
                                            @foreach ($categories as $category)
                                                <option
                                                    value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                            <div class="invalid-feedback">{{ $errors->first('category_id') }}</div>
                                        @endif
                                    </div>

                                    @foreach (config('config_me.locales') as $locale)
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="name_{{ $locale }}"> @lang('site.' . $locale . '.name')</label>
                                            <input type="text" name="name_{{ $locale }}"
                                                   value="{{ old('name_'.$locale) }}"
                                                   class="form-control {{ $errors->has('name_'.$locale) ? ' is-invalid' : '' }}"
                                                   id="name_{{ $locale }}"
                                                   placeholder="@lang('site.'.$locale . '.name')">
                                            @if ($errors->has('name_'.$locale))
                                                <div
                                                    class="invalid-feedback">{{ $errors->first('name_'.$locale) }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class="form-group">
                                        <label class="control-label" for="price"> @lang('site.price')</label>
                                        <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                                               class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}"
                                               id="price" placeholder="@lang('site.price')" step="0.01" min="1">
                                        @if ($errors->has('price'))
                                            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="image">@lang('site.image')</label>
                                        <div class="custom-file">
                                            <input type="file" name="image"
                                                   class="custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                   id="image">
                                            <label class="custom-file-label"
                                                   for="image">@lang('site.choose_image')</label>
                                            @if ($errors->has('image'))
                                                <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> @lang('site.add')</button>
                                    </div>

                                </form><!-- end of form -->
                            </div>
                        </div><!-- /.card -->
                    </div> <!-- /.col-->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div><!-- end of content wrapper -->
@endsection
