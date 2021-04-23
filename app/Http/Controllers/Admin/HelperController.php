<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Notification\Mail\SendMailable;
use App\Services\Paytabs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class HelperController extends Controller
{
    public function setting(){
        return view('admin.setting.settings');
    }

    public function settings(Request $request){

        setting_update('site.name', $request->site_name);
        setting_update('site.keywords', $request->site_keywords);
        setting_update('site.description', $request->site_description);

        $file = $request->file('site_logo');
        if($file){
            $imageName = time().'.'.$request->site_logo->extension();
            $request->site_logo->move(public_path('images/settings'), $imageName);
            setting_update('site.logo', '/images/settings/'. $imageName);
        }

        return back();
    }

    public function backups(){
        $getBackups = File::allFiles(storage_path('app/Laravel'));
        return view('admin.setting.backups', [
            'backups' => $getBackups
        ]);
    }

    public function saveBackups(Request $request){
        if($request->has('path')){
            $getFile = File::exists($request->get('path'));
            if($getFile){
                return response()->file($request->get('path'));
            }

        }
        else {
            exec('cd ' . base_path() . ' && /opt/homebrew/Cellar/php@7.4/7.4.15/bin/php artisan backup:run', $output, $code);
            toast(__('Backup Run!'),'success');
            return back();
        }
    }



    public function payment(){
        $check = Paytabs::checkSecret();
        return view('admin.setting.payment', [
            'check' => $check
        ]);
    }

    public function savePayment(Request $request){
        setting_update('paytabs.merchant_email', $request->get('paytabs_merchant_email'));
        setting_update('paytabs.secret_key', $request->get('paytabs_secret_key'));

        toast(__('Payments Updates!'),'success');
        return back();
    }

    public function email(){
        $check = true;

        try {
            Mail::to(auth('admin')->user()->email)->send(new SendMailable());
        }
        catch (\Exception $exception){
            $check = false;
        }

        return view('admin.setting.email', [
            'check' => $check
        ]);
    }

    public function saveEmail(Request $request){
        setting_update('email.host', $request->get('email_host'));
        setting_update('email.port', $request->get('email_port'));
        setting_update('email.username', $request->get('email_username'));
        setting_update('email.password', $request->get('email_password'));
        setting_update('email.encryption', $request->get('email_encryption'));
        setting_update('email.from', $request->get('email_from'));
        setting_update('email.from.name', $request->get('email_from_name'));

        toast(__('Email Updates!'),'success');
        return back();
    }

    public function services(){
        return view('admin.setting.services');
    }

    public function pusher(){
        return view('admin.setting.services.pusher');
    }

    public function savePusher(Request $request){
        $request->validate([
           'pusher_key' => 'required',
           'pusher_secret' => 'required',
           'pusher_app_id' => 'required',
           'pusher_cluster' => 'required',
        ]);
        setting_update('pusher.key', $request->get('pusher_key'));
        setting_update('pusher.secret', $request->get('pusher_secret'));
        setting_update('pusher.app_id', $request->get('pusher_app_id'));
        setting_update('pusher.cluster', $request->get('pusher_cluster'));

        toast(__('Pusher Services Linked!'),'success');
        return back();
    }

    public function messagebird(){
        return view('admin.setting.services.messagebird');
    }

    public function saveMessagebird(Request $request){
        $request->validate([
            'messagebird_access_key' => 'required',
            'messagebird_originator' => 'required',
            'messagebird_recipients' => 'required',
        ]);

        setting_update('messagebird.access_key', $request->get('messagebird_access_key'));
        setting_update('messagebird.originator', $request->get('messagebird_originator'));
        setting_update('messagebird.recipients', $request->get('messagebird_recipients'));

        toast(__('Messagebird Services Linked!'),'success');
        return back();
    }

    public function collectorOLX(Request $request){
        $data = \App\Services\Olx::home('https://olx.com.eg');

        return view('admin.setting.collector', [
            "data" => $data,
            "type" => "olx"
        ]);
    }

    public function collectorHaraj(Request $request){
        if($request->has('tag')){
            $data = \App\Services\Haraj::home('https://haraj.com.sa/tags/' . $request->get('tag'));
        }
        else {
            $data = \App\Services\Haraj::home('https://haraj.com.sa');
        }

        return view('admin.setting.collector', [
            "data" => $data,
            "type" => "haraj"
        ]);
    }


}
