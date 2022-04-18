<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Models\Presonaldairy;

class PersonalDiaryController extends Controller
{
    public function PersonalDiarySubmit(Request $Request)
    {
         $validator = Validator::make($Request->all(),[
            'heading' =>'required',
            'message' => 'required',
        ]);
        if($validator->fails())
        {
           return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => $validator->errors()
                     ]);
        }
        $Dairy = new Presonaldairy;
        $Dairy->user_id = JWTAuth::user()->EmployeeId;
        $Dairy->heading = $Request->heading;
        $Dairy->message = $Request->message;
        $Dairy->is_active = 1;
        $Dairy->save();
        return response()->json([
            'statusCode' => 200,
            'status' => 'Sucess',
            'message' => 'data submitted Sucessfully',
        ]);
    }
    public function Personaldairy()
    {
        $employee = JWTAuth::user()->EmployeeId;
        $PersonalDiaryListing = \DB::table('presonaldairies')->where('user_id', $employee)->get();
        // dd();
        if(count($PersonalDiaryListing) != 0)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'Personal data',
                'data' => $PersonalDiaryListing,
            ]);
        }
        return response()->json([
            'statusCode' => 400,
            'status' => 'sucess',
            'messsage' => 'No Categories Found',
        ]);
    }
}
