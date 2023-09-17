<?php

namespace App\Http\Controllers;

use App\Customer;
use App\MyEvent;
use App\TreatementGiven;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TreatementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllTreatement($appointmentId)
    {
        $query=TreatementGiven::select(DB::raw("`id`,`medicineName`, '' as action"))
            ->where('myEventsId',$appointmentId);

        return DataTables::of($query)->editColumn('action', function ($treatement)
        {
            //change over here
            $action="<a href='#' onclick='deleteTreatement(".$treatement->id.")'><i class=\"feather icon-trash-2\"></i></a>";

            return $action;
        })
            ->escapeColumns([])
            ->make(true);
    }

    public function saveTreatement(Request $request)
    {
        try
        {
            $this->validate($request, [
                'myEventsId' => 'required|integer',
                'medicineName' => 'required|max:255'
            ]);
            $treatement=new TreatementGiven();
            $treatement->myEventsId=$request->get('myEventsId');
            $treatement->medicineName=$request->get('medicineName');
            $treatement->save();
            return response()->json(['success'=>'Data Saved']);
        }
        catch (\Exception $exception)
        {
            return response()->json(['error'=>$exception->getMessage()]);
        }
    }

    public function deleteTreatement(Request $request)
    {
        try
        {
            $this->validate($request, [
                'id' => 'required|integer'
            ]);
            $treatement=TreatementGiven::find($request->get('id'));
            $treatement->delete();
            return response()->json(['success'=>'Record Deleted']);
        }
        catch (\Exception $exception)
        {
            return response()->json(['error'=>$exception->getMessage()]);
        }
    }
}
