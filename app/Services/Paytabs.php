<?php


namespace App\Services;


use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Support\Facades\Http;
use Modules\Accounting\Models\Payment;
use Modules\Order\Models\Country;
use Modules\Products\Models\Product;

class Paytabs
{
    protected static $create = 'https://www.paytabs.com/apiv2/create_pay_page';
    protected static $verify = 'https://www.paytabs.com/apiv2/verify_payment';
    protected static $check = 'https://www.paytabs.com/apiv2/release_capture_preauth';
    protected static $refund = 'https://www.paytabs.com/apiv2/refund_process';
    protected static $check_secret = 'https://www.paytabs.com/apiv2/validate_secret_key';
    protected static $report = 'https://www.paytabs.com/apiv2/transaction_reports';
    protected static $history = 'https://www.paytabs.com/apiv2/transaction_history';

    private static $merchant_email;
    private static $secret_key;

    public function __construct()
    {
        self::$merchant_email = config('services.paytabs.email', setting('paytabs.merchant_email'));
        self::$secret_key = config('services.paytabs.token', setting('paytabs.secret_key'));
    }

    public static function create($order_id, $first_name, $last_name, $phone, $address, $cart, $gov, $city, $shipped, $total, $discount=0){
        $productsTitle = '';
        $productPrice = '';
        $productQnt = '';
        $country = Country::find($gov['country_id']);
        if(!$country){
            $country = setting('admin.country');
        }
        else {
            $country = $country->code;
        }

        foreach ($cart as $key=>$item){
            $product = Product::find($item['product_id']);
            $productsTitle .= $product->name . ' [' . $product->sku . ']';
            $productPrice .= $item['price'] -  $item['discount'];
            $productQnt .= $item['qnt'];

            if($key !== sizeof($cart) -1){
                $productsTitle .= ' | ';
                $productPrice .= ' | ';
                $productQnt .= ' | ';
            }
        }
        $response = Http::asForm()->post(self::$create,  [
            //Vendor Settings
            "merchant_email" => self::$merchant_email,
            "secret_key" => self::$secret_key,
            //"site_url" => url('/'),
            "site_url" => 'unlmall.com',
            "return_url" => url('callback/paytabs'),
            "title" => setting('site.name'),

            //Customer Data
            "cc_first_name" => $first_name,
            "cc_last_name" => $last_name,
            "cc_phone_number" =>$phone,

            //Vendor Data
            "phone_number" => setting('site.phone'),
            "email" => setting('site.email'),

            //Products
            "products_per_title" =>$productsTitle,
            "unit_price" => $productPrice,
            "quantity" => $productQnt,

            //Shipping
            "other_charges" => $shipped,

            "amount" => $total,
            "discount" => $discount,
            "currency" => setting('admin.$'),

            //Order
            "reference_no" => $order_id,

            "ip_customer" => $_SERVER['REMOTE_ADDR'],
            "ip_merchant" => isset($_SERVER['SERVER_ADDR'])? $_SERVER['SERVER_ADDR'] : '::1',

            //Address
            "billing_address" => $address,
            "state" => $gov['name'],
            "city" => $city['name'],
            "postal_code" => "12345",
            "country" => $country,

            //Shipping
            "shipping_first_name" => $first_name,
            "shipping_last_name" => $last_name,
            "address_shipping" =>$address,
            "city_shipping" => $gov['name'],
            "state_shipping" => $city['name'],
            "postal_code_shipping" => "12345",
            "country_shipping" => $country,

            //System
            "msg_lang" => "Arabic",
            "cms_with_version" => "PHP",
            "payment_type" => "creditcard",
        ]);

        return [
            "url" => $response['payment_url'],
            "id" => $response['p_id'],
        ];
    }
    public static function verify($payment_reference){
        $response = Http::asForm()->post(self::$verify,  [
            //Vendor Settings
            "merchant_email" => self::$merchant_email,
            "secret_key" => self::$secret_key,
            "payment_reference" => $payment_reference
        ]);

        $message = '';
        $success = false;
        switch ($response['response_code']){
            case  '4001':
                $message =   __('Variable not found');
                break;
            case  '4002':
                $message =   __('Invalid Credentials');
                break;
            case  '0404':
                $message =   __('You don’t have permissions');
                break;
            case  '400':
                $message =   __('There are no transactions available.');
                break;
            case '100':
                $message =   __('Payment is completed');
                $success = true;
                break;
            case  '481' | '482':
                $message =   __('This transaction is under review');
                break;
            case  '1000':
                $message =   __('Invoice is not paid');
                break;
            case  '1003':
                $message =   __('Invoice expired');
                break;
            case  '1004':
                $message =   __('Invoice is pending payment');
                break;
            case  '1100':
                $message =   __('Invoice is cancelled');
                break;
            case  '110':
                $message =   __('Transaction not completed');
                break;
            case  '111':
                $message =   __('The payment is authorized successfully');
                break;
            case  '112':
                $message =   __('The payment is partially captured');
                break;
            case  '113':
                $message =   __('The payment is fully captured');
                break;
            case  '114':
                $message =   __('Authorization expired');
                break;
            case  '115':
                $message =   __('The payment is partially captured remaining expired');
                break;
            case  '116':
                $message =   __('The payment is fully reversed');
                break;
            case  '6' || '11':
                $message =   __('The payment is completed successfully');
                $success = true;
                break;
            case  '12':
                $message =   __('The payment is refunded');
                break;
        }

        return [
            "order_id" => $response['reference_no'],
            "status" => $response['response_code'],
            "success" => $success,
            "message" => $message
        ];
    }
    public static function checkSecret(){
        $response = Http::asForm()->post(self::$check_secret,  [
            //Vendor Settings
            "merchant_email" => setting('paytabs.merchant_email'),
            "secret_key" => setting('paytabs.secret_key'),
        ]);

        if($response['response_code'] == '4000'){
            return true;
        }
        else {
            return false;
        }
    }

}
