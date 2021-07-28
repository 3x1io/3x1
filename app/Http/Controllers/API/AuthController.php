<?php

namespace App\Http\Controllers\API;

use App\Mail\EmailCode;
use App\Mail\EmailReset;
use App\Mail\EmailWelcome;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use MessageBird\Client;
use MessageBird\Objects\Message;

class AuthController extends Controller
{

    public function register(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'username' => 'nullable|string|max:120|unique:users',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $checkEx = User::where('email', $request->get('email'))->orWhere('phone', $request->get('phone'))->first();
            if($checkEx->email_verified_at){
                return  response()->json([
                    "success" => false,
                    "message" =>  $validator->messages()
                ]);
            }
            else {
                Mail::to($checkEx)->send(new EmailCode($checkEx->code));
                if(!empty($request->get('phone'))){
                    send_sms('3U4hIoTFq6FZddMbJ9gZWFRw2','+201069706892',  $checkEx->phone, 'Your Code IS: '. $checkEx->code);;
                }

                return  response()->json([
                    "success" => false,
                    'message' => __('your activated link has been send to your email')
                ]);
            }

        }
        else{
            $user = User::create([
                'name' => $request->get('name'),
                'phone' => $request->get('phone'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            if($user){
                $token = $user->createToken('auth_token')->plainTextToken;

                $user->api_key = $token;
                $user->secret_key = Str::uuid();
                $user->code = substr(number_format(time() * rand(),0,'',''),0,6);
                $user->save();

                Mail::to($user)->send(new EmailCode($user->code));
                if(!empty($user->phone)){
                    send_sms('3U4hIoTFq6FZddMbJ9gZWFRw2','+201069706892',  $user->phone, 'Your Code IS: '. $user->code);
                }

                return response()->json([
                    'success' => true,
                    'message' => __('your activated link has been send to your email')
                ]);
            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => __('something going error!')
                ], 401);
            }


        }
    }

