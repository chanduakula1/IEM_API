<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Illuminate\Support\Str;


class RoleController extends Controller
{
    public function AddRole(Request $Request)
    {
        $validator = Validator::make($Request->all() , [
                'RoleName' => 'required|unique:roles',
            ]);
            if ($validator->fails())
            {
                return response()
                    ->json([
                        'statusCode' => '400', 
                        'status' => 'Failed', 
                        "Error" => $validator->errors() 
                    ]);
            }
            $Role = new Role;
            $Role->RoleName = $Request->RoleName;
            $Role->IsActive = 1;
            $Role->slug = str::random(15);
            $Role->save();
            return response()
                ->json([
                    'statusCode' => '200', 
                    'status' => 'Sucess', 
                    'message' => 'Role Added Sucessfully'
                ]);
    }
    public function RoleDelete(Request $Request, $slug)
    {
        if($slug != null)
        {
            $RoleDelete = \DB::table('roles')->where('slug', $slug)->update([
                'IsActive' => 0,
            ]);
            if($RoleDelete == 1)
            {
                return response()->json([
                    'statusCode' => 200,
                    'status' => 'Sucess',
                    'message' => 'Role Deleted Sucessfully'
                ]);
            }
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'Sorry Something went wrong'
            ]);
        }
    }
    public function GetDataToBeUpdated(Request $Request, $slug)
    {
        $UpdateRole = \DB::table('roles')->where('slug', $slug)->first();
        if($UpdateRole != null)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'Data to be updated',
                'data' => $UpdateRole,
            ]);
        }
        return response()->json([
            'statusCode' => 400,
            'status' => 'Sucess',
            'message' => 'Something Went Wrong'
        ]);
    }
    public function UpdateRole(Request $Request, $slug)
    {
        $RoleUpdate = \DB::table('roles')->where('slug', $slug)->update([
                'RoleName' => $Request->RoleName,
            ]);
        if($RoleUpdate == 1)
            {
                return response()->json([
                    'statusCode' => 200,
                    'status' => 'Sucess',
                    'message' => 'Role Updated Sucessfully'
                ]);
            }
            return response()->json([
                'statusCode' => 200,
                'status' => 'Failed',
                'message' => 'Sorry Something went wrong'
            ]);
    }
    public function Roles()
    {
        $Roles = \DB::table('roles')->get();
        // $Roles = 1;
        if($Roles != null)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'Roles',
                'data' => $Roles
            ]);
        }
        return response()->json([
            'statusCode' => 400,
            'status' => 'Failed',
            'message' => 'No Data Found'
        ]);
    }
}
