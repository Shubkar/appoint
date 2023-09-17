<?php

namespace App\Http\Controllers;

use App\MessageQue;
use App\MsgTemplates;
use App\MyEvent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function selectTemplate(Request $request)
    {
        try
        {
           $templates=MsgTemplates::all();
            $selectedIds=implode(',',$request->get('selectedIds'));
           $appointments=MyEvent::whereIn('id',$request->get('selectedIds'))->get();
          
        }
        catch(\Exception $exception)
        {
             $errMSg=$exception->getMessage();
        }
        return view('MessageQueue.index',compact('appointments','selectedIds','templates'));
    }

    public function addQueue(Request $request)
    {
        try
        {
         
             DB::beginTransaction();
             
           
            $selectedIds=$request->get('selectedIds');
            $selectedIdArray=explode(',', $selectedIds);
            $appointments=MyEvent::whereIn('id', $selectedIdArray)->get();
            $templates=MsgTemplates::all();

            $this->validate($request, [
            'select_template' => 'required|integer',
            'selectedIds' => 'required'
            ]);
           
            foreach ($appointments as $appoint) {
                $queue=new MessageQue();
                $queue->appointmentId=$appoint->id;
                $queue->templateId=$request->get('select_template');
                $queue->message='';
                $queue->sentOn=null;
                 $queue->save();
            }
            DB::commit();
            
            $errMSg="SuccessQueue";
             $employees=User::where('takesAppointment','1')->get();

             return view('Appointments.index',compact('errMSg','employees'));
        }
        catch(\Exception $exception)
        {
          DB::rollback();
           
        $errMSg=$exception->getMessage();
        
         $selectedIds=$request->get('selectedIds');
         $selectedIdArray=explode(',', $selectedIds);
         $appointments=MyEvent::whereIn('id', $selectedIdArray)->get();
         $templates=MsgTemplates::all();
          return view('MessageQueue.index',compact('appointments','selectedIds','templates','errMSg'));
        }
       
    }
}
