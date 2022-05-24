<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use JWTAuth;

class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return User::all();
        // dd(JWTAuth::user()->EmployeeId);
        return \DB::table('leavemanagement')->where('EmployeeId', JWTAuth::user()->EmployeeId)->get();
    }
    public function headings(): array
    {
        //Put Here Header Name That you want in your excel sheet 
        return [
            'S No',
            'Nature Of Leave',
            'Date Of Submission',
            'No Of Days Requested',
            'No Of Days Sanctioned',
            'No Of Days Remaining',
            'Date Of Sanctioning',
            'Deputations',
            'Remarks',
        ];
    }
}
