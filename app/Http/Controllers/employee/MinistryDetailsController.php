<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ministrie;
use App\Models\ministriedetail;
use Illuminate\Support\Str;
use JWTAuth;


class MinistryDetailsController extends Controller
{
    public function MinistryDetailSubmit(Request $Request)
    {
        $validator = Validator::make($Request->all(),[
            'Ministry' => 'required',
            'Category' => 'required',
            'Region' => 'required',
            'Mission' => 'required',
            'AppointmentDate' => 'required',
            'ConfirmationDate' => 'required',
            'JoiningDate' => 'required',
        ]);
        if($validator->fails())
        {
           return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => $validator->errors()
                     ]);
        }
        $Ministry = new Ministrie;
        $Ministry->Ministry = $Request->Ministry;
        $Ministry->Category = $Request->Category; 
        $Ministry->Region = $Request->Region;
        $Ministry->Mission = $Request->Mission;
        $Ministry->AppointmentDate = $Request->AppointmentDate;
        $Ministry->ConfirmationDate = $Request->ConfirmationDate;
        $Ministry->JoiningDate = $Request->JoiningDate;
        $Ministry->IsActive = 1;
        $Ministry->slug = Str::random(30);
        $Ministry->save(); 
        return response()->json([
            'statusCode' => 400,
            'status' => 'Sucess',
            'message' => 'Ministry Created Sucessfully',
        ]);
    }
    public function MinistryDetailDelete(Request $Request, $slug)
    {
        $MinistryDetailDelete = \DB::table('Ministries')->where('slug' ,$slug)->update([
                'IsActive' => 0,
        ]);
        if($MinistryDetailDelete == 1)
        {
            return response()->json([
                    'status' => 'Sucess',
                    'statusCode' => 400,
                    'message' => 'Ministry Updated Sucessfully',
            ]);
        }
        return response()->json([
                'statusCode' => 200,
                'status' => 'Failed',
                'message' => 'Sorry Something Went Wrong'
        ]); 
    }
    public function MinistryDetailUpdate(Request $Request, $slug)
    {
        $MinistryDetailUpdate = \DB::table('Ministries')->where('slug', $slug)->update([
                'Ministry' => $Request->Ministry,
                'Category' => $Request->Category,
        ]);
        if($MinistryDetailUpdate == 1)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'Ministry Updated Sucessfully',
            ]);
        }
        return response()->json([
            'statusCode' => 400,
            'status' => 'Failed',
            'message' => 'Sorry Something Went Wrong',
        ]);
    }
    public function MinistryDetailEdit(Request $Request, $slug)
    {
        $MinistryDetailEdit = \DB::table('Ministries')->where('slug', $slug)->first();
        if($MinistryDetailEdit != null)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'Ministry Details',
                'data' => $MinistryDetailEdit,
            ]);
        }
        return response()->json([
            'statusCode' => 400,
            'status' => 'Failed',
            'message' => 'No Details Found',
        ]);
    }
    public function MinistryDetails()
    {
        $MinistryDetails = \DB::table('Ministries')->where('IsActive', 1)->get();
        // $MinistryDetails = null;
        if($MinistryDetails != null)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'Ministry List',
                'data' => $MinistryDetails
            ]);
        }
        return response()->json([
            'statusCode' => 400,
            'status' => 'Failed',
            'message' => 'Sorry No data Found'
        ]);
    }
    public function Ministries(Request $Request)
    {
        $validator = Validator::make($Request->all(),[
            'ministryname' => 'required',
        ]);
        if($validator->fails())
        {
           return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => $validator->errors()
            ]);
        }
        $Ministry = new ministriedetail;
        $Ministry->ministryname = $Request->ministryname;
        $Ministry->IsActive = 1;
        $Ministry->slug = Str::random(30);
        $Ministry->createdBy = JWTAuth::user()->EmployeeId;
        $Ministry->save(); 
    }
}
