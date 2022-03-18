<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\BankDetail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Childrendetails;
use Exception;

class EmployeeController extends Controller
{
    public function EmployeeRegister(Request $Request) // new Employee Regestration
    {
         // try {
            $validator = Validator::make($Request->all(), [
                'Title' => 'required',
                'FirstName' => 'required|regex:/^[\pL\s\-]+$/u',
                'LastName' => 'required|alpha',
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

                 return response()->json([
                    'statusCode'=> '200', 
                    'status'   => 'Sucess', 
                    'message'    => 'Employee Created Sucessfully'
        ]);
            }
        // } catch(Exception $ex) {
        //     return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        // }
       
    }
    /*




    */
    public function Emoloyeelogin(Request $Request)
    {
        return "employee login sucess";    
    }
    public function EmployeeEdit(Request $Request, $slug) // sending employee detials to UI based on slug
    {
        // return $token;
        try{
        return response()->json([
         \DB::table('employees')->where('slug', $slug)->first() 
     ]);
    }catch(Exception $ex) {
            return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        }
    }
    public function EmployeeDelete(Request $Request, $slug)
    {
        try{
        \DB::table('employees')->where('slug', $slug)->update(['IsActive' => 0]);
         return response()->json([
                    'statusCode'=> '204', 
                    'status'   => 'Sucess', 
                    'message'    => 'Employee Inactivated Sucessfully'
        ]);
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
        try{
            return \DB::table('employees')->where('IsActive', '=', 1)->get();
         }catch(Exception $ex) {
            return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        }
    }
    public function InactiveEmployeeLisiting()  //Listing Inactive Employees
    {
        try{
            return \DB::table('employees')->where('IsActive', "!=", 1)->orWhere('IsActive', "=", null)->get();
        }catch(Exception $ex) {
            return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        }
        
    }
    public function get_employee_id($EmployeeEmail)
    {
        try{
            return \DB::table('employees')->where('email', $EmployeeEmail)->select('EmployeeId')->first();
        }catch(Exception $ex) {
            return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        }           
    }
}
