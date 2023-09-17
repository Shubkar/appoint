<?php

namespace App\Http\Controllers;

use App\AppSettings;
use App\Customer;
use App\MessageQue;
use App\MsgTemplates;
use App\MyEvent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Spatie\GoogleCalendar\Event;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $isMob = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));

        if($isMob)
        {
            return view('home');
        }
        else
        {
            //delete records having eventId Null

            try
            {
                Session::remove('toDate');
                Session::remove('fromDate');
            }
            catch(\Exception $exI){}
            MyEvent::whereNull('eventId')->delete();
            $user=Auth::user();
            if($user->calendarID=='admin@admin.com')
            {
                return redirect('Users/editUser/1');
            }

            $this->processGServer($user, Carbon::now($user->uTimeZone)->subDays(1),Carbon::now($user->uTimeZone)->addMonths(3));
            $employees = User::where('takesAppointment', '1')->get();
            return view('Appointments.index', compact('employees'));
        }
    }

    public function getMyAppointments(Request $request)
    {
        $employees = User::where('takesAppointment', '1')->get();
        return view('Appointments.myAppointments', compact('employees'));
    }

    public function newAppointment(Request $request)
    {
        try {

            $this->validate($request, [
                'select_employee' => 'required|integer',
                'select_patient' => 'required|integer',
                'dateFrom' => 'required',
                'timeFrom' => 'required',
                'lblOnline' => '',
                'meetingID' => '',
                'modPasscode' => '',
                'participantsCode' => '',
                'lblCaseType' => 'required',
            ]);
            $sessionTime=15;
            $user = User::find($request->get('select_employee'));
            $customer = Customer::find($request->get('select_patient'));
            $dateTimeString = $request->get('dateFrom') . ' ' . $request->get('timeFrom');
            $eventTitle = $customer->name . "#" . $customer->caseId;
            if ($request->get('lblOnline') != null) {
                //$eventTitle= $eventTitle."#".$request->get('meetingID')."#".$request->get('modPasscode')."#".$request->get('participantsCode');
                $eventTitle = $eventTitle . "#ONLINE";
            }

            if($request->get('lblCaseType')=='NC')
            {
                 $ncTime=AppSettings::find(5);
                 $sessionTime=$ncTime->settingValue;
            }
            else if($request->get('lblCaseType')=='RETAKE')
            {
                $retakeTime=AppSettings::find(6);
                $sessionTime=$retakeTime->settingValue;
                 $eventTitle = $eventTitle . "#RETAKE";
            }

            $savedEvent= Event::create(['name' => $eventTitle, 'startDateTime' =>
            Carbon::createFromFormat('d-m-Y H:i', $dateTimeString, $user->uTimeZone), 'endDateTime' =>
            Carbon::createFromFormat('d-m-Y H:i', $dateTimeString, $user->uTimeZone)->addMinutes($sessionTime),'description' =>$customer->mobile], $user->calendarID);

            $this->processGServer($user, Carbon::now($user->uTimeZone)->subDays(1), Carbon::now($user->uTimeZone)->addMonths(3));
            if($savedEvent!=null)
            {

                $followupAppointment=MyEvent::where('eventId',$savedEvent->id)->orderBy('id','DESC')->first();
                $template = MsgTemplates::find(1)->actual_msg;
                $whatsappMsg = str_replace('#FIRST#', $followupAppointment->customerName, $template);
                $whatsappMsg = str_replace('#LAST#', '', $whatsappMsg);
                $whatsappMsg = str_replace('#CASE#', $followupAppointment->caseId, $whatsappMsg);
                $whatsappMsg = str_replace('#TIME#', Carbon::create($followupAppointment->dtStart)->format('l,d-m-Y h:i A'), $whatsappMsg);
                $whatsappMsg=urlencode($whatsappMsg);
            }
            $errMSg = 'Success';
        } catch (\Exception $exception) {
            $errMSg = $exception->getMessage();
            $followupAppointment=null;
            $whatsappMsg='';
        }
        $employees = User::where('takesAppointment', '1')->get();

        return view('Appointments.index', compact('errMSg', 'employees','followupAppointment','whatsappMsg'));
    }

    //quick appointment booking
    public function QuickAppointment(Request $request)
    {
    try {

    $this->validate($request, [
    'Quick_select_employee' => 'required|integer',
    'Quick_select_patient' => 'required|integer',
    'Quick_dateFrom' => 'required',
    'Quick_timeFrom' => 'required',
    'Quick_lblOnline' => 'required|integer',
    'chkQuickNewPatient' => 'required|integer',
    'Quick_enter_patient' => '',
    'Quick_enter_patientMobile' => '',
    'Quick_enter_patientCase' => '',
    'Quick_lblCaseType' => 'required',
    ]);


    $user = User::find($request->get('Quick_select_employee'));
    $description="";
    if ($request->get('chkQuickNewPatient') ==1)
    {
        $eventTitle = $request->get('Quick_enter_patient') . "#" . $request->get('Quick_enter_patientCase');
        $description=$request->get('Quick_enter_patientMobile');
    }
    else
    {
        $customer = Customer::find($request->get('Quick_select_patient'));
        $eventTitle = $customer->name . "#" . $customer->caseId;
        $description=$customer->mobile;
    }

    $dateTimeString = $request->get('Quick_dateFrom') . ' ' . $request->get('Quick_timeFrom');

    $sessionTime=15;
    if ($request->get('Quick_lblOnline') ==1) {
        $eventTitle = $eventTitle . "#ONLINE";
    }
    if($request->get('Quick_lblCaseType')=='NC')
    {
        $ncTime=AppSettings::find(5);
        $sessionTime=$ncTime->settingValue;
    }
    else if($request->get('Quick_lblCaseType')=='RETAKE')
    {
        $retakeTime=AppSettings::find(6);
        $sessionTime=$retakeTime->settingValue;
        $eventTitle = $eventTitle . "#RETAKE";
    }

    $savedEvent=Event::create(['name' => $eventTitle, 'startDateTime' =>
    Carbon::createFromFormat('d-m-Y H:i', $dateTimeString, $user->uTimeZone), 'endDateTime' =>
    Carbon::createFromFormat('d-m-Y H:i', $dateTimeString, $user->uTimeZone)->addMinutes($sessionTime), 'description'
    =>$description], $user->calendarID);
    $this->processGServer($user, Carbon::now($user->uTimeZone)->subDays(1),
    Carbon::now($user->uTimeZone)->addMonths(3));
        if($savedEvent!=null)
        {

            $followupAppointment=MyEvent::where('eventId',$savedEvent->id)->orderBy('id','DESC')->first();
            $template = MsgTemplates::find(1)->actual_msg;
            $whatsappMsg = str_replace('#FIRST#', $followupAppointment->customerName, $template);
            $whatsappMsg = str_replace('#LAST#', '', $whatsappMsg);
            $whatsappMsg = str_replace('#CASE#', $followupAppointment->caseId, $whatsappMsg);
            $whatsappMsg = str_replace('#TIME#', Carbon::create($followupAppointment->dtStart)->format('l,d-m-Y h:i A'),
            $whatsappMsg);
            $whatsappMsg=urlencode($whatsappMsg);
        }
    } catch (\Exception $exception) {
    return response()->json(['error'=>$exception->getMessage()],500);
    }
    return
    response()->json(['success'=>'Matched','followupAppointment'=>$followupAppointment->mobileNumber,'whatsappMsg' =>
    $whatsappMsg]);
    }
    //quick book ends

    public function getFromServer(Request $request)
    {
        try {

            $this->validate($request, [
                'calendarId' => 'required|integer'
            ]);
            $user = User::find($request->get('calendarId'));
            if ($user->calendarID != "") {
                $this->processGServer($user, Carbon::now($user->uTimeZone)->subDays(1), Carbon::now($user->uTimeZone)->addMonths(3));
            } else {
                throw new \Exception('Calendar ID not specified for employee');
            }
            $errMSg = 'SuccessLoad';
        } catch (\Exception $exception) {
            $errMSg = $exception->getMessage();
        }
        $employees = User::where('takesAppointment', '1')->get();
        $callingPage=$request->exists('callingPage')?$request->get('callingPage'):'MANAGE';
        if($callingPage=='MANAGE')
        {
            return redirect()->action('ReportsController@summarySheet',compact('errMSg'));
        }
        else {
            return view('Appointments.index', compact('errMSg', 'employees'));
        }
    }

    public function processGServer(User $user, Carbon $fromDate, Carbon $toDate)
    {
        //TODO Get appointments from google calendar for 3 months
        $events = Event::get($fromDate, $toDate, [], $user->calendarID);
        // dd( $events);
        try {
            // Begin Transaction

            MyEvent::where('eventStatus', 'Not Attended')->where('dtStart', '<=', Carbon::now($user->uTimeZone))->update(['eventStatus' =>
            'Attended']);

            $foundIds = array();
            $isNew = false;
            foreach ($events as $ev) {

                if ($ev->id != null) {

                    array_push($foundIds,$ev->id);
                    DB::beginTransaction();
                    $isNew = false;
                    $splitName = explode('#', trim($ev->name));
                    $oldCaseId='';
                    if (sizeof($splitName) > 1) {
                        $objAppointment = MyEvent::where('calendarAccount', $user->calendarID)->where('eventId', $ev->id)->first();

                        if ($objAppointment == null) {
                            $isNew = true;
                            $objAppointment = new MyEvent();
                            $objAppointment->appointFlag='Regular';
                            $objAppointment->exists = false;

                        } else {
                            $objAppointment->exists = true;
                             $oldCaseId=$objAppointment->caseId;
                        }


                        //take caseID till First space in the caseId Part
                        $splitName[1] = \trim(explode(' ', trim($splitName[1]))[0]);
                        $tempCaseId=strtoupper($splitName[1]);
                        $tempCaseId=str_replace('ONLINE', '',$tempCaseId);
                        $tempCaseId=str_replace('RETAKE', '',$tempCaseId);
                        $objAppointment->caseId = strtoupper(\trim($tempCaseId));
                        $objAppointment->customerName = trim($splitName[0]);

                        $objAppointment->userId = $user->id;
                        $objAppointment->eventId = $ev->id;
                        $objAppointment->calendarName = $user->calendarID;
                        $objAppointment->calendarAccount = $user->calendarID;


                        if ($objAppointment->caseId == 'NC' || $objAppointment->caseId == 'N/C' || $objAppointment->caseId == 'N\\C') {
                            $objAppointment->caseId = 'NC';
                            $objAppointment->appointFlag='NC';
                            if($oldCaseId!='' && $oldCaseId!='NC'){
                                $objAppointment->caseId=$oldCaseId;
                            }
                        }

                        $objAppointment->isOnline = 0;
                        /*if (sizeof($splitName) > 2) {
                            $objAppointment->isOnline = 1;
                            $objAppointment->meetingID = $user->meetingID;
                            $objAppointment->modPasscode = $user->modPasscode;
                            $objAppointment->participantsCode = $user->participantsCode;
                        } else if (strpos(strtoupper($splitName[1]), 'ONLINE') !== false) {
                            //this is a online case
                            $objAppointment->isOnline = 1;
                            $objAppointment->meetingID = $user->meetingID;
                            $objAppointment->modPasscode = $user->modPasscode;
                            $objAppointment->participantsCode = $user->participantsCode;
                        } else {
                            $objAppointment->meetingID = "";
                            $objAppointment->modPasscode = "";
                            $objAppointment->participantsCode = "";
                        }*/
                        //check if online case
                        if (strpos(strtoupper($ev->name), '#ONLINE') !== false) {
                            $objAppointment->isOnline = 1;
                            $objAppointment->meetingID = $user->meetingID;
                            $objAppointment->modPasscode = $user->modPasscode;
                            $objAppointment->participantsCode = $user->participantsCode;
                        }
                        //check if RETAKE
                        if (strpos(strtoupper($ev->name), '#RETAKE') !== false) {
                            $objAppointment->appointFlag = 'RETAKE';
                        }
                        $objAppointment->mobileNumber = $ev->description == null ? "" : $ev->description;
                        $objAppointment->mobileNumber=str_replace(' ','',$objAppointment->mobileNumber);
                        //check if no case ID
                        if ($objAppointment->caseId != 'NC') {
                            if ($objAppointment->mobileNumber == "") {
                                //check if we have customer with this caseId in our table if yes then take mobile number from there
                                $customer = Customer::where("caseId", $objAppointment->caseId)->first();
                                if ($customer != null) {
                                    $objAppointment->mobileNumber = $customer->mobile;
                                }
                            }
                        }
                        /*
                        Removed on 06-02-2021
                        else {
                            //if case ID is NC
                            if ($objAppointment->mobileNumber == "") {
                                //check if we have customer with this name
                                $customer = Customer::where("name", $objAppointment->customerName)->first();
                                if ($customer != null) {
                                    $objAppointment->mobileNumber = $customer->mobile;
                                }
                            }
                        }
                        */

                        $objAppointment->dtStart = $ev->startDateTime;
                        $objAppointment->dtEnd = $ev->startDateTime;
                        $objAppointment->allDay = 0;

                        $objAppointment->save();
                        if ($objAppointment->mobileNumber != "") {
                            //save contact
                            $customer=null;
                            if($objAppointment->caseId!='NC')
                            {
                                $customer = Customer::where('userId', $user->id)->where('mobile',$objAppointment->mobileNumber)->where('caseId', $objAppointment->caseId)->first();
                            }
                            //removed on 21-10-2021
                           /*  else
                            {
                                //check if we have customer matching mobile number for that user
                                $customer =Customer::where('userId',$user->id)->where('mobile',$objAppointment->mobileNumber)->first();
                            } */

                            if ($customer == null) {
                                $customer = new Customer();
                                $customer->status = 1;
                                $customer->email = "";
                                $customer->dateofConsultation = $ev->startDateTime;
                                $customer->userId = $user->id;
                                $customer->name = $objAppointment->customerName;
                                $customer->caseId = $objAppointment->caseId;
                                $customer->mobile = $objAppointment->mobileNumber;
                                if($customer->caseId!='NC')
                                {
                                    $customer->save();
                                }
                            } else {
                                $saveCustomer=false;
                                /* removed on 06-02-2021
                                if( $customer->name!=$objAppointment->customerName)
                                {
                                    $customer->name = $objAppointment->customerName;
                                    $saveCustomer=true;
                                }
                                */
                                if($customer->dateofConsultation>$ev->startDateTime)
                                {
                                    $customer->dateofConsultation = $ev->startDateTime;
                                    $saveCustomer=true;
                                }
                                if($saveCustomer)
                                {
                                        $customer->exists = true;
                                        $customer->save();
                                }
                            }
                            if ($isNew) {
                                //add to queue
                                $objAppointment = MyEvent::where('calendarAccount', $user->calendarID)->where('eventId', $ev->id)->first();
                                $msgQueue = new MessageQue();
                                $msgQueue->appointmentId = $objAppointment->id;
                                $msgQueue->templateId = 1;
                                $msgQueue->message = '';
                                $msgQueue->save();
                            }
                        }
                    }

                    DB::commit();
                }
            }


            //delete records having eventId Null
            MyEvent::whereNull('eventId')->delete();
            //delete future records that are deleted from the calendar
           MyEvent::whereNull('chiefComplaint')->whereNotIn('eventId',$foundIds)->whereDate('dtStart','>=',Carbon::now($user->uTimeZone))->delete();

            // Commit Transaction
        } catch (\Exception $ex) {
            // Rollback Transaction
            DB::rollback();
            throw $ex;
        }
    }
    public function getAppointments($userId,$customerId, $fromDate = '', $toDate = '')
    {
        //delete records having eventId Null
        MyEvent::whereNull('eventId')->delete();
        //dd($userId);
        $user = User::find($userId);
        $frmDt = Carbon::now($user->uTimeZone)->startOfDay();
        $toDt = Carbon::now($user->uTimeZone)->endOfDay();
        $gprocessNeeded = false;
         $mobileNumber='';
         $caseId='';
        if($customerId>0)
        {
            $customer=Customer::find($customerId);
            $mobileNumber=$customer->mobile;
            $caseId=$customer->caseId;
        }
        MyEvent::where('eventStatus', 'Not Attended')->where('dtStart', '<=', Carbon::now($user->uTimeZone)->startOfDay())->update(['eventStatus' =>'Attended']);
        if ($fromDate != '') {
            Session::put('fromDate', $fromDate);
            $frmDt = Carbon::createFromFormat('d-m-Y h:i A', $fromDate . ' 12:00 AM', $user->uTimeZone);
        }
        //dd(Carbon::now($user->uTimeZone)->addMonths(3));
        //get max date from table and check if to date is greater than max date then we need to get records from google server
        if ($toDate != '') {
            Session::put('toDate', $toDate);
            $toDt = Carbon::createFromFormat('d-m-Y h:i A', $toDate . ' 11:59 PM', $user->uTimeZone);
        }

        //get max date from table and check if to date is greater than max date then we need to get records from google server
        $maxAvailDate = MyEvent::select('dtStart')->where('userId', $userId)->orderBy('dtStart', 'desc')->first();
        //dd(Carbon::createFromFormat('Y-m-d H:i:s', $maxAvailDate->dtStart,$user->uTimeZone));
        if ($toDt > Carbon::createFromFormat('Y-m-d H:i:s', $maxAvailDate->dtStart, $user->uTimeZone)) {
            $gprocessNeeded = true;
        }

        /* if($frmDt!=null && $toDt!=null)
        {
           if($toDt->diffInMonths($frmDt)>=3)
           {
           $gprocessNeeded=true;
           }
        } */
        // dd($gprocessNeeded);
        if ($gprocessNeeded) {
            $this->processGServer($user, $frmDt, $toDt);
        }
        $query = MyEvent::leftJoin('customers', function ($join) {
            $join->on('my_events.caseId', '=', 'customers.caseId')
                ->on('my_events.mobileNumber', '=', 'customers.mobile');
        })
            ->select(DB::raw("`my_events`.`id`,`my_events`.`customerName`,`my_events`.`caseId`,`my_events`.`mobileNumber`,`my_events`.`dtStart`,`my_events`.`invoiceNumber`,'' as action,`customers`.`email`,dtStart as aTime"))
            ->where('my_events.userId', $userId);
        if ($fromDate != '') {

            $query = $query->where('dtStart', '>=', $frmDt);
        }
        if ($toDate != '') {

            $query = $query->where('dtStart', '<=', $toDt);
        }
       // $query = $query->where('dtStart','>=',Carbon::now($user->uTimeZone))->orderBy('dtStart');
       if($mobileNumber!='')
       {
            $query = $query->where('my_events.mobileNumber','=',$mobileNumber);
       }
       if($caseId!='')
       {
           $query = $query->where('my_events.caseId','=',$caseId);
       }
        $query = $query->orderBy('dtStart','DESC');
        return DataTables::of($query)->editColumn('action', function ($appointment) {
            //change over here
            // $action="<a href='/editAppointment/".$customer->id."'><i class=\"feather icon-edit\"></i></a>";
            $action='';
            if(Carbon::now()->startOfDay()< $appointment->dtStart)
            {
                 $action = "<a href='/appointments/editAppointment/" . $appointment->id . "' title='Edit'
                     class='btn waves-effect waves-light btn-primary'><i class=\"feather icon-edit\"></i></a>";
            }

            /* $action=$action."<a href='/appointments/deleteAppointment/".$appointment->id."' title='Delete' onclick='return confirm(\"Do you want to delete this appointment?\")'><i class=\"feather
            icon-x-circle\"></i></a> | ";
    /* $action=$action."<a href='/appointments/markAttended/".$appointment->id."' title='Mark Attended'
        onclick='return confirm(\"Do you want to attend this appointment?\")' class='btn waves-effect waves-light
        btn-success'><i class=\"feather
                    icon-check-circle\"></i></a> | ";

                     $action=$action."<a href='/appointments/folloup/".$appointment->id."' title='Setup Folloup'
                        onclick='return confirm(\"Do you want to attend this appointment and setup followup?\")'
                        class='btn waves-effect waves-light
                        btn-info'><i class=\"feather icon-repeat\"></i></a>"; */
            return $action;
        })
            ->editColumn('dtStart', function ($row) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $row->dtStart)->format('d-m-Y');
            })
            ->editColumn('aTime', function ($row) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $row->dtStart)->format('H:i');
            })
            /* ->editColumn('dtStart',function ($row){
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

    public function edit($appointmentID)
    {
        try {
            $appointment = MyEvent::find($appointmentID);
            if ($appointment == null) {
                throw new \Exception('Invalid Appointment ID');
            } else {
                $user = User::find($appointment->userId);
                if ($user != null) {
                    if ($appointment->meetingID == null || $appointment->meetingID == '') {
                        $appointment->meetingID = $user->meetingID;
                    }

                    if ($appointment->modPasscode == null || $appointment->modPasscode == '') {
                        $appointment->modPasscode = $user->modPasscode;
                    }


                    if ($appointment->participantsCode == null || $appointment->participantsCode == '') {
                        $appointment->participantsCode = $user->participantsCode;
                    }
                }
                return view('Appointments.reschedule', compact('appointment', 'user'));
            }
        } catch (\Exception $exception) {
            $errMSg = $exception->getMessage();
        }
        $employees = User::where('takesAppointment', '1')->get();

        return view('Appointments.index', compact('errMSg', 'employees'));
    }

    public function reschedule(Request $request)
    {

        try {
            $this->validate($request, [
                'customerName' => 'required',
                'caseId' => 'required',
                'mobileNumber' => 'required',
                'dtStart' => 'required',
                'dtStartTime' => 'required',
                'id' => 'required | integer',
                'lblOnline' => '',
                'meetingID' => '',
                'modPasscode' => '',
                'participantsCode' => '',
                'lblCaseType' => 'required',
            ]);
            $followupAppointment = MyEvent::find($request->get('id'));
            if ($followupAppointment == null) {
                throw new \Exception('Invalid Appointment Selected');
            } else {

                $user = User::find($followupAppointment->userId);

                if ($user->calendarID != "") {
                    $eventTitle = $request->get('customerName') . "#" . $request->get('caseId');
                    $followupAppointment->isOnline = 0;
                    $followupAppointment->meetingID = "";
                    $followupAppointment->modPasscode = "";
                    $followupAppointment->participantsCode = "";
                    if ($request->get('isOnline') != null) {
                        //$eventTitle=$eventTitle."#".$request->get('meetingID')."#".$request->get('modPasscode')."#".$request->get('participantsCode');
                        $eventTitle = $eventTitle . "#ONLINE";
                        $followupAppointment->meetingID = $request->get('meetingID');
                        $followupAppointment->modPasscode = $request->get('modPasscode');
                        $followupAppointment->participantsCode = $request->get('participantsCode');
                    }
                    $sessionTime=15;
                    if($request->get('lblCaseType')=='NC')
                    {
                        $ncTime=AppSettings::find(5);
                        $sessionTime=$ncTime->settingValue;
                    }
                    else if($request->get('lblCaseType')=='RETAKE')
                    {
                        $retakeTime=AppSettings::find(6);
                        $sessionTime=$retakeTime->settingValue;
                        $eventTitle = $eventTitle . "#RETAKE";
                    }

                    $dateTimeString = $request->get('dtStart') . ' ' . $request->get('dtStartTime');
                    $followupAppointment->customerName = $request->get('customerName');
                    $followupAppointment->caseId = $request->get('caseId');
                    $followupAppointment->mobileNumber = $request->get('mobileNumber');
                    $followupAppointment->mobileNumber =str_replace(' ','',$followupAppointment->mobileNumber);
                     $followupAppointment->appointFlag=$request->get('lblCaseType');
                    $followupAppointment->dtStart = Carbon::createFromFormat('d-m-Y H:i', $dateTimeString,$user->uTimeZone);

                    $followupAppointment->exists = true;
                    $followupAppointment->save();


                    //update google server event
                    $event = Event::find($followupAppointment->eventId, $user->calendarID);

                    $event->update(['name' => $eventTitle, 'description' =>
                    $followupAppointment->mobileNumber, 'startDateTime' => Carbon::createFromFormat(
                        'd-m-Y H:i',
                        $dateTimeString,
                        $user->uTimeZone
                    ), 'endDateTime' => Carbon::createFromFormat(
                        'd-m-Y H:i',
                        $dateTimeString,
                        $user->uTimeZone
                    )->addMinutes($sessionTime)]);

                    $this->processGServer($user, Carbon::now($user->uTimeZone)->subDays(1), Carbon::now($user->uTimeZone)->addMonths(3));
                    $errMSg = "Success";

                    $template = MsgTemplates::find(1)->actual_msg;
                    $whatsappMsg = str_replace('#FIRST#', $followupAppointment->customerName, $template);
                    $whatsappMsg = str_replace('#LAST#', '', $whatsappMsg);
                    $whatsappMsg = str_replace('#CASE#', $followupAppointment->caseId, $whatsappMsg);
                    $whatsappMsg = str_replace('#TIME#', $followupAppointment->dtStart->format('l,d-m-Y h:i A'),$whatsappMsg);
                    $whatsappMsg=urlencode($whatsappMsg);

                } else {
                    $followupAppointment=null;
                    throw new \Exception('Calendar ID not specified for employee');
                    $whatsappMsg='';
                }
            }
        } catch (\Exception $exception) {
            dd($exception);
            $followupAppointment=null;
            $errMSg = $exception->getMessage();
            $whatsappMsg='';
        }
        $employees = User::where('takesAppointment', '1')->get();

        return view('Appointments.index', compact('errMSg', 'employees','followupAppointment','whatsappMsg'));
    }

    public function deleteAppointment($appointmentID)
    {
        try {
            $appointment = MyEvent::find($appointmentID);
            if ($appointment == null) {
                throw new \Exception('Invalid Appointment Selected');
            } else {

                $user = User::find($appointment->userId);

                if ($user->calendarID != "") {
                    //update google server event
                    $event = Event::find($appointment->eventId, $user->calendarID);
                    $appointment->delete();
                    $event->delete();

                    $this->processGServer($user, Carbon::now($user->uTimeZone)->subDays(1), Carbon::now($user->uTimeZone)->addMonths(3));
                    $errMSg = "SuccessDelete";
                } else {
                    throw new \Exception("Calendar ID not defined for " . $user->name);
                }
            }
        } catch (\Exception $exception) {
            $errMSg = $exception->getMessage();
        }
        $employees = User::where('takesAppointment', '1')->get();

        return view('Appointments.index', compact('errMSg', 'employees'));
    }

    public function attendAppointment($appointmentID)
    {
        try {
            $appointment = MyEvent::find($appointmentID);
            if ($appointment == null) {
                throw new \Exception('Invalid Appointment Selected');
            } else {
                $feeObj = AppSettings::find(2);

                $appointment->eventStatus = 'Attended';
                $prevAppointment = MyEvent::where('caseId', $appointment->caseId)->where('userId', $appointment->userId)->where('eventStatus', 'Attended')->where('id', '!=', $appointment->id)->first();

                if ($prevAppointment != null) {
                    $feeObj = AppSettings::find(3);
                }
                $appointment->feeAmount = $feeObj->settingValue;
                $appointment->balancePayment = $feeObj->settingValue;
                $appointment->exists = true;
                $appointment->save();
                $errMSg = "Success";
            }
        } catch (\Exception $exception) {
            $errMSg = $exception->getMessage();
        }
        $employees = User::where('takesAppointment', '1')->get();

        return view('Appointments.index', compact('errMSg', 'employees'));
    }

    public function followup($appointmentID)
    {
        try {
            $appointment = MyEvent::find($appointmentID);
            if ($appointment == null) {
                throw new \Exception('Invalid Appointment Selected');
            } else {
                $doctor = User::find($appointment->userId);
                return view('Appointments.followup', compact('appointment', 'doctor'));
            }
        } catch (\Exception $exception) {
            $errMSg = $exception->getMessage();
            $employees = User::where('takesAppointment', '1')->get();

            return view('Appointments.index', compact('errMSg', 'employees'));
        }
    }

    public function Setfollowup(Request $request)
    {
        try {

            $this->validate($request, [
                'appointmentID' => 'required|integer',
                'dateFrom' => 'required',
                'timeFrom' => 'required',
                'lblOnline' => '',
                'meetingID' => '',
                'modPasscode' => '',
                'participantsCode' => ''
            ]);
            $oldAppointment = MyEvent::find($request->get('appointmentID'));
            $user = User::find($oldAppointment->userId);
            $dateTimeString = $request->get('dateFrom') . ' ' . $request->get('timeFrom');
            $eventTitle = $oldAppointment->customerName . "#" . $oldAppointment->caseId;
            if ($request->get('lblOnline') != null) {
                //$eventTitle=$eventTitle."#".$request->get('meetingID')."#".$request->get('modPasscode')."#".$request->get('participantsCode');
                $eventTitle = $eventTitle . "#ONLINE";
            }

            Event::create(['name' => $eventTitle, 'startDateTime' =>
            Carbon::createFromFormat('d-m-Y h:i A', $dateTimeString, $user->uTimeZone), 'endDateTime' =>
            Carbon::createFromFormat('d-m-Y h:i A', $dateTimeString, $user->uTimeZone)->addMinutes(15), 'description' =>
            $oldAppointment->mobileNumber], $user->calendarID);
            $this->processGServer($user, Carbon::now($user->uTimeZone)->subDays(1), Carbon::now($user->uTimeZone)->addMonths(3));

            MyEvent::where('id', $request->get('appointmentID'))->update(['eventStatus' =>
            'Attended']);

            $errMSg = 'Success';
        } catch (\Exception $exception) {
            $errMSg = $exception->getMessage();
        }
        $employees = User::where('takesAppointment', '1')->get();

        return view('Appointments.index', compact('errMSg', 'employees'));
    }

    public function sendMessage(Request $request)
    {
        dd($request);
    }

    public function BookPastAppointment(Request $request)
    {
        try
        {
            $this->validate($request, [
            'inpass' => 'required',
            'Quick_select_patient' => 'required|integer',
            'Quick_select_employee' => 'required|integer',
            'chkQuickNewPatient' => 'required|integer',
            'Quick_enter_patient'=>'',
            'Quick_enter_patientMobile'=>'',
            'Quick_enter_patientCase'=>'',
            'Quick_dateFrom'=>'required',
            'Quick_timeFrom'=>'required',
            'Quick_lblOnline'=>'',
            'Quick_lblCaseType'=>'',
            ]);
            $user = User::find(Auth::user()->id);
            if ($user == null || !Hash::check($request->get('inpass'), $user->password)) {
                return response()->json(['error' => 'Password do not match'], 400);
            }
            else
            {

                $oldAppointment=new MyEvent();
                if($request->get('chkQuickNewPatient')==0)
                {
                    $patient=Customer::find($request->get('Quick_select_patient'));
                    if($patient==null)
                    {
                        throw new \Exception('Invalid patient record selected');
                    }
                    $oldAppointment->customerName=$patient->name;
                    $oldAppointment->caseId=$patient->caseId;
                    $oldAppointment->mobileNumber=$patient->mobile;
                }
                else
                {
                    $oldAppointment->customerName=$request->get('Quick_enter_patient');
                    $oldAppointment->caseId=$request->get('Quick_enter_patientCase');
                    $oldAppointment->mobileNumber=$request->get('Quick_enter_patientMobile');
                }
                $oldAppointment->userId=$user->id;
                $oldAppointment->eventId=Carbon::now()->format('dmYHis');
                $oldAppointment->calendarName=$user->calendarID;
                $oldAppointment->calendarAccount=$user->calendarID;
                $dateTimeString = $request->get('Quick_dateFrom') . ' ' . $request->get('Quick_timeFrom');
                $oldAppointment->dtStart=Carbon::createFromFormat('d-m-Y H:i', $dateTimeString, $user->uTimeZone);
                $oldAppointment->dtEnd=Carbon::createFromFormat('d-m-Y H:i', $dateTimeString, $user->uTimeZone);
                $oldAppointment->allDay=0;
                $oldAppointment->chiefComplaint='';
                $oldAppointment->feeAmount=AppSettings::find(2)->settingValue;
                $oldAppointment->balancePayment=$oldAppointment->feeAmount;
                $oldAppointment->eventStatus='Attended';
                $oldAppointment->isOnline=$request->get('Quick_lblOnline');
                if($oldAppointment->isOnline==1)
                {
                    $oldAppointment->meetingID=$user->meetingID;
                    $oldAppointment->modPasscode=$user->modPasscode;
                    $oldAppointment->participantsCode=$user->participantsCode;
                }
                $oldAppointment->folloupBooked='No';

                $oldAppointment->save();
                return response()->json(['success' => 'record saved']);
            }
        }
        catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }


    }
}
