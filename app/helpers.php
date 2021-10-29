<?php

//Setting Helpers
use App\Models\Block;
use MessageBird\Client;
use MessageBird\Objects\Message;

if(!function_exists('setting')){
    function setting($key){
        $setting = \App\Models\Setting::where('key', $key)->first();
        if($setting){
            return $setting->value;
        }
        else {
            return false;
        }
    }
}
if(!function_exists('setting_show')){
    function setting_show($key, $label, $type, $option=[], $id=""){
        if(empty($id)){
            $id = $key;
        }
        $setting = \App\Models\Setting::where('key', $key)->first();
        if($setting){
            switch($type){
                case "text":
                case "number":
                case "password":
                case "email":
                case "rang":
                    return '<div class="form-group"><label for="'.$key.'">'.$label.'</label><input class="form-control" type="'.$type.'" name="'.$key.'" id="'.$id.'" value="'.$setting->value.'"  placeholder="'.$label.'" required></div>';
                    break;
                case "textarea":
                    return '<div class="form-group"><label for="'.$key.'">'.$label.'</label><textarea class="form-control" name="'.$key.'" id="'.$id.'"  placeholder="'.$label.'" required>'.$setting->value.'</textarea></div>';
                    break;
                case "editor":
                    return '<div class="form-group"><label for="'.$key.'">'.$label.'</label><wysiwyg name="'.$key.'" id="'.$id.'" value="'.$setting->value.'" :config="mediaWysiwygConfig"></wysiwyg></div>';
                    break;
                case "file":
                    return '<div class="custom-file"><input class="custom-file-input" type="'.$type.'" name="'.$key.'" id="'.$id.'"  required><label class="custom-file-label"  for="'.$key.'">'.$label.'</label></div>';
                    break;
                case "image":
                    return '<label for="'.$key.'">'.$label.'</label><br><img class="m-2" style="border: 1px solid #b9c8de" src="'.url($setting->value).'" width="10%" alt="'.$label.'"><div class="custom-file mb-3"><input class="custom-file-input" type="file" name="'.$key.'" id="'.$key.'" ><label class="custom-file-label"  for="'.$key.'">'.$label.'</label></div>';
                    break;
                case "select":
                    $setOptions = '';
                    foreach ($option as $item){
                        if(is_array($item)){
                            if($item['id'] == $setting->value){
                                $setOptions .= '<option value="'.$item['id'].'" selected>'.$item['name'].'</option>';
                            }
                            else {
                                $setOptions .= '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                            }
                        }
                        else {
                            if($item->id == $setting->value){
                                $setOptions .= '<option value="'.$item->id.'" selected>'.$item->{$id}.'</option>';
                            }
                            else {
                                $setOptions .= '<option value="'.$item->id.'">'.$item->{$id}.'</option>';
                            }
                        }


                    }
                    return '<div class="form-group"><label for="'.$key.'">'.$label.'</label><select class="form-control" name="'.$key.'" id="'.$id.'" required>'.$setOptions.'</select></div>';
                    break;

            }
        }
        else {
            return false;
        }

    }
}
if(!function_exists('setting_update')){
    function setting_update($key, $value){
        $setting = \App\Models\Setting::where('key', $key)->first();
        if($setting){
            $setting->value = $value;
            $setting->save();
            return true;
        }
        else {
            return false;
        }
    }
}
//Themes Functions
if(!function_exists('theme_assets')){
    function theme_assets($path){
        $theme_name = str_replace('themes.', '', setting('themes.path'));
        return url('themes/'.$theme_name.'/'.$path);
    }
}
if(!function_exists('theme_namespace')){
    function theme_namespace(){
        $theme_name = str_replace('themes.', '', setting('themes.path'));
        return 'Themes\\' . $theme_name . '\\controllers';
    }
}
if(!function_exists('show_menu')){
    function show_menu($key){
        $menu = \App\Models\Setting::where('key', $key)->first();
        if($menu){
            return json_decode($menu->value);
        }
        else {
            return false;
        }

    }
}
if(!function_exists('dollar')){
    function dollar($total){
        $getDollar = setting('$');
        if($getDollar){
            return "<b>". number_format($total, 2) . "</b><small>$getDollar</small>";
        }
        else {
            return false;
        }
    }
}
//Notifications Helpers
if(!function_exists('send_sms')){
    function send_sms($api, $from, $to, $message){
        $MessageBird = new Client($api);
        $sms = new Message();
        $sms->originator = $from;
        $sms->recipients = array($to);
        $sms->body = $message;
        $sms->type = 'sms';

        $MessageBird->messages->create($sms);
    }
}
if(!function_exists('pusher')){
    function pusher($title, $url, $description='',$type='push', $icon="fa fa-bell" ){
        $options = array(
            'cluster' => 'eu',
            'encrypted' => true
        );

        //Remember to set your credentials below.
        $pusher = new Pusher(
            setting('pusher.key'),
            setting('pusher.secret'),
            setting('pusher.app_id'), $options
        );


        //Send a message to notify channel with an event name of notify-event
        $pusher->trigger('push-notifications', 'push-notifications', [
            'title' => $title,
            'url' => $url,
            'description' => $description,
            'type' => $type,
            'icon' => $icon
        ]);
    }
}
if(!function_exists('get_notifications')){
    function get_notifications(){
        $get = \App\Models\UserHasNotification::where('user_id', auth('admin')->user()->id)->where('read', 0)->get();

        foreach ($get as $item){
            $item->notification = \App\Models\UserNotification::find($item->notification_id);
        }

        return $get;
    }
}

if(!function_exists('get_permissions')){
    function get_permissions($key, $label, $selected=[]){
        $get = \App\Models\Permission::where('name', 'LIKE', '%' .$key. '%')->get();
        foreach ($get as $item){
            $item->label = ucfirst(str_replace('.', '', str_replace('admin.'.$key, '', $item->name)));
        }

        return view('templates.roles', [
            "label" => $label,
            "items" => $get,
            "selected" => $selected
        ])->render();
    }
}
if(!function_exists('user_can')){
    function user_can($permission){
        if(auth()->user()){
            $roles = auth()->user()->roles;
            if($roles->count()){
                foreach ($roles as $item){
                    $getRole = \App\Models\Role::find($item->id);
                    if($getRole){
                        $permissions = $getRole->permissions;
                        foreach ($permissions as $perm){
                            if($perm->key === $permission){
                                return true;
                            }
                        }
                    }
                    else {
                        return false;
                    }

                }

                return false;
            }
            else {
                return  false;
            }

        }
        else {
            return  false;
        }

    }
}

//Blocks Fn
if(!function_exists('input')){
    function input($type, $name, $label,$validation=false,$options=[],$custom=false,$placeholder=false, $id=false, $class='form-control', $ref=false, $model=false){
        return block('form.' . $type, [
            'name' => $name,
            'type' => $type,
            'id' => $id,
            'label' => $label,
            'model' => $model,
            'placeholder' => $placeholder,
            'validation' => $validation,
            'ref'=> $ref,
            'custom' => $custom,
            'class' => $class,
            'options' => $options
        ]);
    }
}
if(!function_exists('vue_form')){
    function vue_form($action,$redirect,$form, $method='post', $data='{}', $items='{}'){
        return view('components.forms.start_form', [
            'action' => $action,
            'redirect' => $redirect,
            'form' => $form,
            'method' => $method,
            'data' => $data,
            'items' => $items
        ])->render();
    }
}
if(!function_exists('end_vue_form')){
    function end_vue_form(){
        return view('components.forms.end_form')->render();
    }
}
if(!function_exists('vue_form_js')){
    function vue_form_js(){
        return view('components.forms.js')->render();
    }
}
if(!function_exists('list_fn')){
    function list_fn($type, $name, $options=[]){
        return block('list.' . $type, [
            "type" => $type,
            "name" => $name,
            "options"=> $options
        ]);
    }
}
if(!function_exists('block')){
    function block($key, $data=[]) {
        $block = \App\Models\Block::where('key', $key)->first();
        $check = \Illuminate\Support\Facades\File::exists(resource_path('views/components/placeholder.blade.php'));

        if($block){
            if($check){
                \Illuminate\Support\Facades\File::put(resource_path('views/components/placeholder.blade.php'),$block->html);
                return view('components.placeholder', [
                    "data" => $data
                ])->render();
            }
            else {
                return "";
            }
        }
        else {
            return "";
        }
    }
}
