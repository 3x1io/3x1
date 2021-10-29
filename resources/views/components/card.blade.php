<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div>
                <i class="{{$icon}}"></i>
                {{$title}}
            </div>
            <div>
                @if(isset($left))
                    {{ $left }}
                @endif
            </div>
        </div>
    </div>
    <div class="card-body" style="background-color: #fff">
        {{ $slot }}
    </div>
</div>
