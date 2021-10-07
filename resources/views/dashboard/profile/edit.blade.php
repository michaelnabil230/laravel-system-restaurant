@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.my_profile')</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-info card-outline">
                            <div class="card-header"><h3 class="card-title">@lang('site.profile_info')</h3></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('dashboard.profile.info.update') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="name"> @lang('site.name')</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                               class="form-control @error ('name') is-invalid @enderror"
                                               id="name"
                                               placeholder="@lang('site.name')">
                                        @error ('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="email"> @lang('site.email')</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                               class="form-control @error ('email') is-invalid @enderror"
                                               id="email"
                                               placeholder="@lang('site.email')">
                                        @error ('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            @lang('site.save')
                                        </button>
                                    </div>
                                </form><!-- end of form -->
                            </div>
                        </div><!-- /.card -->
                    </div><!-- /.col-->

                    <div class="col-md-6">
                        <div class="card card-info card-outline">
                            <div class="card-header"><h3 class="card-title">@lang('site.change_password')</h3></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('dashboard.profile.password.update') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="password"> @lang('site.password')</label>
                                        <input type="password" name="password" value="{{ old('password') }}"
                                               class="form-control @error ('password') is-invalid @enderror"
                                               id="password"
                                               placeholder="@lang('site.password')">
                                        @error ('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="password_confirmation"> @lang('site.password_confirmation')</label>
                                        <input type="password" name="password_confirmation"
                                               value="{{ old('password_confirmation') }}"
                                               class="form-control @error ('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation"
                                               placeholder="@lang('site.password_confirmation')">
                                        @error ('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            @lang('site.save')
                                        </button>
                                    </div>
                                </form><!-- end of form -->
                            </div>
                        </div><!-- /.card -->
                    </div><!-- /.col-->

                    <div class="col-md-6">
                        <div class="card card-info card-outline">
                            <div class="card-header"><h3 class="card-title">@lang('site.delete_account')</h3></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('dashboard.profile.destroy') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger">
                                            @lang('site.delete')
                                        </button>
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
