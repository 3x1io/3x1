<div class="card text-center">
    <div class="card-header">
        <a href="{{$info}}" target="_blank" class="card-title">{{$name}}</a>
    </div>
    <div class="card-body">
        <img src="{{$image}}" style="display: block; margin-left: auto; margin-right: auto; height: 80px" />
        @if($comming)
            <span class="btn btn-warning text-dark btn-sm btn-block mt-3"> Coming Soon!</span>
        @else
            <a href="{{$url}}" class="btn btn-primary btn-sm btn-block mt-3"><i class="fa fa-link"></i> Link</a>
        @endif
    </div>
</div>
