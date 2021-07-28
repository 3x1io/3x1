<label class="switch switch-3d @if(sizeof($data['options'])) switch-{{$data['options']['bg']}} @else switch-primary  @endif" >
    <input type="checkbox" class="switch-input" v-model="collection[index].{{$data['name']}}" @change="toggleSwitch(item.resource_url, '{{$data['name']}}', collection[index])">
    <span class="switch-slider"></span>
</label>