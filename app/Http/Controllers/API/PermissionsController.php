<?php

namespace App\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Permission;

class PermissionsController extends Controller
{

    public function index()
    {
        if(user_can('permissions.index')){
            $permissions = Permission::paginate(10);

            return response()->json([
                'success' => true,
                'message' => __('Permissions Load Success'),
                'data' => $permissions
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => __('UnAuth Action')
            ], 403);
        }

    }

    public function store(Request $request)
    {
        if(user_can('permissions.store')){
            $rules = [
                'guard' => 'required|string',
                'group' => 'required|string',
                'key' => 'required|string|unique:permissions',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return  response()->json([
                    "success" => false,
                    "message" =>  $validator->messages()
                ]);
            }
            else {
                $permission = Permission::create($request->all());

                return  response()->json([
                    'success'=> true,
                    'message' => __('Permission Added Success'),
                    'data' => [
                        'permission' => $permission
                    ]
                ]);
            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => __('UnAuth Action')
            ], 403);
        }

    }

    public function show($permission)
    {
        if(user_can('permissions.show')){
            $permission = Permission::find($permission);
            return response()->json([
                'success' => true,
                'message' => __('Permission Loaded Success'),
                'data' => [
                    'permission' => $permission
                ]
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => __('UnAuth Action')
            ], 403);
        }

    }

    public function update(Request $request, $permission)
    {
        if(user_can('permissions.update')){
            $permission = Permission::find($permission);
            if($permission){
                $rules = [
                    'guard' => 'sometimes|string',
                    'group' => 'sometimes|string',
                    'key' => 'sometimes|string|unique:permissions,key,'.$permission->id,
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return  response()->json([
                        "success" => false,
                        "message" =>  $validator->messages()
                    ], 401);
                }
                else {
                    $permission->update($request->all());

                    return  response()->json([
                        'success'=> true,
                        'message' => __('Permission Updated Success'),
                        'data' => [
                            'permission' => $permission
                        ]
                    ]);
                }
            }
            else {
                return  response()->json([
                    'success'=> false,
                    'message' => __('Permission Not Found'),
                ]);
            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => __('UnAuth Action')
            ], 403);
        }

    }


    public function destroy($permission)
    {
        if(user_can('permissions.delete')){
            $permission = Permission::find($permission);
            if($permission){
                $permission->roles()->sync([]);
                $permission->delete();

                return  response()->json([
                    'success'=> true,
                    'message' => __('Permission Deleted Success'),
                ]);
            }
            else {
                return  response()->json([
                    'success'=> false,
                    'message' => __('Permission Not Found'),
                ], 404);
            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => __('UnAuth Action')
            ], 403);
        }
    }
}
