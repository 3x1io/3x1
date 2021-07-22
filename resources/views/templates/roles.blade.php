<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <i class="fa fa-lock text-success"></i> {{$label}}
        </div>
        <div class="list-group-flush">
            @foreach($items as $item)
                <div class="list-group-item list-group-item-action d-flex justify-content-between" @click.prevent="pushPermission({{json_encode($item)}})">
                    <div>
                        @if(empty($item->label))
                            {{__('Main Permission')}}
                        @else
                            {{$item->label}}
                        @endif
                    </div>
                    <div>
                        @if(isset($selected) && sizeof($selected))
                            @foreach($selected as $s)
                                @if($s->id === $item->id)
                                    <input id="perm-{{$item->id}}" name="perm-{{$item->id}}" type="radio" @change="pushPermission({{json_encode($item)}})" checked>
                                @endif
                            @endforeach
                        @else
                            <input id="perm-{{$item->id}}" name="perm-{{$item->id}}" type="radio" @change="pushPermission({{json_encode($item)}})">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

