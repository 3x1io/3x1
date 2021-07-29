<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">

            <li class="nav-item"><a class="nav-link" href="{{ url('admin') }}"><i class="nav-icon icon-home"></i> {{ __('Dashboard') }}</a></li>
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>


           {{-- Do not delete me :) I'm used for auto-generation menu items --}}
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle " href="#">
                    <i class="nav-icon icon-lock"></i>
                    {{ __('Access') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user "></i> {{ __('Manage access') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/roles') }}"><i class="nav-icon fa icon-organization"></i> {{ trans('admin.role.title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/permissions') }}"><i class="nav-icon fa icon-lock-open"></i> {{ trans('admin.permission.title') }}</a></li>
                </ul>
            </li>
            <li class="nav-item  nav-dropdown  ">
                <a class="nav-link  nav-dropdown-toggle " href="#">
                    <i class="nav-icon icon-globe"></i>
                    {{ __('Localization') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/localization') }}"><i class="nav-icon icon-settings"></i> {{ __('Localization Setting') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-speech"></i> {{ __('Translations') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/languages') }}"><i class="nav-icon  icon-globe-alt"></i> {{ trans('admin.language.title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/countries') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.country.title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/cities') }}"><i class="nav-icon  icon-map"></i> {{ trans('admin.city.title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/areas') }}"><i class="nav-icon icon-location-pin"></i> {{ trans('admin.area.title') }}</a></li>
                </ul>
            </li>
            <li class="nav-item  nav-dropdown  ">
                <a class="nav-link  nav-dropdown-toggle " href="#">
                    <i class="nav-icon icon-bell"></i>
                    {{ __('Notification') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/user-notifications') }}"><i class="nav-icon icon-user"></i> {{ trans('admin.user-notification.title') }}</a></li>
                </ul>
            </li>
            <li class="nav-item  nav-dropdown  ">
                <a class="nav-link  nav-dropdown-toggle " href="#">
                    <i class="nav-icon icon-social-google"></i>
                    {{ __('Services') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/themes') }}"><i class="nav-icon icon-diamond"></i> {{ __('Themes') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/blocks') }}"><i class="nav-icon icon-bulb"></i> {{ trans('admin.block.title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/payment') }}"><i class="nav-icon icon-credit-card"></i> {{ __('Payments') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/email') }}"><i class="nav-icon icon-envelope-letter"></i> {{ __('Email') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/services') }}"><i class="nav-icon icon-share"></i> {{ __('Services') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/backups') }}"><i class="nav-icon icon-cloud-download"></i> {{ __('Backups') }}</a></li>
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/settings') }}"><i class="nav-icon icon-settings"></i> {{ __('Settings') }}</a></li>

            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
