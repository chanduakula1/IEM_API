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
            'date' => 'required',
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
        $Dairy->date = $Request->date;
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
    public function Personaldairyupdate(Request $Request)
    {
        $validator = Validator::make($Request->all(),[
            'id' => 'required',
            'heading' =>'required',
            'message' => 'required',
            'date' => 'required',
        ]);
        if($validator->fails())
        {
           return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => $validator->errors()
                     ]);
        }
        $Personaldairyupdate = \DB::table('presonaldairies')->where('id', $Request->id)->update([
                'heading' => $Request->heading,
                'message' => $Request->message,
                'date' => $Request->date,               
        ]);
        if($Personaldairyupdate == null)
        {
            return response()->json([
                'statusCode' => 400,
                'status' => 'Failed',
                'message' => 'Personal Dairy Detials Not found'
            ]);
            
        }
        return response()->json([
            'statusCode' => 200,
            'status' => 'Sucess',
            'message' => 'Pesornal Dairy Detials',
        ]);
    }
    public function Personaldairydelete(Request $Request)
    {
        $validator = Validator::make($Request->all(),[
            'id' => 'required',
        ]);
        if($validator->fails())
        {
           return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => $validator->errors()
                     ]);
        }
        $PersonaldairyDelete = \DB::table('presonaldairies')->where('id', $Request->id)->update([
            'is_active' => 2,
        ]);
        if($PersonaldairyDelete == 1)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'Personal Journal Deleted Sucessfully',
            ]);
        }
        return response()->json([
            'statusCode' => 400,
            'status' => 'Failed',
            'message' => 'sorry some thin went wrong',
        ]);
    }
}
