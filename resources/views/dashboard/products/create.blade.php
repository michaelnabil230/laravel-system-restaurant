@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('dashboard.products')</h1>
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
                                <a href="{{ route('dashboard.products.index') }}">
                                    @lang('dashboard.products')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@lang('dashboard.add')</li>
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
                                <h3 class="card-title">@lang('dashboard.add')</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data"
                                    method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('post') }}
                                    <div class="form-group">
                                        <label class="control-label" for="categories">
                                            @lang('dashboard.categories')</label>
                                        <select name="category_id" id="categories"
                                            placeholder="@lang('dashboard.categories')"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">@lang('dashboard.all_categories')</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                                        <div class="form-group">
                                            <label class="control-label" for="name_{{ $locale }}">
                                                @lang('dashboard.'.$locale . '.name')
                                            </label>
                                            <input type="text" name="name[{{ $locale }}]"
                                                value="{{ old('name.' . $locale) }}"
                                                class="form-control @error('name.' . $locale) is-invalid @enderror"
                                                id="name_{{ $locale }}"
                                                placeholder="@lang('dashboard.'.$locale . '.name')">
                                            @error('name.' . $locale)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                                    <div class="form-group">
                                        <label class="control-label" for="price"> @lang('dashboard.price')</label>
                                        <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                                            class="form-control @error('price') is-invalid @enderror" id="price"
                                            placeholder="@lang('dashboard.price')" step="0.01" min="1">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="image">@lang('dashboard.image')</label>
                                        <div class="custom-file">
                                            <input type="file" name="image"
                                                class="custom-file-input @error('image') is-invalid @enderror" id="image">
                                            <label class="custom-file-label"
                                                for="image">@lang('dashboard.choose_image')</label>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
