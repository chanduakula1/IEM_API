<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $Bill->NatureOfBill = $Request->get('CourseName');
        $Bill->Upload = $Request->get('FromDate');
        $Bill->ToBeSend = $Request->get('ToDate');
        $Bill->status = JWTAuth::user()->EmployeeId;
        $Bill->settlement = $Request->get('CollegeName');
        $Bill->CourseType = $Request->get('CourseType');
        $Bill->Duration = $Request->get('Duration');
        $Bill->SponsoredBy = $Request->get('SponsoredBy');
        $Bill->OtherDetails = $Request->get('OtherDetails');
        $Bill->slug = $Request->get('CourseName') . Str::random(30);
        $Bill->IsActive = 1;
        $Bill->save();
        return response()->json([
            'statusCode' => 200,
            'status' => true,
            'message' => "New Course Added Sucessfully",
        ]);
    }
}
