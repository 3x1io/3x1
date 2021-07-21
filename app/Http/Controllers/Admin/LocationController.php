<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request){
        $request->validate([
           'lat' => "required",
           "lang" => "required"
        ]);

        $getUser = AdminUser::find(auth('admin')->user()->id);
        if($getUser){
            $getUser->lat = $request->get('lat');
            $getUser->lang = $request->get('lang');
            $getUser->save();
        }

        return response()->json([
            'message'=>__('Success'),
            'lang'=> $request->get('lang'),
            'lat'=> $request->get('lat'),

        ]);
    }
}
