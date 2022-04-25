<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Exports\Ministry;
use App\Exports\BillsAndAdvances;
use App\Exports\CorrespondenceWithSupporters;

class ExactReportsController extends Controller
{
    public function LeaveReports()
    {
          return Excel::download(new UsersExport, 'leaves.xlsx');
    }
    public function MinistryReports()
    {
        return Excel::download(new Ministry, 'ministry.xlsx');
    }
     public function BillsAndAdvances()
    {
        return Excel::download(new BillsAndAdvances, 'BillsAndAdvances.xlsx');
    }
    public function CorrespondenceWithSupporters()
    {
        return Excel::download(new CorrespondenceWithSupporters, 'CorrespondenceWithSupporters.xlsx');
    }
}
