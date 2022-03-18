<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\passwordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;

class MailController extends Controller
{
    public function ResetMail(Request $request, $email)
    {
        $send_mail = $email;
        $check_email = $this->CheckEmail($email);
        if (empty($check_email))
        {
            return response()->json(['statusCode' => '400', 'status' => 'failed', 'message' => 'email not found']);
        }
        $EmployeeId = $this->EmployeeId($email);
        $OTP = $this->OTPGENERATE($EmployeeId);
        // return $OTP;
        $data = array(
            'name' => "Virat Gandhi",
            'otp' => $OTP
        );
        // return $send_mail;
        Mail::send(['text' => 'mail'], $data, function ($message) use ($email)
        {
            $message->to($email, 'Tutorials Point')->subject('Laravel Basic Testing Mail');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        return response()->json([
            'statusCode' => '200', 
            'status' => 'Sucess', 
            'email' => $email, 
            'message' => 'Otp Send Sucessfully'
        ]);
    }
    public function CheckEmail($email)
    {
        $email_check = \DB::table('employees')->where('email', $email)->first();
        return $email_check;
    }
    public function OTPGENERATE($EmployeeId)
    {
        $Generated_otp = mt_rand(1000000000, 9999999999);
        $update_otp = \DB::table('password_resets')->where('EmployeeId', $EmployeeId->EmployeeId)
            ->first();
        if ($update_otp)
        {
            \DB::table('password_resets')->where('EmployeeId', $EmployeeId->EmployeeId)
                ->update(['Otp' => $Generated_otp]);
        }
        else
        {
            $otp = new passwordReset;
            $otp->EmployeeId = $EmployeeId->EmployeeId;
            $otp->Otp = $Generated_otp;
            $otp->save();
        }
        return $Generated_otp;
        // $otp->LastName = $Request->get('LastName');
        
    }
    public function EmployeeId($email)
    {
        return \DB::table('employees')->where('email', $email)->select('EmployeeId')
            ->first();
    }
    // public function html_email() {
    //    $data = array('name'=>"Virat Gandhi");
    //    Mail::send('mail', $data, function($message) {
    //       $message->to('chanduakula111@gmail.com', 'Tutorials Point')->subject
    //          ('Laravel HTML Testing Mail');
    //       $message->from('xyz@gmail.com','Virat Gandhi');
    //    });
    //    echo "HTML Email Sent. Check your inbox.";
    // }
    // public function attachment_email() {
    //    $data = array('name'=>"Virat Gandhi");
    //    Mail::send('mail', $data, function($message) {
    //       $message->to('abc@gmail.com', 'Tutorials Point')->subject
    //          ('Laravel Testing Mail with Attachment');
    //       $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
    //       $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
    //       $message->from('xyz@gmail.com','Virat Gandhi');
    //    });
    //    echo "Email Sent with attachment. Check your inbox.";
    // }
    public function VerifyOtp(Request $Request)
    {
        try
        {
            // print_r('')
            $email = $Request->get('email');
            // return $email;
            $otp = $Request->get('otp');
            $EmployeeId = \DB::table('employees')->where('email', $email)->select('EmployeeId')
                ->first();
            // return $EmployeeId;
            $Generated_otp = \DB::table('password_resets')->where('EmployeeId', $EmployeeId->EmployeeId)
                ->select('Otp')
                ->first();
            // return $Generated_otp;
            if (!empty($Generated_otp))
            {
                if ($Generated_otp->Otp == $otp && $EmployeeId != null && $Generated_otp != null)
                {
                    return response()->json([
                        'statusCode' => '200', 
                        'status' => 'Sucess', 
                        'email' => 'email', 
                        'message' => 'password changes sucessfulluy'
                    ]);
                }
                else
                {
                    return response()->json([
                            'statusCode' => '400', 
                            'status' => 'Failed', 
                            'message' => 'Entered Invalid Otp'
                        ]);
                }
            }
            else
            {
                return response()->json([
                    'statusCode' => '400', 
                    'status' => 'Failed', 
                    'message' => 'Not requested any otp'
                ]);
            }

        }
        catch(\Exception $ex)
        {
            // echo "uma madam";
            return $this->getErrorJsonResponse([], $ex->getMessage() , $ex->getCode());
        }

    }
    public function ForgotPasswordChange(Request $Request)
    {
        $validator = Validator::make($Request->all() , ['email' => 'required', 'password' => 'required|same:confirm_password', 'confirm_password' => 'required']);
        if ($validator->fails())
        {
            return response()->json([
                'statusCode' => '400', 
                'status' => 'Failed', 
                'message' => $validator->errors() 
            ]);
        }
        $email = $Request->get('email');
        $NewPassword = $Request->get('password');
        $ConfirmPassword = $Request->get('confirm_password');
        \DB::table('employees')
            ->where('email', $email)->update([
        // $Employee = Employee::where('slug', $slug)->first();
        'password' => Hash::make($Request->get('password')) , ]);
        return "sucess";

    }
    public function KnownPasswordChange(Request $Request)
    {
        $validator = Validator::make($Request->all() , [
            'email' => 'required', 
            'old_password' => 'required', 
            'newpassword' => 'required|same:confirmnewpassword', 
            'confirmnewpassword' => 'required', 
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'statusCode' => '400', 
                'status' => 'Failed', 
                'message' => $validator->errors() 
            ]);
        }
        $email = $Request->get('email');
        $old_password = $Request->get('old_password');
        $NewPassword = $Request->get('newpassword');
        $confirm_new_password = $Request->get('confirmnewpassword');
        $check_email = $this->CheckMail($email);
        if (!empty($check_email))
        {
            $check_password = $this->CheckOldPassword($old_password, $email);
            if (Hash::check($old_password, $check_password->password,) && $confirm_new_password != null && $NewPassword != null)
            {
                \DB::table('employees')->where('email', $email)->update([
                // $Employee = Employee::where('slug', $slug)->first();
                'password' => Hash::make($Request->get('newpassword')) , ]);
                return response()->json([
                    'statusCode' => '200', 
                    'status' => 'Sucess', 
                    'message' => "Password Updated Sucessfully"
                ]);
            }
            else
            {
                return response()->json([
                    'statusCode' => '400', 
                    'status' => 'Failed', 
                    'message' => "NewPassword and Old password Dosent match"
                ]);
            }
        }
        else
        {
            return response()->json([
                'statusCode' => '400', 
                'status' => 'Failed', 
                'message' => "email not found"
            ]);
        }

    }

    public function CheckMail($email)
    {
        $Identifty_mail = \DB::table('employees')->where('email', $email)->select('email', 'password')
            ->first();
        return $Identifty_mail;
    }
    public function CheckOldPassword($old_password, $email)
    {
        $CheckOldPassword = \DB::table('employees')->where('email', $email)->select('password')
            ->first();
        return $CheckOldPassword;
    }
}

