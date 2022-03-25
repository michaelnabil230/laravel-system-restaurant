@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('dashboard.orders')</h1>
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
                                <a href="{{ route('dashboard.orders.index') }}">
                                    @lang('dashboard.orders')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@lang('dashboard.edit')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('dashboard.orders._form')
    </div>
@endsection
