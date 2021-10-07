@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('title')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i> @lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-3">
                    <p>
                        <a href="{{ route('dashboard.messenger.createTopic') }}" class="btn btn-primary btn-block">
                            @lang('site.new_message')
                        </a>
                    </p>
                    <div class="list-group">
                        <a href="{{ route('dashboard.messenger.index') }}" class="list-group-item">
                            @lang('site.all_messages')
                        </a>
                        <a href="{{ route('dashboard.messenger.showInbox') }}" class="list-group-item">
                            @if($unreads['inbox'] > 0)
                                <strong>
                                    @lang('site.inbox')
                                    ({{ $unreads['inbox'] }})
                                </strong>
                            @else
                                @lang('site.inbox')
                            @endif
                        </a>
                        <a href="{{ route('dashboard.messenger.showOutbox') }}" class="list-group-item">
                            @if($unreads['outbox'] > 0)
                                <strong>
                                    @lang('site.outbox')
                                    ({{ $unreads['outbox'] }})
                                </strong>
                            @else
                                @lang('site.outbox')
                            @endif
                        </a>
                    </div>
                </div>
                <div class="col-lg-9">
                    @yield('messenger-content')
                </div>
            </div>
        </div>
    </div>


@endsection
