<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Billsadvance;
use JWTAuth;
use Illuminate\Support\Str;

class BillsAndAdvancesController extends Controller
{
    public function ApplyBill(Request $Request)
    {
        $validator = Validator::make($Request->all(),[
            'NatureOfBill' => 'required',
            'Upload' => 'required',
            'ToBeSend' => 'required',
            'status' => 'required',
            'settlement' => 'required',
        ]);
        if($validator->fails())
        {
           return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => $validator->errors()
                     ]);
        }
        $Bill = new Billsadvance;
        $Bill->NatureOfBill = $Request->get('NatureOfBill');
        $Bill->UserId = JWTAuth::user()->EmployeeId;
        $Bill->Upload = $Request->get('Upload');
        $Bill->ToBeSend = $Request->get('ToBeSend');
        $Bill->status = $Request->get('status');
        $Bill->settlement = $Request->get('settlement');
        $Bill->slug = $Request->get('CourseName') . Str::random(30);
        $Bill->IsActive = 1;
        $Bill->save();
        return response()->json([
            'statusCode' => 200,
            'status' => true,
            'message' => "Bill Uploaded Sucessfully",
        ]);
    }
    public function BillDelete(Request $Request, $slug)
    {
        $BillDelete = \DB::table('billsadvances')->where('slug', $slug)->update([
                'IsActive' => 2,
        ]);
        if($BillDelete == 1)
        {
            return response()->json([
                    'statusCode' => 200,
                    'status' => true,
                    'message' => 'bill deleted'
            ]);
        }
         return response()->json([
                    'statusCode' => 400,
                    'status' => false,
                    'message' => 'Some thing Went worng'
            ]);
    }
    public function Billsadvances()
    {
        $Billsadvances = \DB::table('billsadvances')->where('IsActive', 1)->get();
        return response()->json([
                'statusCode' => 200,
                'status' => true,
                'message' => 'Bills And Advances Data',
                'data' => $Billsadvances,
        ]);
    }
    public function InactiveBillsAdvances()
    {
        $Billsadvances = \DB::table('billsadvances')->where('IsActive', 2)->get();
        return response()->json([
                'statusCode' => 200,
                'status' => true,
                'message' => 'Deleted Bills And Advances Data',
                'data' => $Billsadvances,
        ]);
    }
}