    public function resend(Request $request){
        $rules = [
            'email' => 'nullable|string|email',
            'phone' => 'nullable|string'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return  response()->json([
                "success" => false,
                "message" =>  $validator->messages()
            ]);
        }
        else {
            $checkEx = User::where('email', $request->get('email'))->orWhere('phone', $request->get('phone'))->first();

            if($checkEx){
                $checkEx->code = substr(number_format(time() * rand(),0,'',''),0,6);
                $checkEx->save();

                if(!empty($request->get('email'))){
                    Mail::to($checkEx)->send(new EmailCode($checkEx->code));
                }

                if(!empty($request->get('phone'))){
                    send_sms('3U4hIoTFq6FZddMbJ9gZWFRw2','+201069706892',  $checkEx->phone, 'Your Code IS: '. $checkEx->code);
                }

                return response()->json([
                    'success' => true,
                    'message' => __('your activated link has been send to your email')
                ]);
            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => __('sorry user not exits!')
                ], 401);
            }
        }

    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return  response()->json([
                "success" => false,
                "message" =>  $validator->messages()
            ]);
        }
        else {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'success' => false,
                    'message' => __('Invalid login details')
                ], 401);
            }
            else {
                $user = User::where('email', $request['email'])->firstOrFail();

                if($user->email_verified_at && !$user->code){
                    if(!$user->api_key){
                        $token = $user->createToken('auth_token')->plainTextToken;
                        $user->api_key = $token;
                        $user->secret_key = Str::uuid();
                        $user->save();
                    }

                    return response()->json([
                        'success' => true,
                        'message' => __('Login Success'),
                        'data' => [
                            'login' => true,
                            'api_key' => $user->api_key,
                            'secret_key' => $user->secret_key,
                            'token_type' => 'Bearer',
                            'user' => [
                                "name" => $user->name,
                                "email" => $user->email,
                                "phone" => $user->phone,
                                "username" => $user->username,
                            ]
                        ]
                    ]);
                }
                else {
                    return response()->json([
                        'success' => false,
                        'message' => __('Sorry! your account not active please check your email or phone to get activated link')
                    ], 403);
                }

            }
        }
    }

    public function user(Request $request){
        $rules = [
            'secret_key' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return  response()->json([
                "success" => false,
                "message" =>  $validator->messages()
            ]);
        }
        else {
            if(Auth::user()){
                if($request->user()->secret_key == $request->get('secret_key')){
                    return response()->json([
                        'success' => true,
                        'message' => __('User Data Has Been Loaded Success'),
                        'data' => [
                            'api_key' => $request->user()->api_key,
                            'secret_key' => $request->user()->secret_key,
                            'token_type' => 'Bearer',
                            'user' => [
                                "id" => $request->user()->id,
                                "name" => $request->user()->name,
                                "email" => $request->user()->email,
                                "phone" => $request->user()->phone,
                                "username" => $request->user()->username,
                            ]
                        ]
                    ]);
                }
                else {
                    return response()->json([
                        'success' => false,
                        'message' => __('Please Input a Valid Secret Key')
                    ], 401);
                }

            }
            else {
                return response()->json([
                    'success' => false,
                    'user' => __('Sorry Not Auth User!')
                ], 403);
            }

        }

    }

    public function update(Request $request){
        $user = User::find(auth()->user()->id);
        if($user){
            $rules = [
                'secret_key' => 'required|string',
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,'.$user->id,
                'phone' => 'sometimes|string|max:20|unique:users,phone,'.$user->id,
                'username' => 'sometimes|string|max:120|unique:users,username,'.$user->id,
                'roles' => 'sometimes|array',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return  response()->json([
                    "success" => false,
                    "message" =>  $validator->messages()
                ]);
            }
            else {
                if($request->has('name')){
                    $user->name = $request->get('name');
                }
                if($request->has('email')){
                    $user->email = $request->get('email');
                }
                if($request->has('phone')){
                    $user->phone = $request->get('phone');
                }
                if($request->has('username')){
                    $user->username = $request->get('username');
                }
                if($request->has('roles')){
                    $user->roles()->sync($request->get('roles'));
                }

                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => __('Profile Has Been Update Success'),
                    'data' => [
                        'user' => [
                            "id" => $user->id,
                            "name" => $user->name,
                            "email" => $user->email,
                            "phone" => $user->phone,
                            "username" => $user->username,
                            "roles" => $user->load('roles')
                        ]
                    ]
                ]);
            }
        }
        else {
            return  response()->json([
                "success" => false,
                "message" => __('Sorry You Are Not User')
            ]);
        }

    }

    public function password(Request $request){
        $user = User::find(auth()->user()->id);
        if($user){
            $rules = [
                'secret_key' => 'required|string',
                'password' => 'required|confirmed|string|min:8',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return  response()->json([
                    "success" => false,
                    "message" =>  $validator->messages()
                ]);
            }
            else {
                $user->password = bcrypt($request->get('password'));
                $user->save();

                return  response()->json([
                    "success" => true,
                    "message" => __('User Password Has Been Update Success')
                ]);

            }
        }
        else {
            return  response()->json([
                "success" => false,
                "message" => __('Sorry You Are Not User')
            ]);
        }
    }

    public function verified(Request $request){
        $rules = [
            "email" => "required|email|string",
            "code" => "required|digits:6|integer"
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return  response()->json([
                "success" => false,
                "message" =>  $validator->messages()
            ]);
        }
        else {
            $user = User::where("email", $request->get('email'))->first();
            if($user){
                if (!empty($user->code) && $user->code === $request->get('code')) {
                    $user->email_verified_at = Carbon::now();
                    $user->activated = true;
                    $user->code = null;
                    $user->save();
                    Mail::to($user)->send(new EmailWelcome());

                    return response()->json([
                        'success' => true,
                        'message' => __('your email has been activated, you can login')
                    ]);
                }
                else {
                    return response()->json([
                        'success' => false,
                        'message' => __('sorry this code is not valid or expired')
                    ], 401);
                }
            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => __('no user exist with this email')
                ], 401);
            }


        }


    }

    public function forgot(Request $request) {
        $rules = [
            'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return  response()->json([
                "success" => false,
                "message" =>  $validator->messages()
            ]);
        }
        else {
            $checkIfEx = User::where('email', $request->get('email'))->first();
            if($checkIfEx){

                $checkIfEx->code = substr(number_format(time() * rand(),0,'',''),0,6);
                $checkIfEx->save();

                Mail::to($checkIfEx)->send(new EmailCode($checkIfEx->code));

                return response()->json([
                    'success' => true,
                    'message' => __('Reset password link sent on your email id.')
                ]);
            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => __('This Email Not Found In Database')
                ], 400);
            }

        }
    }

    public function reset(Request $request) {
        $rules = [
            'email' => 'required|email',
            'code' => 'required|integer|digits:6',
            'password' => 'required|string|confirmed'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return  response()->json([
                "success" => false,
                "message" =>  $validator->messages()
            ]);
        }
        else {
            $isExUser = User::where('email', $request->get('email'))->first();
            if($isExUser){
                if($isExUser->code === $request->get('code')){
                    $isExUser->password = Hash::make($request->get('password'));
                    $isExUser->save();

                    Mail::to($isExUser)->send(new EmailReset());

                    return response()->json([
                        "success"=> true,
                        "message" => __("Password has been successfully changed")
                    ]);
                }
                else {
                    return response()->json([
                        'success' => false,
                        'message' => __('sorry this code is not valid or expired')
                    ], 401);
                }
            }
            else {
                return response()->json([
                    "success" => false,
                    "message" => __("User Not Found!")
                ], 400);
            }

        }
    }
}
