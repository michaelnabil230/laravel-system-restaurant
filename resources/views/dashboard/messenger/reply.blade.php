@extends('dashboard.messenger.template')

@section('title', __('site.new_message'))

@section('messenger-content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-body">
                    <form action="{{ route('dashboard.messenger.reply', [$topic->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="control-label" for="content">
                                @lang('site.content')
                            </label>
                            <textarea name="content"
                                      class="form-control @error ('content') is-invalid @enderror"
                                      id="content"
                                      placeholder="@lang('site.content')">{{ old('content') }}</textarea>
                            @error ('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                @lang('site.reply')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
