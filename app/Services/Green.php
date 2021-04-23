<?php

namespace App\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Green
{
    public static function create($total, $order_id, $name, $address, $city, $gov, $phone, $info){
        $response = Http::get('https://app.couriermanager.eu/cscourier/API/create_awb?api_key=' . setting('green.api') .
            '&type=package' .
            '&service_type=regular' .
            '&ramburs=' . $total .
            '&ramburs_type=cash' .
            '&content=' . $order_id .
            '&from_name=' . setting('site.name') .
            '&from_email=' . setting('contact.email').
            '&from_phone=' . setting('contact.phone') .
            '&from_address=' . setting('contact.address') .
            '&to_name=' . $name .
            '&to_address=' . $address .
            '&to_city=' . $city .
            '&to_county=' . $gov .
            '&to_phone=' . $phone .
            '&comments=' . $info);

        return (int)$response['data']['no'];
    }

    public static function status($id){
        $response = Http::get('https://app.couriermanager.eu/cscourier/API/get_status?api_key=' . setting('green.api') . '&awbno=' . $id );
        return $response;
    }

    public static function info($id){
        $response = Http::get('https://app.couriermanager.eu/cscourier/API/get_info?api_key=' . setting('green.api') . '&awbno=' . $id );
        return $response;
    }

    public static function cancel($id){
        $response = Http::get('https://app.couriermanager.eu/cscourier/API/cancel?api_key=' . setting('green.api') . '&awbno=' . $id );
        return $response;
    }
}
