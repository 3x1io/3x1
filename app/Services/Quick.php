<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;
use Modules\Products\Models\Product;

class Quick
{
    protected static $login = 'https://c.quick.sa.com/API/Login/GetAccessToken';
    protected static $refresh = 'https://c.quick.sa.com/API/Login/RefreshToken';
    protected static $create = 'https://c.quick.sa.com/API/V3/Store/Shipment';
    protected static $consistent = 'https://c.quick.sa.com/API/V3/GetConsistentData';
    protected static $cost = 'https://c.quick.sa.com/API/V3/Store/Shipment/GetShippingCost';
    protected static $get = 'https://c.quick.sa.com/API/V3/Store/Shipment/';
    protected static $pdf = 'https://c.quick.sa.com/API/V3/Store/Shipment/ShippingLabelPDF/';
    protected static $label = 'https://c.quick.sa.com/API/V3/Store/Shipment/ShippingLabelInfo/';
    protected static $status = 'https://c.quick.sa.com/API/V3/Store/Shipment/Track/';
    protected static $city = 'https://c.quick.sa.com/API/V3/GetCityIdByName';
    protected static $cancel = 'https://c.quick.sa.com/API/V3/Shipment/';
    protected static $url = 'https://c.quick.sa.com/API/V3/Store/Shipment/ShippingLabel/PDF/Url/';

    private static $token = '';
    private static $info;

    public static function login(){
        $response = Http::asJson()->post(self::$login,  [
            "UserName" => setting('quick.email'),
            "Password" => setting('quick.password'),
        ]);

        if(empty(setting('quick.api_key'))){
            setting_update('quick.api_key', $response['resultData']['access_token']);
        }

        self::$token = 'Bearer ' . setting('quick.api_key');

        return self::$token;
    }

    public static function city($name){
        if(empty(self::$token)){
            self::login();
        }
        $response = Http::withHeaders([
            'Authorization' => self::$token,
        ])->asJson()->post(self::$city,  [
            "CityName" => $name,
        ]);

        return $response['resultData'];
    }

    public static function cost($cityId, $city, $payment, $services){
        if(empty(self::$token)){
            self::login();
        }
        $response = Http::withHeaders([
            'Authorization' => self::$token,
        ])->asJson()->post(self::$cost,  [
            "CityId" => $cityId,
            "CityAsString" => $city,
            "PaymentMethodId" => $payment,
            "AddedServicesIds" => $services,
        ]);

        return $response['resultData']['totalCost'];
    }

    public static function contents(){
        if(empty(self::$token)){
            self::login();
        }
        $response = Http::withHeaders([
            'Authorization' => self::$token,
        ])->asJson()->get(self::$consistent);

        self::$info = $response['resultData'];

        return self::$info;
    }

    public static function create($name, $phone,$address, $city, $cart, $order, $payment, $total, $type, $services){
        if(empty(self::$token)){
            self::login();
        }
      $city = self::city($city);
      $items = $cart;
//      foreach ($cart as $item){
//          $product = Product::find($item['product_id']);
//          array_push($items, [
//              "SKU"=>$product->sku, "Quantity"=> $item['qnt']
//          ]);
//      }
      $order =  [
            "SandboxMode"=> false,
            "CustomerName"=> $name,
            "CustomerPhoneNumber"=> $phone,
            "PreferredReceiptTime"=> $order->created_at,
            "PreferredDeliveryTime"=> $order->created_at,
            "NotesFromStore"=> $order->note,
            "PaymentMethodId"=> $payment, // prepaid
            "ShipmentContentValueSAR"=> $total,
            "ShipmentContentTypeId"=> $type, //Breakable Item
            "AddedServicesIds"=> $services,
            "CustomerLocation"=> [
                "Desciption"=> $address,
                "Longitude"=> "",
                "Latitude"=> "",
                "GoogleMapsFullLink"=> "",
                "CountryId"=> $city['countryId'],
                "CityAsString"=> $city['name']
            ],
            "ExternalStoreShipmentIdRef"=> $order->id,
            "API_Call_Source"=> "Laravel",
            "Currency"=> setting('admin.$'),
            "UseQuickInventory"=>  [
                "Items"=>  []
            ]
       ];
      $response = Http::withHeaders([
          'Authorization' => self::$token,
      ])->asJson()->post(self::$create, $order);

      if($response['isSuccess']){
          return $response['resultData'];
      }
      else {
          return $response['messageAr'];
      }
    }

    public static function info($id){
        if(empty(self::$token)){
            self::login();
        }
        $response = Http::withHeaders([
            'Authorization' => self::$token,
        ])->asJson()->get(self::$get . $id);

        return $response['resultData'];
    }

    public static function pdf($id){
        if(empty(self::$token)){
            self::login();
        }
        $response = Http::withHeaders([
            'Authorization' => self::$token,
        ])->asJson()->get(self::$pdf . $id);

        return $response['resultData'];
    }

    public static function status($id){
        if(empty(self::$token)){
            self::login();
        }
        $response = Http::withHeaders([
            'Authorization' => self::$token,
        ])->asJson()->post(self::$status,  [
            "ShipmentsIds" => [$id],
        ]);

        return $response['resultData'][0]['shipmentStatusList']['nameAr'];
    }

    public static function cancel($id){
        if(empty(self::$token)){
            self::login();
        }
        $response = Http::withHeaders([
            'Authorization' => self::$token,
        ])->asJson()->delete(self::$cancel . $id);

        return $response['resultData'];
    }

}
