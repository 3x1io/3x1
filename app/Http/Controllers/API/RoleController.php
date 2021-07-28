<?php

namespace App\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        if(user_can('roles.index')){
            $role = Role::paginate(10);
            foreach ($role as $item){
                $item->load('permissions');
            }

            return response()->json([
                'success' => true,
                'message' => __('Roles Load Success'),
                'data' => $role
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
        if(user_can('roles.create')){
            $rules = [
                'guard' => 'required|string',
                'name' => 'required|string',
                'key' => 'required|string|unique:roles',
                'permissions' => 'required|array',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return  response()->json([
                    "success" => false,
                    "message" =>  $validator->messages()
                ]);
            }
            else {
                $role = Role::create($request->all());
                $role->permissions()->attach($request->get('permissions'));
                $role->load('permissions');
                return  response()->json([
                    'success'=> true,
                    'message' => __('Role Added Success'),
                    'data' => [
                        'role' => $role
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

    public function show($role)
    {
        if(user_can('roles.show')){
            $role = Role::find($role);
            if($role){
                $role->load('permissions');
                return response()->json([
                    'success' => true,
                    'message' => __('Role Loaded Success'),
                    'data' => [
                        'role' => $role
                    ]
                ]);
            }
            else {
                return  response()->json([
                    'success'=> false,
                    'message' => __('Role Not Found'),
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

    public function update(Request $request, $role)
    {
        if(user_can('roles.update')){
            $role = Role::find($role);
            if($role){
                $rules = [
                    'guard' => 'sometimes|string',
                    'name' => 'sometimes|string',
                    'key' => 'sometimes|string|unique:permissions,key,'.$role->id,
                    'permissions' => 'sometimes|array',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return  response()->json([
                        "success" => false,
                        "message" =>  $validator->messages()
                    ], 401);
                }
                else {
                    $role->update($request->all());
                    if($request->has('permissions')){
                        $role->permissions()->sync($request->get('permissions'));
                    }
                    $role->load('permissions');

                    return  response()->json([
                        'success'=> true,
                        'message' => __('Role Updated Success'),
                        'data' => [
                            'role' => $role
                        ]
                    ]);
                }
            }
            else {
                return  response()->json([
                    'success'=> false,
                    'message' => __('Role Not Found'),
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

    public function destroy($role)
    {
        if(user_can('roles.delete')){
            $role = Role::find($role);
            if($role){
                $role->permissions()->sync([]);
                $role->delete();

                return  response()->json([
                    'success'=> true,
                    'message' => __('Role Deleted Success'),
                ]);
            }
            else {
                return  response()->json([
                    'success'=> false,
                    'message' => __('Role Not Found'),
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
