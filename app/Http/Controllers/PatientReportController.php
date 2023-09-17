<?php

namespace App\Http\Controllers;

use App\PatientReports;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class PatientReportController extends Controller
{
    public function getPatientReports($appointmentId)
    {
        $query =
        PatientReports::selectRaw("id,appointmentId,caseId,reportUrl,'' as
        action")->where('appointmentId',$appointmentId)->where('reportStatus','Active');
            return DataTables::of($query)->editColumn('action', function ($report) {

            //change over here
            $action = "<a onclick='DeleteReport($report->id)'
                class='btn waves-effect waves-light btn-danger' style='color:#FFFFFF;'><i class=\"feather icon-trash-2\" title='Delete'></i></a>";

            return $action;
            })
            ->editColumn('reportUrl', function ($report) {

            //change over here
            $action = "<a href='".$report->reportUrl."' target='_blank'>".$report->reportUrl."</a>";

            return $action;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function deleteReport(Request $request)
    {
        $this->validate($request, [
        'id' => 'required|integer',
        ]);
        $report=PatientReports::where('id',$request->get('id'))->first();
        $report->reportStatus='Inactive';
        $report->exists=true;
        $report->save();
        return response()->json(['success'=>'Data Saved']);
    }
}
