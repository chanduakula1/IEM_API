<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveApply;
use Carbon\Carbon;
use JWTAuth;

use Validator;

class LeaveManagementController extends Controller
{
    public function LeaveApply(Request $Request)
    {
        // return Carbon::now();
        $validations = Validator::make($Request->all(),[
            'LeaveType' => 'required',
            'FromDate' => 'required',
            'ToDate' => 'required',
        ]);
        if($validations->fails())
        {
            return response()->json([
                'statusCode'=> '400', 
                'status'   => 'Failed', 
                'message'    => $validations->errors(),
            ]);
        }

        $dateFrom=\Carbon\Carbon::createFromFormat('Y/m/d',$Request->FromDate);
        $dateTo=\Carbon\Carbon::createFromFormat('Y/m/d',$Request->ToDate);
        /*
        {
            "FromDate" : "03/04/2017",  month,date,year.
            "ToDate" : "03/05/2017"
        }
        */
        $email = $Request->get('email');
        // $Check_employee_mail = $this->CheckMail($email);
        // if($Check_employee_mail == null)
        // {
        //     return response()->json([
        //             'statusCode'=> '400', 
        //             'status'   => 'Failed', 
        //             'message'    => 'Email'
        //              ]);
        // }
        // $Employeeid = $this->EmployeeId($email);
        // $empid = $Employeeid->EmployeeId;
        $LeaveType = $Request->get('LeaveType');
        $Reason = $Request->get('Reason');
        $FromDate = $Request->get('FromDate');
        $ToDate = $Request->get('ToDate');
        $NoOfDays =  $dateFrom->diffInDays($dateTo);
        // echo $FromDate, $ToDate, $NoOfDays;
        $LeaveStatus = 0;
        $NewLeave = new LeaveApply;
        $NewLeave->EmployeeId  = JWTAuth::user()->EmployeeId; 
        $NewLeave->LeaveType = $LeaveType;
        $NewLeave->Reason = $Reason;
        $NewLeave->FromDate = $FromDate;
        $NewLeave->ToDate = $ToDate;
        $NewLeave->NoOfDays = $NoOfDays;
        $NewLeave->LeaveStatus = 0;
        $NewLeave->IsActive = 1;
        $NewLeave->save();
        return response()->json([
                    'statusCode'=> '200', 
                    'status'   => 'Sucess', 
                    'message'    => 'Leave Applied Sucessfully'
                     ]);

    }
    public function WithdrawLeaveApplication(Request $Request)
    {
        $validations = Validator::make($Request->all(),[
            // 'email' => 'required',
            'LeaveId' => 'required',
        ]);
        if($validations->fails())
        {
             return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => $validations->errors(),
                     ]);
        }
        // $email = $Request->get('email');
        $LeaveId = $Request->get('LeaveId');
        // dd($LeaveId);
        // $Employeeid = $this->EmployeeId($email);
        $Employeeid = JWTAuth::user()->EmployeeId;
        $CancelLeave = \DB::table('leavemanagement')->where('EmployeeId', $Employeeid)->where('LeaveId', $LeaveId)->update([
            'IsActive' => 0,
        ]);
        if($CancelLeave == 1)
        {
         return response()->json([
                    'statusCode'=> '200', 
                    'status'   => 'Sucess', 
                    'message'    => 'Leave Cancelled Sucessfully'
                     ]);
        }else{
            return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => 'Data Not Found'
                     ]);
        }
    }
    public function ChangeLeaveDates(Request $Request)
    {
        // $email = $Request->get('email');
        $LeaveId = $Request->get('LeaveId');
        // $Employeeid = $this->EmployeeId($email);
        $Employeeid = JWTAuth::user()->EmployeeId;
        $FromDate = $Request->get('FromDate');
        $ToDate = $Request->get('ToDate');
        $dateFrom = \Carbon\Carbon::createFromFormat('Y/m/d',$Request->FromDate);
        $dateTo = \Carbon\Carbon::createFromFormat('Y/m/d',$Request->ToDate);
        $NoOfDays =  $dateFrom->diffInDays($dateTo);
        $CancelLeave = \DB::table('leavemanagement')->where('EmployeeId', $Employeeid)->where('LeaveId', $LeaveId)->update([
            'FromDate' => $dateFrom,
            'ToDate' => $dateTo,
            'NoOfDays' => $NoOfDays
        ]);
        if($CancelLeave == 1)
        {
         return response()->json([
                    'statusCode'=> '200',
                    'status'   => 'Sucess', 
                    'message'    => 'Leave Updated Sucessfully'
                     ]);
        }else{
            return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => 'Leave Already Sucessfully'
                     ]);
        }
    }
    public function IndividualEmployeeLeaves()
    {
        // dd('dsfdsfdfs');
        $EmployeeId = JWTAuth::user()->EmployeeId;
        $LeaveData = \DB::table('leavemanagement')->where('EmployeeId', $EmployeeId)->get();
        // $LeaveData = 0;
        if($LeaveData != null)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'leaves data',
                'data' => $LeaveData
            ]);
        }else{
             return response()->json([
                    'statusCode'=> 400,
                    'status'   => 'Failed', 
                    'message'    => 'No Leaves Found'
                     ]);
        }
    }
    public function ListingLeaves()
    {
        $TotalLeaves = \DB::table('leavemanagement')->where('IsActive', '=', 1)->get();
        return $TotalLeaves;
    }
    public function EmployeeId($email)
    {
        $Employeeid = \DB::table('employees')->where('email', $email)->select('EmployeeId')->first();
        return $Employeeid;
    }
    public function CheckMail($email)
    {
        $CheckMail = \DB::table('employees')->where('email', $email)->select('EmployeeId')->first();
        return $CheckMail;
    }
}
