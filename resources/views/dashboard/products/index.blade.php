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
                                        class="fa fa-home"></i> @lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('site.products')</li>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('site.products')
                                    <small> {{ $products->total() }}</small></h3>
                                {{-- <div class="card-tools"> --}}
                                <form action="{{ route('dashboard.products.index') }}" method="get">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search" class="form-control float-right"
                                               value="{{ request()->search }}" placeholder="@lang('site.search')">
                                        <select name="product_id" class="form-control">
                                            <option value="">@lang('site.all_categories')</option>
                                            @foreach ($categories as $product)
                                                <option
                                                    value="{{ $product->id }}" {{ request()->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i
                                                    class="fa fa-search"></i> @lang('site.search')</button>
                                            @can ('create_products')
                                                <a href="{{ route('dashboard.products.create') }}"
                                                   class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </form><!-- end of form -->
                                {{-- </div> --}}
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('site.name')</th>
                                            <th>@lang('site.category')</th>
                                            <th>@lang('site.image')</th>
                                            <th>@lang('site.price')</th>
                                            <th>@lang('site.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($products as $index=>$product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                <td><img src="{{ $product->image_path }}" style="width: 100px"
                                                         class="img-thumbnail"></td>
                                                <td>{{ $product->price }}</td>
                                                <td class="py-0 align-middle">
                                                    <div class="btn-group btn-group-sm">
                                                        @can ('update_products')
                                                            <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                                               class="btn btn-info"><i
                                                                    class="fa fa-edit"></i> @lang('site.edit')</a>
                                                        @endcan
                                                        @can ('delete_products')
                                                            <a href="#" class="btn delete btn-danger"><i
                                                                    class="fa fa-trash"></i> @lang('site.delete')</a>
                                                            <form
                                                                action="{{ route('dashboard.products.destroy', $product->id) }}"
                                                                method="post" style="display: inline-block">
                                                                {{ csrf_field() }}{{ method_field('delete') }}
                                                            </form><!-- end of form -->
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="15" class="text-center">@lang('site.no_data_found')</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table><!-- end of table -->
                                    {{ $products->appends(request()->query())->links() }}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div><!-- end of content wrapper -->
@endsection
