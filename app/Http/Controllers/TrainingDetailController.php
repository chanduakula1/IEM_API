<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TrainingDetail;

class TrainingDetailController extends Controller
{
    public function RegisterTraining(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'TrainingType' => 'required',
            'TrainingName' => 'required',
            'FromDate' => 'required',
            'ToDate' => 'required',
            'Duration' => 'required',
            'ConductedBy' => 'required',
            'ArrangedBy' => 'required',
            'CreatedBy' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails())
        {
            return response()->json([
                'statuscode' =>  200,
                'status' => 'Failed',
                'message' => $validator->errors(),
            ]);
        }
        $Training = new TrainingDetail;
        // dd('dzxfsdfsdf');
        $Training->TrainingType = $Request->TrainingType;
        $Training->TrainingName = $Request->TrainingName;
        $Training->FromDate = $Request->FromDate;
        $Training->ToDate = $Request->ToDate;
        $Training->Duration = $Request->Duration;
        $Training->ConductedBy = $Request->ConductedBy;
        $Training->ArrangedBy = $Request->ArrangedBy;
        $Training->CreatedBy = $Request->CreatedBy;
        $Training->IsActive = 1;
        $Training->save();
        return response()->json([
                'statuscode' => 400,
                'status' => 'Sucess',
                'message' => 'Training Data Creted Sucessfully'
        ]); 
    }
    public function TrainingDelete($value='')
    {
        // code...
    }
}
