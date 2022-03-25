@extends('dashboard.messenger.template')

@section('title', $title)

@section('messenger-content')
    <div class="row">
        <div class="col-12">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-bottom: 15px">
                            {{ $title }}
                            <small> {{ $topics->total() }}</small>
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('dashboard.email')</th>
                                        <th>@lang('dashboard.subject')</th>
                                        <th>@lang('dashboard.time')</th>
                                        <th>@lang('dashboard.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topics as $topic)
                                        <tr>
                                            <td>{{ $loop->index++ }}</td>
                                            <td>
                                                @php($receiverOrCreator = $topic->receiverOrCreator())
                                                @if ($topic->hasUnreads())
                                                    <strong>
                                                        {{ $receiverOrCreator !== null ? $receiverOrCreator->email : '' }}
                                                    </strong>
                                                @else
                                                    {{ $receiverOrCreator !== null ? $receiverOrCreator->email : '' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($topic->hasUnreads())
                                                    <strong>{{ $topic->subject }}</strong>
                                                @else
                                                    {{ $topic->subject }}
                                                @endif
                                            </td>
                                            <td>{{ $topic->created_at->diffForHumans() }}</td>
                                            <td class="py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('dashboard.messenger.showMessages', [$topic->id]) }}"
                                                        class="btn btn-info"><i class="fa fa-eye"></i>
                                                        @lang('dashboard.show')
                                                    </a>

                                                    <a href="#" class="btn delete btn-danger"><i class="fa fa-trash"></i>
                                                        @lang('dashboard.delete')
                                                    </a>
                                                    <form
                                                        action="{{ route('dashboard.messenger.destroyTopic', [$topic->id]) }}"
                                                        method="post" style="display: inline-block">
                                                        {{ csrf_field() }}{{ method_field('delete') }}
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="15" class="text-center">@lang('dashboard.no_data_found')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $topics->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
