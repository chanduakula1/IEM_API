<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Personaljournal;
use JWTAuth;
use Illuminate\Support\Str;

class PersonalJournalController extends Controller
{
    public function PersonalJournalSubmit(Request $Request)
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
        // dd(Str::random(30));
        $Personal = new Personaljournal;
        $Personal->user_id = JWTAuth::user()->EmployeeId;
        $Personal->heading = $Request->heading;
        $Personal->message = $Request->message;
        $Personal->is_active = 1;
        $Personal->slug =  Str::random(30);
        $Personal->save();
        return response()->json([
            'statusCode' => 200,
            'status' => 'Sucess',
            'message' => 'Data Submitted Sucessfully',
        ]);
    }
    public function PersonalJournals(Request $Request)
    {
        $EmployeeId = JWTAuth::user()->EmployeeId;
        $PersonalJournals = \DB::table('PersonalJournals')->where('user_id', $EmployeeId)->get();
        if(count($PersonalJournals) != 0)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'Personal Journal Data',
                'data' => $PersonalJournals,
            ]);
        }
        return response()->json([
            'statusCode' => 400,
            'status' => 'Failed',
            'message' => 'Personal Journal Data Not found',
        ]);
    }
    public function PersonalJournalsUpdate(Request $Request, $slug)
    {
        $Personaljournal = \DB::table('personaljournals')->where('slug', $slug)->update([
                'heading' => $Request->heading,
                'message' => $Request->message,               
        ]);
        if($Personaljournal == null)
        {
            return response()->json([
                'statusCode' => 400,
                'status' => 'Failed',
                'message' => 'Personal Journal Detials Not found'
            ]);
            
        }
        return response()->json([
            'statusCode' => 200,
            'status' => 'Sucess',
            'message' => 'Pesornal Journal Detials',
        ]);
    }
    public function PersonalJournalsDelete(Request $Request, $slug)
    {
        $PersonalJournalDelete = \DB::table('personaljournals')->where('slug', $slug)->update([
            'is_active' => 2,
        ]);
        if($PersonalJournalDelete == 1)
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
