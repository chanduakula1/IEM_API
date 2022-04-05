<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Childrendetails;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class ChildDetails extends Controller
{

    public function ChildDetialsRegister(Request $Request) // register new child details
    
    {
        // return $Request->get('ChildName');
        // return Auth::user();
        try
        {
            $validator = Validator::make($Request->all() , [
                'ChildName' => 'required|regex:/^[\pL\s\-]+$/u',
                // 'DOB' => 'required',
                'Gender' => 'required', 
                'MaritalStatus' => 'required', 
                'PresentAddress' => 'required',
            ]);
            if ($validator->fails())
            {
                return response()
                    ->json([
                        'statusCode' => '400', 
                        'status' => 'Failed', 
                        "Error" => $validator->errors() 
                    ]);
            }
            $Child = new Childrendetails;
            $Child->EmployeeId = JWTAuth::user()->EmployeeId;
            $Child->ChildName = $Request->get('ChildName');
            $Child->DOB = $Request->get('DOB');
            $Child->Gender = $Request->get('Gender');
            $Child->MaritalStatus = $Request->get('MaritalStatus');
            $Child->PresentAddress = $Request->get('PresentAddress');
            $Child->Email = $Request->get('Email');
            $Child->slug = $Request->get('ChildName') . Str::random(30);
            $Child->ContactNumber = $Request->get('ContactNumber');
            $Child->IsActive = 1;
            $Child->save();
            return response()
                ->json([
                    'statusCode' => '200', 
                    'status' => 'Sucess', 
                    'message' => 'Child Detials created sucessfully'
                ]);
        }
        catch(Exception $ex)
        {
            return $this->getErrorJsonResponse([], $ex->getMessage() , $ex->getCode());
        }

    }
    public function ChildDetialsEdit(Request $Request, $value) // Sending Child detials to UI based on slug
    
    {
        try
        {
            $ChildData = \DB::table('childrendetails')->where('slug', $value)->first();
            if($ChildData == null)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Child Not Found',
                    'data' => null
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Child Detials',
                'data' => $ChildData
            ]);
        }
        catch(Exception $ex)
        {
            return $this->getErrorJsonResponse([], $ex->getMessage() , $ex->getCode());
        }
    }
    public function ChildDetialsUpdate(Request $Request, $value) // updating child detials
    
    {
        try
        {
            $UpdateChild = \DB::table('childrendetails')->where('slug', $value)->update([
            // $Child->EmployeeId =  1;
            'ChildName' => $Request->get('ChildName') , 
            'DOB' => $Request->get('DOB') , 
            'Gender' => $Request->get('Gender') , 
            'MaritalStatus' => $Request->get('MaritalStatus') , 
            'PresentAddress' => $Request->get('PresentAddress') , 
            'Email' => $Request->get('Email') ,
            // $Child->slug = $Request->get('ChildName') . Str::random(30);
            'ContactNumber' => $Request->get('ContactNumber')
            // $Child->IsActive  = 1;
            ]);
            // dd($UpdateChild);
            if($UpdateChild == 0)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Child Detials Not Updated',
                    // 'data'
                ]);
            }
            return response()->json([
                    'sucess' => true, 
                    'message' => 'Child Detials Updated', 
                    // 'message' => 'Child Detials Updated sucessfully'
                ]);
        }
        catch(Exception $ex)
        {
            return $this->getErrorJsonResponse([], $ex->getMessage() , $ex->getCode());
        }

    }
    public function ChildDetialsDelete(Request $Request, $value) // inactivate child detials
    
    {
        try
        {
            $childdata = \DB::table('childrendetails')->where('slug', $value)->update([
                'IsActive' => 0, 
            ]);
            if($childdata == 1)
            {
                return response()->json([
                    'success' => true,
                    'message' => "Child inactivated sucessfully",
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Child Detials already Inactived",
                ]);
            }
        }
        catch(Exception $ex)
        {
            return $this->getErrorJsonResponse([], $ex->getMessage() , $ex->getCode());
        }
        // if(!empty($childdata))
        // {
        // return response()->json([
        //     "message" => "child data deleted sucessfully"
        // ]);
        // }else{
        //     return response()->json([
        //     "message" => "child data not found"
        // ]);
        // }
        
    }
    public function ChildList() // listing childs
    {
        try{
            $ChildDetails = \DB::table('childrendetails')->where('IsActive', '=', 1)->get();
            return response()->json([
                'success' => true,
                'message' => 'Child Detials',
                'data' => $ChildDetails, 400
            ]);
        }catch(Exception $ex){
            return $this->getErrorJsonResponse([], $ex->getMessage() , $ex->getCode());
        }
        
    }
    public function InactiveChildList() //inactive child detials
    {
        try{
            $InactiveChildList = \DB::table('childrendetails')->where('IsActive', '!=', 1)->get();
            return response()->json([
                'success' => true,
                'message' => 'Inactive Child List',
                'data' => $InactiveChildList,
            ]);
        }catch(Exception $ex){
            return $this->getErrorJsonResponse([], $ex->getMessage() , $ex->getCode());
        }
    }
    public function mail($value='')
    {
        Mail::send([‘text’=>’text.view’], $data, $callback);
    }
}

