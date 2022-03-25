<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @php($user = auth()->user())

    <a href="{{ route('dashboard.welcome') }}" class="brand-link">
        <img src="{{ Storage::url(setting('logo')) }}" alt="Logo" class="brand-image"
            style="border-radius: .25rem;opacity: .8">
        <span class="brand-text font-weight-light">{{ setting('name') }}</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('default.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('dashboard.profile.edit') }}" class="d-block">{{ $user->name }}
                </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li>
                    <select class="searchable-field form-control"></select>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('dashboard.welcome') ? 'active' : '' }}"
                        href="{{ route('dashboard.welcome') }}"><i class="nav-icon fa fa-home"></i>
                        <p> @lang('dashboard.dashboard')</p>
                    </a>
                </li>
                @if ($user->hasAnyPermission(['read_categories', 'create_categories']))
                    <li
                        class="nav-item has-treeview {{ Route::is('dashboard.categories.index') || Route::is('dashboard.categories.create') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Route::is('dashboard.categories.index') || Route::is('dashboard.categories.create') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-list-alt"></i>
                            <p>
                                @lang('dashboard.categories')
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('read_categories')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.categories.index') }}"
                                        class="nav-link {{ Route::is('dashboard.categories.index') ? 'active' : '' }}">
                                        <i class="fa fa-list-alt nav-icon"></i>
                                        <p>@lang('dashboard.categories')</p>
                                    </a>
                                </li>
                            @endcan
                            @can('create_categories')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.categories.create') }}"
                                        class="nav-link {{ Route::is('dashboard.categories.create') ? 'active' : '' }}">
                                        <i class="fa fa-plus nav-icon"></i>
                                        <p>@lang('dashboard.add')</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                @if ($user->hasAnyPermission(['read_products', 'create_products']))
                    <li
                        class="nav-item has-treeview {{ Route::is('dashboard.products.index') || Route::is('dashboard.products.create') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Route::is('dashboard.products.index') || Route::is('dashboard.products.create') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                @lang('dashboard.products')
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('read_products')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.products.index') }}"
                                        class="nav-link {{ Route::is('dashboard.products.index') ? 'active' : '' }}">
                                        <i class="fa fa-th nav-icon"></i>
                                        <p>@lang('dashboard.products')</p>
                                    </a>
                                </li>
                            @endcan
                            @can('create_products')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.products.create') }}"
                                        class="nav-link {{ Route::is('dashboard.products.create') ? 'active' : '' }}">
                                        <i class="fa fa-plus nav-icon"></i>
                                        <p>@lang('dashboard.add')</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if ($user->hasAnyPermission(['read_orders', 'create_orders']))
                    <li
                        class="nav-item has-treeview {{ Route::is('dashboard.orders.index') || Route::is('dashboard.orders.create') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Route::is('dashboard.orders.index') || Route::is('dashboard.orders.create') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-shopping-bag"></i>
                            <p>
                                @lang('dashboard.orders')
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('read_orders')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.orders.index') }}"
                                        class="nav-link {{ Route::is('dashboard.orders.index') ? 'active' : '' }}">
                                        <i class="fa fa-shopping-bag nav-icon"></i>
                                        <p>@lang('dashboard.orders')</p>
                                    </a>
                                </li>
                            @endcan
                            @can('create_orders')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.orders.create') }}"
                                        class="nav-link {{ Route::is('dashboard.orders.create') ? 'active' : '' }}">
                                        <i class="fa fa-plus nav-icon"></i>
                                        <p>@lang('dashboard.add')</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                @if ($user->hasAnyPermission(['read_drivers', 'create_drivers']))
                    <li
                        class="nav-item has-treeview {{ Route::is('dashboard.drivers.index') || Route::is('dashboard.drivers.create') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Route::is('dashboard.drivers.index') || Route::is('dashboard.drivers.create') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                @lang('dashboard.drivers')
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('read_drivers')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.drivers.index') }}"
                                        class="nav-link {{ Route::is('dashboard.drivers.index') ? 'active' : '' }}">
                                        <i class="fa fa-th nav-icon"></i>
                                        <p>@lang('dashboard.drivers')</p>
                                    </a>
                                </li>
                            @endcan
                            @can('create_drivers')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.drivers.create') }}"
                                        class="nav-link {{ Route::is('dashboard.drivers.create') ? 'active' : '' }}">
                                        <i class="fa fa-plus nav-icon"></i>
                                        <p>@lang('dashboard.add')</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if ($user->hasAnyPermission(['read_admins', 'create_admins']))
                    <li
                        class="nav-item has-treeview {{ Route::is('dashboard.admins.index') || Route::is('dashboard.admins.create') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Route::is('dashboard.admins.index') || Route::is('dashboard.admins.create') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                @lang('dashboard.admins')
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('read_admins')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.admins.index') }}"
                                        class="nav-link {{ Route::is('dashboard.admins.index') ? 'active' : '' }}">
                                        <i class="fa fa-users nav-icon"></i>
                                        <p>@lang('dashboard.admins')</p>
                                    </a>
                                </li>
                            @endcan
                            @can('create_admins')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.admins.create') }}"
                                        class="nav-link {{ Route::is('dashboard.admins.create') ? 'active' : '' }}">
                                        <i class="fa fa-plus nav-icon"></i>
                                        <p>@lang('dashboard.add')</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                @role('super_admin')
                    <li
                        class="nav-item has-treeview {{ Route::is('dashboard.settings.index') || Route::is('dashboard.settings.create') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Route::is('dashboard.settings.index') || Route::is('dashboard.settings.create') ? 'active' : '' }}">
                            <i class="nav-icon fa fa fa-cogs"></i>
                            <p>
                                @lang('dashboard.settings')
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.settings.index') }}"
                                    class="nav-link {{ Route::is('dashboard.settings.index') ? 'active' : '' }}">
                                    <i class="fa fa fa-cogs nav-icon"></i>
                                    <p>@lang('dashboard.settings')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.settings.create') }}"
                                    class="nav-link {{ Route::is('dashboard.settings.create') ? 'active' : '' }}">
                                    <i class="fa fa-plus nav-icon"></i>
                                    <p>@lang('dashboard.add')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('dashboard.setting.audit-logs.index') ? 'active' : '' }}"
                            href="{{ route('dashboard.setting.audit-logs.index') }}"><i
                                class="nav-icon fa fa-database"></i>
                            <p> @lang('dashboard.audit_logs')</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('dashboard.setting.backups.index') ? 'active' : '' }}"
                            href="{{ route('dashboard.setting.backups.index') }}"><i class="nav-icon fa fa-database"></i>
                            <p> @lang('dashboard.backups')</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('dashboard.setting.reports.index') ? 'active' : '' }}"
                            href="{{ route('dashboard.setting.reports.index') }}"><i class="nav-icon fa fa-file"></i>
                            <p> @lang('dashboard.reports')</p>
                        </a>
                    </li>
                @endrole

                @php($unread = \App\Models\QaTopic::unreadCount())
                <li class="nav-item">
                    <a href="{{ route('dashboard.messenger.index') }}"
                        class="{{ Route::is('dashboard.messenger.*') ? 'active' : '' }} nav-link">
                        <i class="fa-fw fa fa-envelope nav-icon"></i>
                        <p>@lang('dashboard.messages')</p>
                        @if ($unread > 0)
                            <strong>({{ $unread }})</strong>
                        @endif
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
