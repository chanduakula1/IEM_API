<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TrainingDetail;
use JWTAuth;

class FurtherStudiesAndTrainingController extends Controller
{
    public function FurtherStudiesAndTraining(Request $Request)
    {
         $validator = Validator::make($Request->all(), [
            'TrainingType' => 'required',
            'TrainingName' => 'required',
            'FromDate' => 'required',
            'ToDate' => 'required',
            'College' => 'required',
            'OtherDetails' => 'required',
            'Duration' => 'required',
            'ConductedBy' => 'required',
            'CreatedBy' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'statuscode' =>  200,
                'status' => 'Failed',
                'message' => $validator->errors(),
            ]);
        }
        $Training = new TrainingDetail;
        $Training->TrainingType = $Request->TrainingType;
        $Training->TrainingName = $Request->TrainingName;
        $Training->FromDate = $Request->FromDate;
        $Training->ToDate = $Request->ToDate;
        $Training->OtherDetails = $Request->OtherDetails;
        $Training->College = $Request->College;
        $Training->Duration = $Request->Duration;
        $Training->Place = $Request->Place;
        $Training->SponsoredBy = $Request->SponsoredBy;
        $Training->ConductedBy = $Request->ConductedBy;
        $Training->ArrangedBy = $Request->ArrangedBy;
        $Training->CreatedBy = JWTAuth::user()->EmployeeId;
        $Training->IsActive = 1;
        $Training->save();
        return response()->json([
                'statuscode' => 400,
                'status' => 'Sucess',
                'message' => 'Training Data Creted Sucessfully'
        ]);
    }
    public function InactiveFurthureStudiesAndTraining(Request $Request)
    {
        $validator = Validator::make($Request->all(),[
            'TrainingId' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'statuscode' =>  200,
                'status' => 'Failed',
                'message' => $validator->errors(),
            ]);
        }
        $Inactive = \DB::table('trainingdetails')->where('TrainingId', $Request->TrainingId)->update([
            'IsActive' => 2,
        ]);
        if($Inactive == 1)
        {
            return response()->json([
                'statuscode' => 400,
                'status' => 'Sucess',
                'message' => 'Training Data Deleted Sucessfully'
            ]);
        }
        return response()->json([
                'statuscode' => 200,
                'status' => 'Failed',
                'message' => 'Some Thing Went Wrong'
            ]);
    }
    public function FurtherStudiesAndTrainingDetails()
    {
        $FurtherStudiesAndTrainingDetails = \DB::table('trainingdetails')->where('IsActive', 1)->get();
        return response()->json([
            'statuscode' => 400,
            'status' => 'Sucess',
            'message' => 'Further Studies And Training Details',
            'data' => $FurtherStudiesAndTrainingDetails,
        ]);
    }
    public function InactiveFurtherStudiesAndTrainingDetails()
    {
        $InactiveFurtherStudiesAndTrainingDetails = \DB::table('trainingdetails')->where('IsActive', 2)->get();
        return response()->json([
            'statuscode' => 400,
            'status' => 'Sucess',
            'message' => 'Inactivated Further Studies And Training Details',
            'data' => $InactiveFurtherStudiesAndTrainingDetails,
        ]);
    }
    public function FurtherStudiesAndTrainingDetailsEdit(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'TrainingId' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'statuscode' =>  200,
                'status' => 'Failed',
                'message' => $validator->errors(),
            ]);
        }
        $FurtherStudiesAndTrainingDetails = \DB::table('trainingdetails')->where('TrainingId', $Request->TrainingId)->get();
        return response()->json([
            'statuscode' => 400,
            'status' => 'Sucess',
            'message' => 'Further Studies And Training Details',
            'data' => $FurtherStudiesAndTrainingDetails,
        ]);
    }
    public function UpdateStudiesAndTrainingDetails(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'TrainingId' => 'required',
            'TrainingType' => 'required',
            'TrainingName' => 'required',
            'FromDate' => 'required',
            'ToDate' => 'required',
            'College' => 'required',
            'OtherDetails' => 'required',
            'Duration' => 'required',
            'ConductedBy' => 'required',
            'CreatedBy' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'statuscode' =>  200,
                'status' => 'Failed',
                'message' => $validator->errors(),
            ]);
        }
        $Inactive = \DB::table('trainingdetails')->where('TrainingId', $Request->TrainingId)->update([
            'TrainingType' => $Request->TrainingType,
            'TrainingName' => $Request->TrainingName,
            'FromDate' => $Request->FromDate,
            'ToDate' => $Request->ToDate,
            'College' => $Request->College,
            'OtherDetails' => $Request->OtherDetails,
            'Duration' => $Request->Duration,
            'ConductedBy' => $Request->ConductedBy,
            'CreatedBy' => $Request->CreatedBy,
        ]);
        return response()->json([
            'statuscode' => 400,
            'status' => 'Sucess',
            'message' => 'Data Updated Sucessfully',
        ]);
    }
}
