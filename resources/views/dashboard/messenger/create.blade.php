@extends('dashboard.messenger.template')

@section('title', __('dashboard.new_message'))

@section('messenger-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-body">
                    <form action="{{ route('dashboard.messenger.storeTopic') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="control-label" for="recipient"> @lang('dashboard.recipient')</label>
                            <select name="recipient" id="recipient" placeholder="@lang('dashboard.recipient')"
                                class="form-control @error('recipient') is-invalid @enderror">
                                <option value="">@lang('dashboard.all_recipients')</option>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}"
                                        {{ old('recipient') == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name . ' - ' . $admin->email }}</option>
                                @endforeach
                            </select>
                            @error('recipient')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="subject">
                                @lang('dashboard.subject')
                            </label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                                id="subject" value="{{ old('subject') }}" placeholder="@lang('dashboard.subject')" />
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content">
                                @lang('dashboard.content')
                            </label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content"
                                placeholder="@lang('dashboard.content')">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-plus"></i> @lang('dashboard.add')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
