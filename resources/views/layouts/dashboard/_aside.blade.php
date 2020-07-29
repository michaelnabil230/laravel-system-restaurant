<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.welcome') }}" class="brand-link">
        <img src="{{ setting('logo_path') }}" alt="Logo" class="brand-image img-circle" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ setting('name') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('default.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item"><a class="nav-link {{ (request()->segment(3) == '') ? 'active' : '' }}"
                                        href="{{ route('dashboard.welcome') }}"><i
                            class="fa fa-home"></i>
                        <p> @lang('site.dashboard')</p></a></li>

                @can('read_categories')
                    <li class="nav-item"><a
                            class="nav-link {{ (request()->segment(3) == 'categories') ? 'active' : '' }}"
                            href="{{ route('dashboard.categories.index') }}"><i
                                class="fa fa-th"></i>
                            <p> @lang('site.categories')</p></a></li>
                @endcan

                @can('read_products')
                    <li class="nav-item"><a class="nav-link {{ (request()->segment(3) == 'products') ? 'active' : '' }}"
                                            href="{{ route('dashboard.products.index') }}"><i
                                class="fa fa-th"></i>
                            <p> @lang('site.products')</p></a></li>
                @endcan

                @can('read_orders')
                    <li class="nav-item"><a class="nav-link {{ (request()->segment(3) == 'orders') ? 'active' : '' }}"
                                            href="{{ route('dashboard.orders.index') }}"><i
                                class="fa fa-shopping-bag"></i>
                            <p> @lang('site.orders')</p></a></li>
                @endcan

                @can('read_drivers')
                    <li class="nav-item"><a class="nav-link {{ (request()->segment(3) == 'drivers') ? 'active' : '' }}"
                                            href="{{ route('dashboard.drivers.index') }}"><i
                                class="fa fa-th"></i>
                            <p> @lang('site.drivers')</p></a></li>
                @endcan
                @can('read_users')
                    <li class="nav-item"><a class="nav-link {{ (request()->segment(3) == 'users') ? 'active' : '' }}"
                                            href="{{ route('dashboard.users.index') }}"><i
                                class="fa fa-users"></i>
                            <p> @lang('site.users')</p></a></li>
                @endcan

                @if (Auth::id() == 1)
                    <li class="nav-item"><a class="nav-link {{ (request()->segment(3) == 'reports') ? 'active' : '' }}"
                                            href="{{ route('dashboard.reports.index') }}"><i
                                class="fa fa-file"></i>
                            <p> @lang('site.reports')</p></a></li>
                    <li class="nav-item"><a class="nav-link {{ (request()->segment(3) == 'setting') ? 'active' : '' }}"
                                            href="{{ route('dashboard.setting.index') }}"><i
                                class="fa fa-cogs"></i>
                            <p> @lang('site.setting')</p></a></li>
                    <li class="nav-item"><a class="nav-link {{ (request()->segment(3) == 'backups') ? 'active' : '' }}"
                                            href="{{ route('dashboard.backups.index') }}"><i
                                class="fa fa-database"></i>
                            <p> @lang('site.backups')</p></a></li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
