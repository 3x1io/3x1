<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">

            <li class="nav-item"><a class="nav-link" href="{{ url('admin') }}"><i class="nav-icon fa fa-home"></i> {{ __('Dashboard') }}</a></li>
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>


           <li class="nav-item"><a class="nav-link" href="{{ url('admin/customers') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.customer.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle " href="#">
                    <i class="nav-icon fa fa-lock"></i>
                    {{ __('Access') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon fa fa-users "></i> {{ __('Manage access') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/roles') }}"><i class="nav-icon fa fa-user-secret"></i> {{ trans('admin.role.title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/permissions') }}"><i class="nav-icon fa fa-lock"></i> {{ trans('admin.permission.title') }}</a></li>
                </ul>
            </li>
            <li class="nav-item  nav-dropdown  ">
                <a class="nav-link  nav-dropdown-toggle " href="#">
                    <i class="nav-icon fa fa-language"></i>
                    {{ __('Localization') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/localization') }}"><i class="nav-icon fa fa-map"></i> {{ __('Localization Setting') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon fa fa-globe"></i> {{ __('Translations') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/languages') }}"><i class="nav-icon fa fa-language"></i> {{ trans('admin.language.title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/countries') }}"><i class="nav-icon fa fa-flag"></i> {{ trans('admin.country.title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/cities') }}"><i class="nav-icon fa fa-map-marker"></i> {{ trans('admin.city.title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/areas') }}"><i class="nav-icon fa fa-map-pin"></i> {{ trans('admin.area.title') }}</a></li>
                </ul>
            </li>
            <li class="nav-item  nav-dropdown  ">
                <a class="nav-link  nav-dropdown-toggle " href="#">
                    <i class="nav-icon fa fa-bell"></i>
                    {{ __('Notification') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/user-notifications') }}"><i class="nav-icon fa fa-user-circle"></i> {{ trans('admin.user-notification.title') }}</a></li>
                </ul>
            </li>
            <li class="nav-item  nav-dropdown  ">
                <a class="nav-link  nav-dropdown-toggle " href="#">
                    <i class="nav-icon fa fa-google"></i>
                    {{ __('Services') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/themes') }}"><i class="nav-icon fa fa-paint-brush"></i> {{ __('Themes') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/blocks') }}"><i class="nav-icon fa fa-square"></i> {{ trans('admin.block.title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/payment') }}"><i class="nav-icon fa fa-credit-card"></i> {{ __('Payments') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/email') }}"><i class="nav-icon fa fa-envelope"></i> {{ __('Email') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/services') }}"><i class="nav-icon fa fa-amazon"></i> {{ __('Services') }}</a></li>
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/settings') }}"><i class="nav-icon fa fa-gear"></i> {{ __('Settings') }}</a></li>

            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
