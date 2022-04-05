<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employeecourse;
use Validator;
use Illuminate\Support\Str;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class EmployeeCourses extends Controller
{
    public function EmployeeRegisterCourse(Request $Request)
    {
        $validations = Validator::make($Request->all(),[
            'CourseId' => 'required',
        ]);
        if($validations->fails())
        {
            return response()->json([
                'statusCode'=> '400', 
                'status'   => 'Failed', 
                'message'    => $validations->errors(),
            ]);
        }
        // return $Request->get('CourseId');

        // $email = $Request->email;
        // $CheckMail = $this->CheckMail($email);

        
            // $EmployeeId = $this->Email($email);
            // return $EmployeeId->EmployeeId;
            $Course = new employeecourse;
            $Course->EmployeeId  = JWTAuth::user()->EmployeeId;
            $Course->CourseId  = $Request->get('CourseId');
            $Course->IsActive = 1;
            $Course->slug = Str::random(30);
            $Course->save();
            return response()->json([
                'statusCode'=> '200', 
                'status'   => 'Sucess', 
                'message'    => 'Sucessfully Registered to course'
            ]);
    }
    public function EmployeeCourseDelete(Request $Request, $slug)
    {
        $EmployeeCoursesDelete = \DB::table('employeecourse')->where('slug', $slug)->update([
            'IsActive' => 0,
        ]);
        // dd($EmployeeCoursesDelete);
        if($EmployeeCoursesDelete == 1)
        {
            return response()->json([
                'statusCode'=> '200', 
                'status'   => 'Sucess', 
                'message'    => 'Sucessfully deleted'
            ]);
        }elseif($EmployeeCoursesDelete == 0) {
            return response()->json([
                'statusCode'=> '400', 
                'status'   => 'Failed', 
                'message'    => 'already deleted'
            ]);
        }
        else{
            return response()->json([
                'statusCode'=> '400', 
                'status'   => 'Failed', 
                'message'    => 'Not Found'
            ]);
        }
    }
    public function EmployeeCourseList()
    {
        $Employee_id = JWTAuth::user()->EmployeeId;
        $EmployeeCoursesList = \DB::table('employeecourse')->where('EmployeeId', $Employee_id)->get();
        // $EmployeeCoursesList = null;
        if($EmployeeCoursesList != null)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'Employee Course List',
                'data' => $EmployeeCoursesList,
            ]);
        }else{
             return response()->json([
                'statusCode' => 400,
                'status' => 'Failed',
                'message' => 'Employee Course List Not Found'
            ]);
        }
    }
    public function EmployeeCourseUpdate(Request $Request, $slug)
    {
        $EmployeeCourseData = \DB::table('employeecourse')->where('slug', $slug)->first();
        // $EmployeeCourseData = 1;
        if($EmployeeCourseData != null)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'Sucess',
                'message' => 'employee data',
                'data' => $EmployeeCourseData,
            ]);
        }else{
            return response()->json([
                'statusCode' => 400,
                'status' => 'Failed',
                'message' => 'No user Found'
            ]);
        }
        // dd($EmployeeCourseData);
    }
    public function EmployeeCourseUpdateData(Request $Request, $slug)
    {
          $validations = Validator::make($Request->all(),[
            'CourseId' => 'required',
            ]);
        if($validations->fails())
        {
            return response()->json([
                'statusCode'=> '400', 
                'status'   => 'Failed', 
                'message'    => $validations->errors(),
            ]);
        }
        $UpdateData = \DB::table('employeecourse')->where('slug', $slug)->update([
            'CourseId' => $Request->CourseId,
        ]);
        if($UpdateData == 1)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'sucess',
                'message' => 'Data Updated Sucessfully',
            ]);
        }else{
            return response()->json([
                'statusCode'=> 400, 
                'status'   => 'Failed', 
                'message'    => 'Data Not Found Or Data Alreday Updated',
            ]);
        }
    }
    public function Email($email)
    {
        return \DB::table('employees')->where('email', $email)->select('EmployeeId')->first();
    }
    public function CheckMail($email)
    {
        return \DB::table('employees')->where('email', $email)->first();
    }
}
