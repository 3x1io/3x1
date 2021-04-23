<div class="dropdown-menu dropdown-menu-right">
    <div class="dropdown-header text-center bg-gray"><strong>{{ __('You have  ') }} {{sizeof(get_notifications())}} {{__('notifications')}}</strong></div>
{{--    <a href="{{ url('admin/logout') }}" class="dropdown-item"><i class="fa fa-shopping-cart text-success"></i> {{ __('New Notifications Product') }}</a>--}}
    <div id="push-not"></div>
    @if(sizeof(get_notifications()))
        <div id="not-area">
            @foreach(get_notifications() as $item)
                <a href="{{ $item->notification->url }}" class="dropdown-item">
                    <i class="fa {{$item->notification->icon}} text-success"></i> {{ $item->notification->title }}
                </a>
            @endforeach
        </div>
    @else
    <div class="p-5 text-center" id="not-empty">
        <i class="fa fa-bell fa-3x mb-2"></i>
        <p>{{__('Empty!')}}</p>
    </div>
    @endif
    <div id="not-area"></div>
    <div class="dropdown-header text-center bg-dark"><a href="#" class="nav-link text-white"><strong>{{ __('Load More') }}</strong> <i class="fa fa-arrow-circle-right"></i></a> </div>

</div>
