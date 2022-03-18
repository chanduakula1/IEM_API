<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Employee;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
      try{
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) 
        {
            return response()->json([$validator->errors(), 422]);
        }
        if (! $token = auth()->attempt($validator->validated())) 
        {
            return response()->json([
                'status' => 'Failed',
                 'statusCode' => 401,
            ]);
        }
        $id = auth()->user();
        // return $id;
        return $this->createNewToken($token);
    }  catch(Exception $ex) 
    {
            return $this->getErrorJsonResponse([], $ex->getMessage(), $ex->getCode());
        }
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    //////register

    public function EmployeeRegister(Request $Request)
    {
        // if($Request->submit)
        // {
        //return $Request->all();
            $validator = Validator::make($Request->all(), [
                'Title' => 'required',
                'FirstName' => 'required|regex:/^[\pL\s\-]+$/u',
                'LastName' => 'required|alpha',
                'EmailOfficial' => 'required',
                'EmailPersonal' => 'required',
                'EmployeePassword' => 'required',
                'DOB' => 'required',
                'Age' => 'required',
                'Gender' => 'required',
                'FatherName' => 'required',
                'MotherName' => 'required',
                'MotherTongue' => 'required',
                'MaritalStatus' => 'required',
                'SpouseName' => 'required',
                'MarriageDate' => 'required',
                'PresentAddress' => 'required',
                'PermanentAddress' => 'required',
                'PrimaryContactNumber' => 'required',
                'SecondaryContactNumber' => 'required',
                'EmergencyName' => 'required',
                'EmergencyContactNumber' => 'required',
                'EducationDegree' => 'required',
                'EducationCourse' => 'required',
                'EducationDuration' => 'required',
                'YearOfPass' => 'required',
                'CollegeOrUniversity' => 'required',
                'EducationPlace' => 'required',
                'PanCard' => 'required',
                'AdharNumber' => 'required',
                'EPFO' => 'required',
                'PhotoFileId' => 'required',
                'ServiceStatus' => 'required',
                'IsActive' => 'required',
                // $2y$10$Ia7lVb5dI6qRxaEdATBhoubujxN.LPKRX7koladzBdPXwPF7eSaS.
                // $2y$10$Ia7lVb5dI6qRxaEdATBhoubujxN.LPKRX7koladzBdPXwPF7eSaS.
                // $2y$10$Nu9yVxVm/8iiNzEivRaMAuKgim3WktBhUXJ9LOVQbIfc5BNUpGzMi
        ]);
            if ($validator->fails())
            {
                return response()->json([
                    'error_code'=> 'VALIDATION_ERROR', 
                    'message'   => 'The given data was invalid.', 
                    'errors'    => $validator->errors()
        ]);
            }else{
                $Employee = new Employee;
                $Employee->Title = $Request->get('Title');
                // $Employee->Employee_last_name = $Request->get('employee_last_name');
                $Employee->save();
                return response()->json([
                    "message" => "sucess"
                ],Response::HTTP_OK);
            }
        // }
    }
    //////register end
    // public function register(Request $request) {

    //     $validator = Validator::make($request->all(), [
    //         'Title' => 'required',
        
    //     ]);
    //     if($validator->fails()){
    //         return response()->json($validator->errors()->toJson(), 400);
    //     }
    //     $user = Employee::create(array_merge(
    //                 $validator->validated(),
    //                 ['password' => bcrypt($request->password)]
    //             ));
    //     return response()->json([
    //         'message' => 'User successfully registered',
    //         'user' => $user
    //     ], 201);
    // }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        $save_token = auth()->user()->id;
        // return $save_token;
        $get_token = \DB::table('employees')->where('EmployeeId', $save_token)->first();
        // $get_token->token = $token;
       $result =  \DB::Table('employees')->where('EmployeeId',$save_token)->update(
                    array(
                    'token' =>  $token
                    // 'email' => $request->email,
                    // 'password' => $request->password
                    )
                    );
        // $new_token = $get_token->token;
        // return $get_token->token;
        // $Employee = Employee::find($save_token)->where('EmployeeId', $save_token); 
        return response()->json([
            'status' => 'Sucess',
            'statusCode' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'response' => auth()->user()
        ]);
    }
}

