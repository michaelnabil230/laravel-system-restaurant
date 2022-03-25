@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('dashboard.categories')</h1>
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
                                <a href="{{ route('dashboard.categories.index') }}">
                                    @lang('dashboard.categories')
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
                                <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}

                                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                                        <div class="form-group">
                                            <label class="control-label" for="name_{{ $locale }}">
                                                @lang('dashboard.' .$locale . '.name')
                                            </label>
                                            <input type="text" name="name[{{ $locale }}]"
                                                value="{{ $product->getTranslation('name', $locale) }}"
                                                class="form-control @error('name.' . $locale) is-invalid @enderror"
                                                id="name_{{ $locale }}"
                                                placeholder="@lang('dashboard.'. $locale . '.name')">
                                            @error('name.' . $locale)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach

                                    <div class="form-group">
                                        <label class="control-label" for="position">
                                            @lang('dashboard.position')
                                        </label>
                                        <input type="number" min="1" name="position" value="{{ $category->position }}"
                                            class="form-control @error('position') is-invalid @enderror" id="position"
                                            placeholder="@lang('dashboard.position')">
                                        @error('position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
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
