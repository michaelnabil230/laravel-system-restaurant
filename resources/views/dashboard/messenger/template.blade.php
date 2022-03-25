@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.welcome') }}"><i class="fa fa-home"></i>
                                    @lang('dashboard.dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-3">
                    <p>
                        <a href="{{ route('dashboard.messenger.createTopic') }}" class="btn btn-primary btn-block">
                            @lang('dashboard.new_message')
                        </a>
                    </p>
                    <div class="list-group">
                        <a href="{{ route('dashboard.messenger.index') }}" class="list-group-item">
                            @lang('dashboard.all_messages')
                        </a>
                        <a href="{{ route('dashboard.messenger.showInbox') }}" class="list-group-item">
                            @if ($unreads['inbox'] > 0)
                                <strong>
                                    @lang('dashboard.inbox')
                                    ({{ $unreads['inbox'] }})
                                </strong>
                            @else
                                @lang('dashboard.inbox')
                            @endif
                        </a>
                        <a href="{{ route('dashboard.messenger.showOutbox') }}" class="list-group-item">
                            @if ($unreads['outbox'] > 0)
                                <strong>
                                    @lang('dashboard.outbox')
                                    ({{ $unreads['outbox'] }})
                                </strong>
                            @else
                                @lang('dashboard.outbox')
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
