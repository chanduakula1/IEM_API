<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Logincontroller extends Controller
{
    public function login(Request $Request)
    {
        if (isset($Request))
        {
            $credentials = [
                'email' => $Request->email,
                'password' => $Request->password
            ];
            if (auth()->attempt($credentials))
            {
                $id = auth()->user()->id;
                $role = auth()->user()->role;
                $name = auth()->user()->name;
                $data["id"] = $id;
                $data["role"] = $role;
                $data["name"] = $name;
                return response()->json([
                    "message" => "Login Sucessfully",
                    'data' => $data
                ]);
            }
            else
            {
                return response()->json([
                    "message" => "Login Failed"
                ]);
            }
        }
    }
}

