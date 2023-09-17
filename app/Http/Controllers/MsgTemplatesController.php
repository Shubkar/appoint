<?php

namespace App\Http\Controllers;

use App\AppSettings;
use App\MasterData;
use App\MsgTemplates;
use Illuminate\Http\Request;

class MsgTemplatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $templates=MsgTemplates::where('sub_id','1')->get();
        $appSettings=AppSettings::find(1);
         $consultation =AppSettings::find(2);
        $rConsultation=AppSettings::find(3);
        $pharmacistNo=AppSettings::find(4);
        $ncTime=AppSettings::find(5);
        $retakeTime=AppSettings::find(6);
        $masterData=MasterData::all();
        return view('MsgTemplates.index',compact('templates','appSettings','consultation','rConsultation','pharmacistNo','masterData','retakeTime','ncTime'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'templateType' => 'required',
            'msgTime' => 'required|integer',
            'msg' => 'required'
        ]);
        $msgTemplate=MsgTemplates::where('sub_id','1')->where('msg_type',$request->get('templateType'))->first();
        $msgTemplate->actual_msg=$request->get('msg');
        $msgTemplate->msg_time=$request->get('msgTime');
        $msgTemplate->exists=true;
        $msgTemplate->save();
        return response()->json(['success'=>'Data Saved']);
    }
}
