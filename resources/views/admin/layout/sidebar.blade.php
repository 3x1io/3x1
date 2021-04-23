<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">

            <li class="nav-item"><a class="nav-link" href="{{ url('admin') }}"><i class="nav-icon icon-home"></i> {{ __('Dashboard') }}</a></li>
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>

           {{-- Do not delete me :) I'm used for auto-generation menu items --}}
            @php $modules = \Module::all(); @endphp
            @foreach($modules as $item)
                @if(View::exists($item->getLowerName() . '::sidebar'))
                    @include($item->getLowerName().'::sidebar')
                @endif
            @endforeach
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>

            <li class="nav-item  nav-dropdown  ">
                <a class="nav-link  nav-dropdown-toggle " href="#">
                    <i class="nav-icon icon-directions"></i>
                    {{ __('Services') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/payment') }}"><i class="nav-icon icon-credit-card"></i> {{ __('Payments') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/email') }}"><i class="nav-icon icon-envelope"></i> {{ __('Email') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/services') }}"><i class="nav-icon icon-directions"></i> {{ __('Services') }}</a></li>
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/settings') }}"><i class="nav-icon icon-settings"></i> {{ __('Settings') }}</a></li>

            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
