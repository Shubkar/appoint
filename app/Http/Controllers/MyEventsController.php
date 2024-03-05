<?php

namespace App\Http\Controllers;

use App\AppSettings;
use App\Customer;
use App\Letters;
use App\MasterData;
use App\MsgTemplates;
use App\MyEvent;
use App\Payment;
use App\TreatementGiven;
use App\User;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Spatie\GoogleCalendar\Event;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Session;
use PDF;

class MyEventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllAppointments($userId)
    {
        $query=MyEvent::select(DB::raw("`id`,`customerName`,`caseId`,`mobileNumber`,`dtStart`,`invoiceNumber`, '' as action"))

            ->where('userId',$userId);

        return DataTables::of($query)->editColumn('action', function ($customer)
        {
            //change over here
           // $action="<a href='/editAppointment/".$customer->id."'><i class=\"feather icon-edit\"></i></a>";
            $action="<a href='/letters/generateLetters/".$customer->id."' class='btn btn-success btn-mini
        waves-effect waves-light'><i class=\"feather icon-printer\"></i></a>";
            return $action;
        })
           /*  ->editColumn('dtStart',function ($row){
                if(Auth::user()->uTimeZone!=null)
                {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $row->dtStart, 'UTC')
                        ->setTimezone(Auth::user()->uTimeZone);
                }
                else
                {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $row->dtStart, 'UTC');
                }

            }) */
            ->escapeColumns([])
            ->make(true);
    }

    public function editAppointment($appointmentId)
    {
        $appointment=MyEvent::find($appointmentId);
        $pharmacistNo=AppSettings::find(4)->settingName;
        $user=User::find($appointment->userId);
        $paymodes=\trim(MasterData::find(2)->masterValues);
        $paymodes=str_ireplace(array("\r","\n",'\r','\n'),',', $paymodes);

        
        $previous_follow_up = DB::table('my_events AS current_event')
            ->select('current_event.*')
            ->where('current_event.caseId', $appointment->caseId)
            ->where('current_event.dtStart', '<', now()) // Assuming now() returns the current datetime
            ->orderByDesc('current_event.dtStart')
            ->limit(1)
            ->first();

         $appointment->caseId= strtoupper(\trim($appointment->caseId));
         if($appointment->caseId=='NC' || $appointment->caseId=='N/C' || $appointment->caseId=='N\\C')
         {
            $appointment->caseId='NC';
         }

        $paymodes=explode(',',$paymodes);

        $today=Carbon::now($user->uTimeZone)->format('d-m-Y');
        $appointmentDate=Carbon::createFromFormat('Y-m-d H:i:s',
        $appointment->dtStart)->format('d-m-Y');
        $appointmentTime=Carbon::createFromFormat('Y-m-d H:i:s',
        $appointment->dtStart)->format('h:i A');
        /* if($user->uTimeZone!=null)
        {

        }
        else
        {
            $today=Carbon::now()->format('d-m-Y');
            $appointmentDate=Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart,'UTC')->format('d-m-Y');
            $appointmentTime=Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart,'UTC')->format('h:i A');
        } */
        $paidAmount=Payment::where('appointmetsId',$appointmentId)->sum('paidAmount');
        if($appointment->feeAmount==null && $paidAmount==0)
        {
            $feeObj=AppSettings::find(2);

            $prevAppointment=MyEvent::where('caseId',$appointment->caseId)->where('userId',$appointment->userId)->where('eventStatus','Attended')->where('id','!=',$appointment->id)->first();

            if($prevAppointment!=null)
            {
                $feeObj=AppSettings::find(3);
            }
            $appointment->feeAmount=$feeObj->settingValue;
        }

        $calendarUrl=User::find($appointment->userId)->calendarUrl;
        $customer = Customer::select('id')->where('caseId', $appointment->caseId)->first();
        
         return view('Appointments.edit',compact('appointment','today','appointmentDate','appointmentTime','paidAmount','calendarUrl','pharmacistNo','user','paymodes','customer','previous_follow_up'));
    }

    public function sickLeave($appointmentId)
    {

        $appointment=MyEvent::find($appointmentId);
        $doc=User::find($appointment->userId);
        return view('Appointments.Letters.sickleave',compact('appointment','doc'));
    }

    public function generateLetters($appointmentId)
    {
        $appointment=MyEvent::find($appointmentId);
        $doc=User::find($appointment->userId);
        $treatements=TreatementGiven::where('myEventsId',$appointmentId)->get();
        $receiptData=Letters::where('appointmentId',$appointmentId)->where('letterType','Receipt')->first();
        $sickLeaveData=Letters::where('appointmentId',$appointmentId)->where('letterType','Sick Leave')->first();
        $prescriptionData=Letters::where('appointmentId',$appointmentId)->where('letterType','Prescription')->first();

        if($receiptData==null)
        {

            $receiptData=new Letters();
            $receiptData->letterData="
            <div class='row'>
                <div class='col-sm-12'> <img src='". ' http://'.request()->getHttpHost(). $doc->headerImage ."'
                    style='width: 100%;' />
                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <table border='1' cellpadding='5' cellspacing='0' style='width:100%'>
                        <tbody>
                            <tr>
                                <td><strong>Patient Name:</strong> ". $appointment->customerName ."</td>
                                <td><strong>Date:</strong>
                                    ". Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart)->format('d/m/Y')
                                    ."
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Case #</strong>". $appointment->caseId ."</td>
                                <td><strong>Receipt no:</strong>". $appointment->invoiceNumber ."</td>
                            </tr>
                            <tr>
                                <td><strong>Ref Homeopathy Consultant:</strong>".$doc->name."</td>
                                <td><strong>Mode of Payment:</strong>". $appointment->paymentMode ."</td>
                            </tr>
                        </tbody>
                    </table>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <table border='1' cellpadding='5' cellspacing='0' style='width:100%'>
                        <tbody>
                            <tr>
                                <th style='background-color:#eeeeee'>SNo</th>
                                <th style='background-color:#eeeeee'>Description</th>
                                <th style='background-color:#eeeeee'>Amount</th>
                            </tr>
                            <tr>
                                <td>1</td>";
                                if(!empty($appointment->chiefComplaint) && $appointment->chiefComplaint != ".") {
                                    $receiptData->letterData .= "<td>Consultation and Homeopathy remedy Charges for ". $appointment->chiefComplaint ."</td>";
                                } else {
                                    $receiptData->letterData .= "<td>Consultation and Homeopathy remedy Charges. </td>";
                                }
                                    
                                $receiptData->letterData .= "<td>". $doc->currencyCode ." ". $appointment->feeAmount ."</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><strong>Total Amount</strong></td>
                                <td><strong>". $doc->currencyCode ." ". $appointment->feeAmount ."</strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>

                    <p><img src='". 'http://'.request()->getHttpHost(). $doc->stampImage."'/><br />
                    <span style='font-size:11pt'><span
                                style='font-family:Calibri,sans-serif'>___________________</span></span></p>

                    <p><span style='font-size:11pt'><span style='font-family:Calibri,sans-serif'>Authorized
                                Chop</span></span></p>
                    <img src='". ' http://'.request()->getHttpHost(). $doc->footerImage ."'
                    class='divFooter' />
                </div>";
        }

        if($sickLeaveData==null)
        {
        $sickLeaveData=new Letters();
        $sickLeaveData->letterData="<style>
            body {
                cursor: none;
            }
        </style>
        <div class='row'>
            <div class='col-sm-12'>
                <img src='http://".request()->getHttpHost(). $doc->headerImage ."'
                    style='width: 100%;' />
                <p style='text-align: right;'>Date:
                    ".  Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart)->format('d/m/Y') .
                "</p>
                <p style='text-align: center;'><strong><u>Sick Leave/Attendance Letter</u></strong></p>
                <p>
                    Client Name: ". $appointment->customerName ."<br /><br />
                    Case #: ". $appointment->caseId ."<br /><br />
                    To,<br /><br />
                    <strong>Whomsoever it may be concerned.</strong> <br /><br />

                    This is to confirm that above named client consulted me for homeopathy - alternative treatment for
                    his/her health condition, suffering from ". $appointment->chiefComplaint ." Symptom like
                    ". $appointment->symptoms ."<br /><br />

                    My recommendation is based on the factors indicated below:<br />
                    <ul>
                        <li>Information provided by the Client</li>
                        <li>Symptoms of Client</li>
                    </ul>

                    <br /><br /><br />

                    <p><img src='". 'http://'.request()->getHttpHost(). $doc->stampImage."'/><br />
                    <span style='font-size:11pt'><span
                                style='font-family:Calibri,sans-serif'>___________________</span></span></p>
                    Signature/Stamp<br />
                    Manisha Lakhekar – Homeopathy Consultant

                </p>
                <img src='http://".request()->getHttpHost(). $doc->footerImage."'
                    class='divFooter' />
            </div>
        </div>";
        }

        if($prescriptionData==null)
        {
            $prescriptionData=new Letters();
            $pdata="<style>
                body {
                    cursor: none;
                }
            </style>
            <div class='row'>
                <div class='col-sm-12'>
                    <img src='http://".request()->getHttpHost(). $doc->headerImage . "'
                        style='width: 100%;' />
                    <p style='text-align: right;'>Date:
                        " .Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart)->format('d/m/Y') . "
                    </p>
                    <p style='text-align: center;'><strong><u>Letter of Prescription</u></strong></p>
                    <p>
                        Client Name: ". $appointment->customerName ."<br /><br />
                        Case #: ". $appointment->caseId ."<br /><br />
                        To,<br /><br />
                        <strong>Whomsoever it may be concerned.</strong> <br /><br />

                        This is to confirm that above named client is under homeopathy treatment for his/her
                        healthcondition, suffering from ". $appointment->chiefComplaint .". We have prescribed him/her the
                        following homoeopathic remedies which he/she is carrying with his/her during her travel.<br /><br />
                        ". $appointment->medicine ."
                        <br /><br /><br />

                        <p><img src='". 'http://'.request()->getHttpHost(). $doc->stampImage."'/><br />
                        <span style='font-size:11pt'><span
                                style='font-family:Calibri,sans-serif'>___________________</span></span></p>
                        Signature/Stamp<br />
                        Manisha Lakhekar – Homeopathy Consultant

                        </p>
                        <img src='http://".request()->getHttpHost(). $doc->footerImage."' class='divFooter' />
                        </div>
                        </div>";

            $prescriptionData->letterData=$pdata;
        }
        return
        view('Appointments.letters',compact('appointment','doc','treatements','receiptData','sickLeaveData','prescriptionData'));
    }
    public function saveAppointments(Request $request)
    {
        try {
            $this->validate($request, [
                'customerName' => 'required',
                'caseId' => 'required',
                'symptoms' => '',
                'dignosis' => '',
                'feeAmount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'id' => 'required|integer',
                'paymentMode' => '',
                'remarks' => '',
                'todayDate'=>'required',
                'chiefComplaint' => 'required',
                'awbNumber' =>'',
                'courier' =>'',
                'amountPaid' => 'required',
                'medicine' => '',
                'dateFrom' => '',
                'timeFrom' => '',
                'meetingID' => '',
                'modPasscode' => '',
                'participantsCode' => '',
                'lblOnline' => '',
                'courierSent' => '',
                'confirmReceived' => '',
                'mobileNumber' => ''
            ]);
            if($request->get('todayDate')!='matchedPassword')
            {
                throw new \Exception('Please validate before updating');
            }
if($request->get('amountPaid')<0)
{
    throw new \Exception('Amount paid should not be less than zero');
}

if($request->get('feeAmount')<0)
{
    throw new \Exception('Fee Amount should not be less than zero');
}


            $appointment=MyEvent::find($request->get('id'));
            $appointment->exists=true;

            $appointment->caseId= strtoupper(\trim($appointment->caseId));
            //$appointment->caseId= \trim(str_replace('ONLINE','',strtoupper($appointment->caseId)));
            $oldNumber=$appointment->mobileNumber;
            $appointment->mobileNumber=$request->get('mobileNumber');
            $appointment->mobileNumber=str_replace(' ','',$appointment->mobileNumber);
            //if($appointment->caseId=='NC' || $appointment->caseId=='N/C' || $appointment->caseId=='N\\C')
            //{
                //update customer info also
                if($appointment->mobileNumber!="" )
                {

                    //check if we have customer with this caseId in our table if yes then take mobile number from there
                    $customer=Customer::where('userId',$appointment->userId)->where('mobile',$oldNumber)->where('caseId',$appointment->caseId)->first();
                    $customerCheck=Customer::where('userId',$appointment->userId)->where('mobile',$request->get('mobileNumber'))->where('caseId',$request->get('caseId'))->first();
                    if($customerCheck==null)
                    {
                        if($customer!=null)
                        {
                        $customer->caseId=$request->get('caseId');
                        $customer->name=$request->get('customerName');
                        $customer->mobile=$appointment->mobileNumber;
                        $customer->exists=true;
                        $customer->save();
                        }
                        else
                        {
                        $customer=new Customer();
                        $customer->status=1;
                        $customer->email="";
                        $customer->dateofConsultation=$appointment->dtStart;
                        $customer->userId=$appointment->userId;
                        $customer->name=$request->get('customerName');
                        $customer->caseId=$request->get('caseId');
                        $customer->mobile=$appointment->mobileNumber;
                        $customer->save();

                        }
                    }
                }
                 $appointment->caseId=$request->get('caseId');
                 $appointment->customerName=$request->get('customerName');
           // }

            $appointment->symptoms=$request->get('symptoms');
            $appointment->dignosis=$request->get('dignosis');
            $appointment->feeAmount=$request->get('feeAmount');
            $appointment->paymentMode=$request->get('paymentMode');
            $appointment->chiefComplaint=$request->get('chiefComplaint');
            $appointment->medicine=$request->get('medicine');
            /* if($request->get('feeAmount')>0)
            {
                $messages = array(
                    'required' => 'The :attribute field is required.',
                );
                $this->validate($request, array(
                    'customerName' => 'required',
                    'caseId' => 'required',
                    'symptoms' => 'required',
                    'dignosis' => 'required',
                    'chiefComplaint' => 'required',
                    'feeAmount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                    'id' => 'required|integer',
                    'paymentMode' => '',
                    'remarks' => '',
                    'todayDate'=>'required',
                    'chiefComplaint' => 'required',
                    'awbNumber' =>'',
                    'courier' =>''
                ),$messages);




            } */
            $PreviouspaidAmount=Payment::where('appointmetsId',$request->get('id'))->sum('paidAmount');
            $appointment->customerName=$request->get('customerName');
            $appointment->remarks=$request->get('remarks');
             $appointment->courier=$request->get('courier');
              $appointment->awbNumber=$request->get('awbNumber');
              $appointment->balancePayment=($request->get('feeAmount')-$PreviouspaidAmount-$request->get('amountPaid'));
               $appointment->eventStatus='Attended';
              if($appointment->balancePayment==0 && $appointment->invoiceNumber==null)
              {
                  $invoiceNumber=MyEvent::max('invoiceNumber');
                  if($invoiceNumber==null || $invoiceNumber==0)
                  {
                  $invoiceNumber=AppSettings::find(1)->settingValue;
                  }
                  else{
                  $invoiceNumber=$invoiceNumber+1;
                  }
                  $appointment->invoiceNumber=$invoiceNumber;
              }
              if($request->get('courierSent')!=null)
              {
                  $appointment->courierSent=1;
              }
              $appointment->confirmReceived=$request->get('confirmReceived')==null?0:$request->get('confirmReceived');
              try
              {
              //DB::beginTransaction();
              //check if followup is booked
              if($request->get('dateFrom')!="" && $request->get('timeFrom')!="")
              {
                $appointment->folloupBooked='Yes';
              }
              $bPayment=($request->get('feeAmount')-$PreviouspaidAmount-$request->get('amountPaid'));
              if($bPayment<0)
              {
                   throw new \Exception('Fee Amount should not be less than zero');
              }
            $appointment->save();
            if($request->get('amountPaid')>0 && $bPayment>=0)
            {
            $payment=new Payment();
            $payment->appointmetsId=$request->get('id');
            $payment->paidAmount=$request->get('amountPaid');
            $payment->save();
            }

            $followupAppointment=null;
            //check if followup appointment is set
             $eventTitle= $request->get('customerName')."#".$request->get('caseId');

             if($request->get('lblOnline')!=null)
             {
                //$eventTitle= $eventTitle."#".$request->get('meetingID')."#".$request->get('modPasscode')."#".$request->get('participantsCode');
                 $eventTitle= $eventTitle."#ONLINE";
             }
             if($request->get('dateFrom')!="" && $request->get('timeFrom')!="")
             {
$dateTimeString=$request->get('dateFrom').' '.$request->get('timeFrom');

$user=User::find($appointment->userId);
$dtStart=Carbon::createFromFormat('d-m-Y h:i A', $dateTimeString, $user->uTimeZone);
$dtEnd=Carbon::createFromFormat('d-m-Y h:i A', $dateTimeString, $user->uTimeZone)->addMinutes(15);
$originalDate=Carbon::createFromFormat('d-m-Y h:i A', $dateTimeString, $user->uTimeZone);
Event::create([ 'name' =>$eventTitle, 'startDateTime' =>$dtStart, 'endDateTime' =>
$dtEnd,'description'
=>
$request->get('mobileNumber')
], $user->calendarID);
$appController=new AppointmentController();

$appController->processGServer($user,Carbon::now($user->uTimeZone)->subDays(1),$dtStart->addDays(3));
$followupAppointment=MyEvent::where('userId',$appointment->userId)->where('caseId',$appointment->caseId)->where('dtStart',$originalDate)->first();
if($followupAppointment!=null)
{
    $followupAppointment=$followupAppointment->id;
}

             }


            //DB::commit();

            $errMSg="Success";
            //$whatsappMsg=null;


           /* $employees=User::where('takesAppointment','1')->get();
            return view('Appointments.myAppointments',compact('employees','errMSg'));*/
           // redirect()->back()->with('errMSg', $errMSg);
            return redirect()->action('ReportsController@summarySheet',['errMSg' =>
            $errMSg,'followupAppointment'=>$followupAppointment]);
              }
              catch(\Exception $ex)
              {
                   //DB::rollback();
                   throw $ex;
              }
        }
        catch (\Exception $exception)
        {

            $errMSg=$exception->getMessage();
            if (strpos($errMSg, 'data was invalid') !== false) {
                $errMSg="Please enter numeric value for Fee Amount as well as cheif complaint are also required";
            }
            /*$employees=User::where('takesAppointment','1')->get();
            return view('Appointments.myAppointments',compact('employees','errMSg'));*/
            return redirect()->action('ReportsController@summarySheet',['errMSg' => $errMSg]);
        }
    }

    /* public function showInvoice(Request $request)
    {
        $appointment=MyEvent::find($request->get('appointmentId'));

        $doc=User::find($appointment->userId);

        $treatements=TreatementGiven::where('myEventsId',$request->get('appointmentId'))->get();
        $pdf = PDF::loadView('Appointments.invoiceView',compact('appointment','doc','treatements'));
        return $pdf->stream($appointment->id.' '.$appointment->customerName.'.pdf');
    } */


    public function changeAppointmentType($appointmentId)
    {
        try
        {

            $appointment=MyEvent::find($appointmentId);
            if($appointment->isOnline==1)
            {
                $appointment->isOnline=0;
            }
            else
            {
                $appointment->isOnline=1;
            }
            $appointment->exists=true;
            $appointment->save();
            return redirect()->action('MyEventsController@editAppointment',['appointmentId' => $appointmentId]);
        }
        catch(\Exception $ex)
        {
            return redirect()->action('ReportsController@summarySheet',['errMSg' => $ex->getMessage()]);
        }
    }

    public function editPayment($appointmentId)
    {
        $appointment=MyEvent::find($appointmentId);
        $user=User::find($appointment->userId);
        $paymodes=\trim(MasterData::find(2)->masterValues);
        $paymodes=str_ireplace(array("\r","\n",'\r','\n'),',', $paymodes);

        $appointment->caseId= strtoupper(\trim($appointment->caseId));
        if($appointment->caseId=='NC' || $appointment->caseId=='N/C' || $appointment->caseId=='N\\C')
        {
            $appointment->caseId='NC';
        }

        $paymodes=explode(',',$paymodes);

        $today=Carbon::now($user->uTimeZone)->format('d-m-Y');
        $appointmentDate=Carbon::createFromFormat('Y-m-d H:i:s',
        $appointment->dtStart)->format('d-m-Y');
        $appointmentTime=Carbon::createFromFormat('Y-m-d H:i:s',
        $appointment->dtStart)->format('h:i A');
        /* if($user->uTimeZone!=null)
        {

        }
        else
        {
        $today=Carbon::now()->format('d-m-Y');
        $appointmentDate=Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart,'UTC')->format('d-m-Y');
        $appointmentTime=Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart,'UTC')->format('h:i A');
        } */
        $paidAmount=Payment::where('appointmetsId',$appointmentId)->sum('paidAmount');
        if($appointment->feeAmount==null && $paidAmount==0)
        {
            $feeObj=AppSettings::find(2);

            $prevAppointment=MyEvent::where('caseId',$appointment->caseId)->where('userId',$appointment->userId)->where('eventStatus','Attended')->where('id','!=',$appointment->id)->first();

            if($prevAppointment!=null)
            {
            $feeObj=AppSettings::find(3);
            }
            $appointment->feeAmount=$feeObj->settingValue;
        }

        $calendarUrl=User::find($appointment->userId)->calendarUrl;

        return
        view('Appointments.editPayment',compact('appointment','today','appointmentDate','appointmentTime','paidAmount','calendarUrl','user','paymodes'));
    }

    public function getAppointmentPayment($appointmentId)
    {
        $query = Payment::selectRaw("id,appointmetsId,paidAmount,created_at,'' as action")->where('appointmetsId',$appointmentId);
        return DataTables::of($query)->editColumn('action', function ($record) {

        //change over here
        $action = "<a onclick='deletePayment(".$record->id.")' class='btn waves-effect waves-light btn-danger'
            style='color:#FFFFFF;'><i class=\"feather icon-trash-2\" title='Delete'></i></a>";

        return $action;
        })
        ->editColumn('created_at', function ($record) {
            return Carbon::createFromFormat('Y-m-d H:i:s',$record->created_at)->format('d-m-Y');
        })
        ->escapeColumns([])
        ->make(true);
    }

    public function deleteAppointmentPayment(Request $request)
    {
       try
       {
            $this->validate($request, [
            'id' => 'required|integer',
            ]);
            $payment=Payment::find($request->get('id'));
            $appointment=MyEvent::find($payment->appointmetsId);
            if($appointment==null)
            {
                throw new \Exception('Invalid Appointment');
            }
            DB::beginTransaction();
            $appointment->balancePayment=$appointment->balancePayment+$payment->paidAmount;
            $payment->delete();
            $appointment->save();
            DB::commit();
            return response()->json(['success'=>'Data Saved']);
       }
       catch(\Exception $ex)
       {
           DB::rollBack();
           return response()->json(['error'=>$ex->getMessage()]);
       }
    }

    public function saveAppointmentPayment(Request $request)
    {
    try {
    $this->validate($request, [
    'feeAmount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
    'id' => 'required|integer',
    'paymentMode' => '',
    'remarks' => '',
    'amountPaid' => 'required',
    'confirmReceived' => '',
    ]);
    if($request->get('amountPaid')<0) { throw new \Exception('Amount paid should not be less than zero'); }
        if($request->get('feeAmount')<0) { throw new \Exception('Fee Amount should not be less than zero'); }
            $appointment=MyEvent::find($request->get('id'));
            $appointment->exists=true;


            $appointment->feeAmount=$request->get('feeAmount');
            $appointment->paymentMode=$request->get('paymentMode');

            $PreviouspaidAmount=Payment::where('appointmetsId',$request->get('id'))->sum('paidAmount');

            $appointment->remarks=$request->get('remarks');

            $appointment->balancePayment=($request->get('feeAmount')-$PreviouspaidAmount-$request->get('amountPaid'));

            if($appointment->balancePayment==0 && $appointment->invoiceNumber==null)
            {
                $invoiceNumber=MyEvent::max('invoiceNumber');
                if($invoiceNumber==null || $invoiceNumber==0)
                {
                    $invoiceNumber=AppSettings::find(1)->settingValue;
                }
                else{
                    $invoiceNumber=$invoiceNumber+1;
                }
                $appointment->invoiceNumber=$invoiceNumber;
            }
            $appointment->confirmReceived=$request->get('confirmReceived')==null?0:$request->get('confirmReceived');
            try
            {

            $bPayment=($request->get('feeAmount')-$PreviouspaidAmount-$request->get('amountPaid'));
            if($bPayment<0) { throw new \Exception('Fee Amount should not be less than zero'); } $appointment->save();
                if($request->get('amountPaid')>0 && $bPayment>=0)
                {
                    $payment=new Payment();
                    $payment->appointmetsId=$request->get('id');
                    $payment->paidAmount=$request->get('amountPaid');
                    $payment->save();
                }
                $errMSg="Success";
                return redirect()->action('ReportsController@summarySheet',['errMSg' => $errMSg]);
                }
                catch(\Exception $ex)
                {
                //DB::rollback();
                throw $ex;
                }
                }
                catch (\Exception $exception)
                {

                $errMSg=$exception->getMessage();
                    if (strpos($errMSg, 'data was invalid') !== false) {
                        $errMSg="Please enter numeric value for Fee Amount";
                    }
                return redirect()->action('ReportsController@summarySheet',['errMSg' => $errMSg]);
                }
                }
}
