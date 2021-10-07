<div class="col-md-12">
    <div class="card card-help card-info card-outline collapsed-card">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">@lang('site.help')</h3>
            </div>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-plus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: none;">
            <div class="row">
                @forelse (config('config_me.keys_settings') as $key)
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-md btn-danger copy-text">
                            <i class="fa fa-copy"></i> {{ $key }}
                        </button>
                    </div>
                @empty
                    @lang('site.please_check_the_file_config_me.php_in_your_files')
                @endforelse
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $('.copy-text').on('click', function (e) {
            e.preventDefault();
            var text = $(this).text().trim();
            $('#key').val(text);
            $('#search').val(text);
            new Noty({
                type: 'success',
                layout: 'topRight',
                text: "@lang('site.copy_successfully')",
                timeout: 2000,
                killer: true
            }).show();
            $('.card-help').CardWidget('toggle');
        });
    </script>
@endpush
