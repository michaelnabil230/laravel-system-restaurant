@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.backups')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i> @lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('site.backups')</li>
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
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('site.backups')
                                    <small> {{ $backups->count() }}</small></h3>
                                <div class="card-tools">
                                    <form action="{{ route('dashboard.backups.create') }}" method="post">
                                        {{ csrf_field() }}{{ method_field('post') }}
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-plus"></i> @lang('site.generate_backup')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('site.name')</th>
                                            <th>@lang('site.time')</th>
                                            <th>@lang('site.size')</th>
                                            <th>@lang('site.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($i = 1)
                                        @forelse ($backups as $index => $backup)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $backup['name'] }}</td>
                                                <td>{{ $backup['time'] }}</td>
                                                <td>{{ $backup['size'] }}</td>
                                                <td class="py-0 align-middle">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="?download={{ $backup['name'] }}"
                                                           class="btn btn-primary"><i
                                                                class="fa fa-download"></i> @lang('site.download')</a>

                                                        <a href="#" class="btn restore btn-info"><i
                                                                class="fa fa-retweet"></i> @lang('site.restore')</a>
                                                        <form
                                                            class="restore"
                                                            action="{{ route('dashboard.backups.process',['file'=>$backup['name'],'action'=>'restore']) }}"
                                                            method="post" style="display: inline-block">
                                                            {{ csrf_field() }}
                                                        </form><!-- end of form -->

                                                        <a href="#" class="btn delete btn-danger"><i
                                                                class="fa fa-trash"></i> @lang('site.delete')</a>
                                                        <form
                                                            action="{{ route('dashboard.backups.process',['file'=>$backup['name'],'action'=>'remove']) }}"
                                                            method="post" style="display: inline-block">
                                                            {{ csrf_field() }}
                                                        </form><!-- end of form -->
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
                                    {{ $backups->links() }}
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
@push('scripts')
    <script>
        //restore
        $('.restore').click(function (e) {
            var that = $(this)
            e.preventDefault();
            var n = new Noty({
                text: "@lang('site.confirm_restore')",
                type: "warning",
                killer: true,
                buttons: [
                    Noty.button("@lang('site.yes')", 'btn btn-success mr-2', function () {
                        that.parent().find('form.restore').submit();
                    }),
                    Noty.button("@lang('site.no')", 'btn btn-primary mr-2', function () {
                        n.close();
                    })
                ]
            });
            n.show();
        });//end of restore

    </script>
@endpush
