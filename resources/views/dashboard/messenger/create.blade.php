@extends('dashboard.messenger.template')

@section('title', __('site.new_message'))

@section('messenger-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-body">
                    <form action="{{ route("dashboard.messenger.storeTopic") }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="control-label"
                                   for="recipient"> @lang('site.recipient')</label>
                            <select name="recipient" id="recipient"
                                    placeholder="@lang('site.recipient')"
                                    class="form-control @error('recipient') is-invalid @enderror">
                                <option value="">@lang('site.all_recipients')</option>
                                @foreach ($admins as $admin)
                                    <option
                                        value="{{ $admin->id }}" {{ old('recipient') == $admin->id ? 'selected' : '' }}>{{ $admin->name .' - ' . $admin->email }}</option>
                                @endforeach
                            </select>
                            @error ('recipient')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="subject">
                                @lang('site.subject')
                            </label>
                            <input type="text" name="subject"
                                   class="form-control @error ('subject') is-invalid @enderror"
                                   id="subject" value="{{ old('subject') }}"
                                   placeholder="@lang('site.subject')"/>
                            @error ('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                                <i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
