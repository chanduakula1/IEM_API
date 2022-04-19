<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\BankDetail;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Childrendetails;
use Exception;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\Rule;




class EmployeeController extends Controller
{
    public function EmployeeRegister(Request $Request) // new Employee Regestration
    {
         // try {
        // dd($Request->email);
            $validator = Validator::make($Request->all(), [
                'Title' => 'required',
                'FirstName' => 'required|regex:/^[\pL\s\-]+$/u',
                'LastName' => 'required|alpha',
                'email' => ['required' ,Rule::unique('employees')->where(function ($query) use ($Request) {
    return $query->where('email_verified_at', 1);
})],
                // 'EmailOfficial' => 'required|email|unique:employees',
                // 'EmailPersonal' => 'required|email|unique:employees',
                'password' => 'required',
                // 'DOB' => 'required',
                'Age' => 'required|integer',
                'Gender' => 'required',
                'FatherName' => 'required|regex:/^[\pL\s\-]+$/u',
                'MotherName' => 'required|regex:/^[\pL\s\-]+$/u',
                'MotherTongue' => 'required|regex:/^[\pL\s\-]+$/u',
                'MaritalStatus' => 'required',
                'SpouseName' => 'required|regex:/^[\pL\s\-]+$/u',
                // 'MarriageDate' => 'required',
                // 'IsActive' => 'required',
                // Commented by Uma
                'PresentAddress' => 'required',
                'PermanentAddress' => 'required',
                'PrimaryContactNumber' => 'required|numeric|digits_between:10,15',
                'SecondaryContactNumber' => 'required|numeric|digits_between:10,15',
                'EmergencyName' => 'required|regex:/^[\pL\s\-]+$/u',
                'EmergencyContactNumber' => 'required|numeric|digits_between:10,15',
                'EducationDegree' => 'required',
                'EducationCourse' => 'required',
                'EducationDuration' => 'required',
                'YearOfPass' => 'required|numeric',
                'CollegeOrUniversity' => 'required',
                'EducationPlace' => 'required',
                'PanCard' => 'required',
                'AdharNumber' => 'required|numeric|digits_between:10,18',
                'EPFO' => 'required',
                'PhotoFileId' => 'required',
                'ServiceStatus' => 'required',
                // End of Uma's comments
        ]);
            if ($validator->fails())
            {
                return response()->json([
                    'statusCode'=> '400', 
                    'status'   => 'Failed', 
                    'message'    => $validator->errors()
        ]);
            }else{
                $Employee = new Employee;
                $Employee->Title = $Request->get('Title');
                $Employee->FirstName = $Request->get('FirstName');
                $Employee->LastName = $Request->get('LastName');
                $Employee->EmailOfficial = $Request->get('EmailOfficial');
                $Employee->EmailPersonal = $Request->get('EmailPersonal');
                $EmployeeEmail = $Request->get('email');
                $Employee->email = $Request->get('email');
                $Employee->password = Hash::make($Request->get('password'));
                $Employee->DOB = $Request->get('DOB');
                $Employee->Age = $Request->get('Age');
                $Employee->Gender = $Request->get('Gender');
                $Employee->FatherName = $Request->get('FatherName');
                $Employee->MotherName = $Request->get('MotherName');
                $Employee->MotherTongue = $Request->get('MotherTongue');
                $Employee->MaritalStatus = $Request->get('MaritalStatus');
                $Employee->SpouseName = $Request->get('SpouseName');
                $Employee->MarriageDate = $Request->get('MarriageDate');
                $Employee->slug = $Request->get('FirstName') . Str::random(12); //Generating slug with first name and random 
                $Employee->PresentAddress = $Request->get('PresentAddress');
                $Employee->PermanentAddress = $Request->get('PermanentAddress');
                $Employee->PrimaryContactNumber = $Request->get('PrimaryContactNumber');
                $Employee->SecondaryContactNumber = $Request->get('SecondaryContactNumber');
                $Employee->EmergencyName = $Request->get('EmergencyName');
                $Employee->EmergencyContactNumber = $Request->get('EmergencyContactNumber');
                $Employee->EducationDegree = $Request->get('EducationDegree');
                $Employee->EducationCourse = $Request->get('EducationCourse');
                $Employee->EducationDuration = $Request->get('EducationDuration');
                $Employee->YearOfPass = $Request->get('YearOfPass');
                $Employee->CollegeOrUniversity = $Request->get('CollegeOrUniversity');
                $Employee->EducationPlace = $Request->get('EducationPlace');
                $Employee->PanCard = $Request->get('PanCard');
                $Employee->AdharNumber = $Request->get('AdharNumber');
                $Employee->EPFO = $Request->get('EPFO');
                $Employee->PhotoFileId = $Request->get('PhotoFileId');
                $Employee->ServiceStatus = $Request->get('ServiceStatus');
                $Employee->IsActive = 1; //user active = 1 ->active mode, 0 -> inactive mode.            
                $Employee->save();
                $EmployeeId = $this->get_employee_id($EmployeeEmail);
                // return $EmployeeId;
                $BankDetials = new Bankdetail;
                $BankDetials->EmployeeId = $EmployeeId->EmployeeId; 
                $BankDetials->BankName = $Request->get('BankName');
                $BankDetials->AccountNumber = $Request->get('AccountNumber');
                $BankDetials->Place = $Request->get('Place');
                $BankDetials->IFSC = $Request->get('IFSC');
                $BankDetials->IsActive = 1;
                $BankDetials->save();
                $Child = new Childrendetails;
                $Child->EmployeeId = $EmployeeId->EmployeeId;
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
                $user = JWTAuth::user();
                 return response()->json([
                    'statusCode'=> '200', 
                    'status'   => 'Sucess', 
                    'message'    => 'Employee Created Sucessfully',
                    'User' => $user
        ]);
            }
        // } catch(Exception $ex) {
        //     return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        // }
       
    }

