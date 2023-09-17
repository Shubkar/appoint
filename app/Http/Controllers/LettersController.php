<?php

namespace App\Http\Controllers;

use App\Letters;
use App\MyEvent;
use App\TreatementGiven;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LettersController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    public function saveLettersData(Request $request)
    {
        try
        {
            $this->validate($request, [
            'letterTypeData' => 'required',
            'letterData' => 'required',
            'appointmentId' => 'required|integer',
            ]);
            $letterData=Letters::where('appointmentId',$request->get('appointmentId'))->where('letterType',$request->get('letterTypeData'))->first();
            if($letterData!=null)
            {
                $letterData->exists=true;
            }
            else
            {
                $letterData=new Letters();
                $letterData->appointmentId=$request->get('appointmentId');
                $letterData->letterType=$request->get('letterTypeData');
            }
            $letterData->letterData=$request->get('letterData');
            
            $letterData->save();
            $errMSg="Success";
        }
        catch(\Exception $ex)
        {
            $errMSg=$ex->getMessage();
        }
        
        $appointment=MyEvent::find($request->get('appointmentId'));
        $doc=User::find($appointment->userId);
        $appointmentId=$request->get('appointmentId');
        $treatements=TreatementGiven::where('myEventsId',$request->get('appointmentId'))->get();
        $receiptData=Letters::where('appointmentId',$appointmentId)->where('letterType','Receipt')->first();
        $sickLeaveData=Letters::where('appointmentId',$appointmentId)->where('letterType','Sick Leave')->first();
        $prescriptionData=Letters::where('appointmentId',$appointmentId)->where('letterType','Prescription')->first();
        if($receiptData==null)
        {
        $receiptData=new Letters();
        $receiptData->letterData="<div class='row'>
            <div class='col-sm-12'>
                <img src='"."http://".request()->getHttpHost(). $doc->headerImage. "' style='width: 100%;' />
                <p style='text-align: right;'>Date:
                    ". Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart)->format('d/m/Y') . "
                </p>
                <p style='text-align: center;'><strong><u>Certificate of attendance</u></strong></p>
                <p>
                    Client Name: ". $appointment->customerName . "<br /><br />
                    Case #: " . $appointment->caseId . "<br /><br />
                    To,<br /><br />
                    <strong>Whomsoever it may be concerned.</strong> <br /><br />

                    This is to certify that above named client consulted me for homeopathy - alternative treatment
                    for his health condition, suffering from " . $appointment->chiefComplaint ." Symptom like
                    ". $appointment->symptoms ."<br /><br />

                    My recommendation is based on the factors indicated below:<br />
                    <ul>
                        <li>Information provided by the Client</li>
                        <li>Symptoms of Client</li>
                    </ul>

                    <br /><br /><br />


                    Signature/Stamp<br />
                    Manisha Lakhekar – Homeopathy Consultant

                </p>
                <img src='". "http://".request()->getHttpHost(). $doc->footerImage ."' class='divFooter' />
            </div>
        </div>";
        }

        if($sickLeaveData==null)
        {
        $sickLeaveData=new Letters();
        $sickLeaveData->letterData="<div class='row'>
            <div class='col-sm-12'>
                <img src='http://".request()->getHttpHost(). $doc->headerImage ."' style='width: 100%;' />
                <p style='text-align: right;'>Date:
                    ". Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart)->format('d/m/Y') .
                    "</p>
                <p style='text-align: center;'><strong><u>Sick Leave Letter</u></strong></p>
                <p>
                    Client Name: ". $appointment->customerName ."<br /><br />
                    Case #: ". $appointment->caseId ."<br /><br />
                    To,<br /><br />
                    <strong>Whomsoever it may be concerned.</strong> <br /><br />

                    This is to certify that above named client consulted me for homeopathy - alternative treatment for
                    his health condition, suffering from ". $appointment->chiefComplaint ." Symptom like
                    ". $appointment->symptoms ."<br /><br />

                    My recommendation is based on the factors indicated below:<br />
                    <ul>
                        <li>Information provided by the Client</li>
                        <li>Symptoms of Client</li>
                    </ul>

                    <br /><br /><br />


                    Signature/Stamp<br />
                    Manisha Lakhekar – Homeopathy Consultant

                </p>
                <img src='http://".request()->getHttpHost(). $doc->footerImage."' class='divFooter' />
            </div>
        </div>";
        }

        if($prescriptionData==null)
        {
        $prescriptionData=new Letters();
        $pdata="<div class='row'>
            <div class='col-sm-12'>
                <img src='http://".request()->getHttpHost(). $doc->headerImage . "' style='width: 100%;' />
                <p style='text-align: right;'>Date:
                    " .Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart)->format('d/m/Y') . "
                </p>
                <p style='text-align: center;'><strong><u>Letter of Prescription</u></strong></p>
                <p>
                    Client Name: ". $appointment->customerName ."<br /><br />
                    Case #: ". $appointment->caseId ."<br /><br />
                    To,<br /><br />
                    <strong>Whomsoever it may be concerned.</strong> <br /><br />

                    This is to certify that above named client is under homeopathy treatment for his/her
                    healthcondition, suffering from ". $appointment->chiefComplaint .". We have prescribed herthe
                    following homoeopathic remedies which she is carrying with her during her travel.<br /><br />
                    ". $appointment->medicine ."
                    <br /><br /><br />


                    Signature/Stamp<br />
                    Manisha Lakhekar – Homeopathy Consultant

                </p>
                <img src='http://".request()->getHttpHost(). $doc->footerImage."' class='divFooter' />
            </div>
        </div>";

        $prescriptionData->letterData="<style>body {cursor: none;}</style>".$pdata;
        }
        return
        view('Appointments.letters',compact('errMSg','appointment','doc','treatements','receiptData','sickLeaveData','prescriptionData'));
    }
}
