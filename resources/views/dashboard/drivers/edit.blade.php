@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.drivers')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i>@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.drivers.index') }}"> @lang('site.drivers')</a></li>
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
                                <form action="{{ route('dashboard.drivers.update', $driver->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}

                                    <div class="form-group">
                                        <label class="control-label"
                                               for="name"> @lang('site.name')</label>
                                        <input type="text" name="name"
                                               value="{{ $driver->name }}"
                                               class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                               id="name"
                                               placeholder="@lang('site.name')">
                                        @if ($errors->has('name'))
                                            <div
                                                class="invalid-feedback">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                    @for ($i = 0; $i < 2; $i++)
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="phone"> @lang('site.phone')</label>
                                            <input type="number" min="1" name="phone[]"
                                                   value="{{ $driver->phone[$i] ?? '' }}"
                                                   class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                   id="phone"
                                                   placeholder="@lang('site.phone')">
                                            @if ($errors->has('phone'))
                                                <div
                                                    class="invalid-feedback">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>
                                    @endfor
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