    public function login(Request $request)
    {
        // dd('sdasdasd');
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            // 'password' => 'required|string|min:6|max:50'
            'password' => 'required|string'

        ]);
        //Send failed response if request is not valid
        if ($validator->fails())
        {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try
        {
            if (! $token = JWTAuth::attempt($credentials))
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        }
        catch (JWTException $e)
        {
            return $credentials;
            return response()->json([
                    'success' => false,
                    'message' => 'Could not create token.',
                ], 500);
        }

        $user = JWTAuth::user();
        $role = Employee::select('roles.RoleName', 'roles.RoleId', 'employeeroles.EmployeeId')->join('employeeroles', 'employeeroles.EmployeeId', 'employees.EmployeeId' )->join('roles','employeeroles.RoleId', 'roles.RoleId')->where('employees.EmployeeId', $user->EmployeeId)->get();
    
        //Token created, return with success response and jwt token
        // dd($token);
        return response()->json([
            'success' => true,
            'token' => $token,
            'user_details' => $user,
            'role' => $role,
        ]);
    }
    public function logout(Request $request)
    {
        //valid credential
        // $validator = Validator::make($request->only('token'), [
        //     'token' => 'required'
        // ]);

        //Send failed response if request is not valid
        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->messages()], 200);
        // }

        //Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEmployeesList(Request $request)
    {
        // dd('szdfsdfdfs');
        //return response()->json(["Employee" => Employee::all(), "AuthData" => JWTAuth::authenticate($request->token)]);
        return $user = JWTAuth::user();
    }



    public function EmployeeEdit(Request $Request, $slug) // sending employee detials to UI based on slug
    {
        try{
            $EmployeeId = JWTAuth::user()->EmployeeId;
            $EmployeeData = \DB::table('employees')->where('EmployeeId', $EmployeeId)->first();
            if($EmployeeData == null)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'employee not found',
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'message' => 'employee found',
                    'data' => $EmployeeData,
                ]);
            }
        }catch(Exception $ex){
            return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        }
    }
    public function EmployeeDelete(Request $Request, $slug)
    {
        try{ 
            $Delete = \DB::table('employees')->where('slug', $slug)->update(['IsActive' => 0]);
            if($Delete == 1)
            {
                return response()->json([
                        'statusCode'=> '204', 
                        'status'   => 'Sucess', 
                        'message'    => 'Employee Inactivated Sucessfully'
                         ]);
            }
            if($Delete == 0){
                return response()->json([
                        'statusCode'=> '400', 
                        'status'   => 'Failed', 
                        'message'    => 'Employee Not found'
                        ]);
            }
     }catch(Exception $ex){
            return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        }
    }
    public function EmployeeUpdate(Request $Request, $slug) // update Employee detials 
    {
        try{

        \DB::table('employees')->where('slug', $slug)->update([
            // $Employee = Employee::where('slug', $slug)->first();
            'Title' => $Request->get('Title'),
            'FirstName' => $Request->get('FirstName'),
            'LastName' => $Request->get('LastName'),
            'EmailOfficial' => $Request->get('EmailOfficial'),
            'EmailPersonal' => $Request->get('EmailPersonal'),
            'email' => $Request->get('email'),
            // $Employee->password = Hash::make($Request->get('password'));
            // $Employee->DOB = $Request->get('DOB');
            'Age' => $Request->get('Age'),
            // $Employee->Gender = $Request->get('Gender');
            // $Employee->FatherName = $Request->get('FatherName');
            // $Employee->MotherName = $Request->get('MotherName');
            // $Employee->MotherTongue = $Request->get('MotherTongue');
            // $Employee->MaritalStatus = $Request->get('MaritalStatus');
            // $Employee->SpouseName = $Request->get('SpouseName');
            // // $Employee->MarriageDate = $Request->get('MarriageDate');
            // // $Employee->slug = $Request->get('FirstName') . Str::random(12);
            // $Employee->PresentAddress = $Request->get('PresentAddress');
            // $Employee->PermanentAddress = $Request->get('PermanentAddress');
            // $Employee->PrimaryContactNumber = $Request->get('PrimaryContactNumber');
            // $Employee->SecondaryContactNumber = $Request->get('SecondaryContactNumber');
            // $Employee->EmergencyName = $Request->get('EmergencyName');
            // $Employee->EmergencyContactNumber = $Request->get('EmergencyContactNumber');
            // $Employee->EducationDegree = $Request->get('EducationDegree');
            // $Employee->EducationCourse = $Request->get('EducationCourse');
            // $Employee->EducationDuration = $Request->get('EducationDuration');
            // $Employee->YearOfPass = $Request->get('YearOfPass');
            // $Employee->CollegeOrUniversity = $Request->get('CollegeOrUniversity');
            // $Employee->EducationPlace = $Request->get('EducationPlace');
            // $Employee->PanCard = $Request->get('PanCard');
            // $Employee->AdharNumber = $Request->get('AdharNumber');
            // $Employee->EPFO = $Request->get('EPFO');
            // $Employee->PhotoFileId = $Request->get('PhotoFileId');
            // $Employee->ServiceStatus = $Request->get('ServiceStatus');
            // $Employee->save();
        ]);
            // $Employee = Employee::where('slug', $slug)->first();
            // $Employee->Title = $Request->get('Title');
            // $Employee->FirstName = $Request->get('FirstName');
            // $Employee->LastName = $Request->get('LastName');
            // $Employee->EmailOfficial = $Request->get('EmailOfficial');
            // $Employee->EmailPersonal = $Request->get('EmailPersonal');
            // $Employee->email = $Request->get('email');
            // $Employee->password = Hash::make($Request->get('password'));
            // // $Employee->DOB = $Request->get('DOB');
            // $Employee->Age = $Request->get('Age');
            // $Employee->Gender = $Request->get('Gender');
            // $Employee->FatherName = $Request->get('FatherName');
            // $Employee->MotherName = $Request->get('MotherName');
            // $Employee->MotherTongue = $Request->get('MotherTongue');
            // $Employee->MaritalStatus = $Request->get('MaritalStatus');
            // $Employee->SpouseName = $Request->get('SpouseName');
            // // $Employee->MarriageDate = $Request->get('MarriageDate');
            // // $Employee->slug = $Request->get('FirstName') . Str::random(12);
            // $Employee->PresentAddress = $Request->get('PresentAddress');
            // $Employee->PermanentAddress = $Request->get('PermanentAddress');
            // $Employee->PrimaryContactNumber = $Request->get('PrimaryContactNumber');
            // $Employee->SecondaryContactNumber = $Request->get('SecondaryContactNumber');
            // $Employee->EmergencyName = $Request->get('EmergencyName');
            // $Employee->EmergencyContactNumber = $Request->get('EmergencyContactNumber');
            // $Employee->EducationDegree = $Request->get('EducationDegree');
            // $Employee->EducationCourse = $Request->get('EducationCourse');
            // $Employee->EducationDuration = $Request->get('EducationDuration');
            // $Employee->YearOfPass = $Request->get('YearOfPass');
            // $Employee->CollegeOrUniversity = $Request->get('CollegeOrUniversity');
            // $Employee->EducationPlace = $Request->get('EducationPlace');
            // $Employee->PanCard = $Request->get('PanCard');
            // $Employee->AdharNumber = $Request->get('AdharNumber');
            // $Employee->EPFO = $Request->get('EPFO');
            // $Employee->PhotoFileId = $Request->get('PhotoFileId');
            // $Employee->ServiceStatus = $Request->get('ServiceStatus');
            // $Employee->save();
    } catch(Exception $ex) {
            return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        }
    }
    public function ActiveEmployeeListing() // Listing active employees
    {
    
            // dd('sdgdfgg');
            $EmployeesData = \DB::table('employees')->where('IsActive', '=', 1)->get();
            return response()->json([
                'success' => true,
                'message' => "List Of Employees",
                'data' => $EmployeesData
            ]);
        
    }
    public function InactiveEmployeeLisiting()  //Listing Inactive Employees
    {
        try{
            $InactiveEmployeeList = \DB::table('employees')->where('IsActive', "!=", 1)->orWhere('IsActive', "=", null)->get();
            return response()->json([
                'success' => true,
                'message' => "Inactivated Employees",
                'data' => $InactiveEmployeeList,
            ]);
        }catch(Exception $ex) {
            return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        }
        
    }
    public function get_employee_id($EmployeeEmail)
    {
        try{
            return \DB::table('employees')->where('email', $EmployeeEmail)->select('EmployeeId')->first();
        }catch(\Exception $ex) {
            return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        }           
    }
    public function emailverify($email)
    {
        return \DB::table('employees')->where('email', $email)->where('email_verified_at', 1)->get();
    }
}
