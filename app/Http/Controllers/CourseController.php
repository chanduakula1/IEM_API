<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\coursedetail;
use Illuminate\Support\Str;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class CourseController extends Controller
{

    protected $user;

    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }
    

    public function CreateNewCourse(Request $Request)
    {
        $validator = Validator::make($Request->all(),[
            'CourseName' => 'required',
            'CollegeName' => 'required',
            'CourseType' => 'required',
            'Duration' => 'required',
            'SponsoredBy' => 'required',
        ]);
        if($validator->fails())
        {
           return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => $validator->errors()
                     ]);
        }
        // dd(JWTAuth::user()->EmployeeId);
        $Course = new coursedetail;
        $Course->CourseName = $Request->get('CourseName');
        $Course->FromDate = $Request->get('FromDate');
        $Course->ToDate = $Request->get('ToDate');
        $Course->user_id = JWTAuth::user()->EmployeeId;
        $Course->CollegeName = $Request->get('CollegeName');
        $Course->CourseType = $Request->get('CourseType');
        $Course->Duration = $Request->get('Duration');
        $Course->SponsoredBy = $Request->get('SponsoredBy');
        $Course->OtherDetails = $Request->get('OtherDetails');
        $Course->slug = $Request->get('CourseName') . Str::random(30);
        $Course->IsActive = 1;
        $Course->save();
        return response()->json([
            'statusCode' => 200,
            'status' => true,
            'message' => "New Course Added Sucessfully",
        ]);
    }
    public function DeleteCourse(Request $Request, $slug)
    {
        if($slug != null)
        {
            $DeleteCourse = \DB::table('coursedetails')->where('slug', $slug)->update([
                'IsActive' => 0,
            ]);
            if($DeleteCourse == 1)
            {
                return response()->json([
                    'statusCode'=> '200', 
                    'status'   => 'Sucess', 
                    'message'    => 'Course Deleted Sucessfully'
                     ]);
            }else{
                return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => 'sorry some error has been occured'
                     ]);
            }
        }
    }
    public function ListingCourses()
    {
        $Course = \DB::table('coursedetails')->where('IsActive', 1)->get();
        return $Course;
    }
    public function UpdateCourse(Request $Request, $slug)
    {
        if($slug != null)
        {
            $update = \DB::table('coursedetails')->where('slug', $slug)->first();
            if($update != null)
            {
                return response()->json([
                    'statusCode' => 200,
                    'status' => 'Sucess',
                    'message' => 'data to be updated',
                    'data' => $update
                ]);
            } 
        }
        return response()->json([
            'statusCode' => 200,
            'status' => "Failed",
            'message' => "sorry some error has been occured"
        ]);
    }
    public function UpdateCouserDetials(Request $Request, $slug)
    {
         $validator = Validator::make($Request->all(),[
            'CourseName' => 'required',
            'FromDate' => 'required',
            'ToDate' => 'required',
            'CollegeName' => 'required',
            'CourseType' => 'required',
            'SponsoredBy' => 'required',
            'OtherDetails' => 'required'
        ]);
        if($validator->fails())
        {
           return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => $validator->errors()
                     ]);
        }

        $CourseUpdate = \DB::table('coursedetails')->where('slug', $slug)->update([
            'CourseName' => $Request->CourseName,
            'FromDate' => $Request->FromDate,
            'ToDate' => $Request->ToDate,
            'CollegeName' => $Request->CollegeName,
            'CourseType' => $Request->CourseType,
            'Duration' => $Request->Duration,
            'SponsoredBy' => $Request->SponsoredBy,
            'OtherDetails' => $Request->OtherDetails,
        ]);
        if($CourseUpdate == 1)
        {
            return response()->json([
                'statusCode' => 200,
                'status' => 'sucess',
                'message' => 'course details updated sucessfully',
            ]);
        }else{
            return response()->json([
                'statusCode' => 400,
                'status' => 'Failed',
                'message' => 'sorry some error has been occured or already updated',
            ]);
        }
        
    }
}
  