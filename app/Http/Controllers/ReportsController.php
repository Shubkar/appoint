<?php

namespace App\Http\Controllers;

use App\AppSettings;
use App\Customer;
use App\MessageQue;
use App\MsgTemplates;
use App\MyEvent;
use App\OpeningBalance;
use App\PatientReports;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function summarySheetClear(Request $request)
    {
        try
        {
        Session::put('DtFrom',Carbon::now()->format("d-m-Y"));
        Session::put('DtTO',Carbon::now()->format("d-m-Y"));
        Session::put('PatientId',0);

        }
        catch(\Exception $exI)
        {

        }
       return view('Appointments.tempLoading');
    }

    public function summarySheet(Request $request)
    {

        MyEvent::whereNull('eventId')->delete();
        $pharmacistNo = AppSettings::find(4)->settingName;
        $doctors=User::where('takesAppointment',1)->where('status',1)->get();
        $followupAppointment=null;
        $whatsappMsg='';
        $user=Auth::user();
        $appointment=new AppointmentController();
        $appointment->processGServer($user, Carbon::now($user->uTimeZone)->subDays(1),Carbon::now($user->uTimeZone)->addMonths(3));
        if ($request->exists('errMSg')) {

            $errMSg = $request->get('errMSg');
            $followupAppointmentId=$request->exists('followupAppointment')? $request->get('followupAppointment'):null;
            if($followupAppointmentId!=null)
            {
                $followupAppointment=MyEvent::find($followupAppointmentId);
                $template = MsgTemplates::find(1)->actual_msg;
                $whatsappMsg = str_replace('#FIRST#', $followupAppointment->customerName, $template);
                $whatsappMsg = str_replace('#LAST#', '', $whatsappMsg);
                $whatsappMsg = str_replace('#CASE#', $followupAppointment->caseId, $whatsappMsg);
                $whatsappMsg = str_replace('#TIME#', Carbon::create($followupAppointment->dtStart)->format('l,d-m-Y h:i A'), $whatsappMsg);
                $whatsappMsg=urlencode($whatsappMsg);
            }

            return view('Reports.summarySheet', compact('errMSg',
            'pharmacistNo','doctors','followupAppointment','whatsappMsg'));
        } else {

            return view('Reports.summarySheet', compact('pharmacistNo','doctors'));
        }
    }

    public function generateSummarysheet($dtFrom, $dtTo,$userId, $courier = null, $paid =null,$customerId=0,$followup=-1,$isonline=-1,$forFeeReport=0)
    {
        $template = MsgTemplates::find(1)->actual_msg;
        Session::put('DtFrom', Carbon::createFromFormat('Y-m-d', $dtFrom)->format('d-m-Y'));
        Session::put('DtTO', Carbon::createFromFormat('Y-m-d', $dtTo)->format('d-m-Y'));
        Session::put('PatientId', $customerId);

         Session::put('courier',$courier);
         Session::put('paid',$paid);
         Session::put('followup',$followup);
         Session::put('isonline',$isonline);



        $defaultCountryCode = Auth::user()->default_Country_Code;
        $query = MyEvent::select(DB::raw("`id`,`customerName`,`caseId`,`mobileNumber`,`dtStart`,dtStart as
        aTime,`feeAmount`,`balancePayment`,`paymentMode`,`remarks`,`invoiceNumber`, '' as
        action,`chiefComplaint`,`symptoms`,`dignosis`,`medicine`,`courier`,`awbNumber`,`isOnline`,'" . $template . "' as
        template,`courierSent`,`folloupBooked`"))

            ->whereDate('dtStart', '>=', Carbon::createFromFormat('Y-m-d', $dtFrom))
            ->whereDate('dtStart', '<=', Carbon::createFromFormat('Y-m-d', $dtTo));
            if($userId>0)
            {
                $query=$query->where('userId',$userId);
            }

            if($forFeeReport==1)
            {
                $query=$query->orderBy('paymentMode');
            }
            else
            {
                $query=$query->orderBy('dtStart');
            }

        if ($courier != null) {
            if ($courier != -1) {
                $query = $query->where('courierSent', $courier)->where('isOnline',1);
            }
        }
        if ($paid != null) {
            if ($paid == 0) {
                $query = $query->whereNotNull('invoiceNumber');
            } else if ($paid == 1) {
                $query = $query->whereNull('invoiceNumber');
            }
        }
        if($customerId>0)
        {
            $customer=Customer::find($customerId);
            if($customer!=null)
            {
                 $query = $query->where('caseId',$customer->caseId)->where('mobileNumber',$customer->mobile);
            }
        }

        if($followup ==0)
        {
            $query=$query->where('folloupBooked','No');

        }
        else if($followup==1)
        {
            $query=$query->where('folloupBooked','Yes');
        }
        if($isonline!=-1)
        {
            $query=$query->where('isOnline',$isonline);
        }
        return DataTables::of($query)->editColumn('action', function ($customer) {
            $whatsappMsg = str_replace('#FIRST#', $customer->customerName, $customer->template);
            $whatsappMsg = str_replace('#LAST#', '', $whatsappMsg);
            $whatsappMsg = str_replace('#CASE#', $customer->caseId, $whatsappMsg);
            $whatsappMsg = str_replace('#TIME#', Carbon::createFromFormat('Y-m-d H:i:s',$customer->dtStart)->format('l, d-m-Y h:i A'), $whatsappMsg);

            $invoiceMsg="Hello from HomeoCare HK LTD. Please find your invoice in the below link. https://" .
            request()->getHttpHost() . "/invoiceView?appointmentId=" . base64_encode($customer->id);

            //change over here
            $action = "<a href='/editAppointment/" . $customer->id . "' class='btn waves-effect waves-light btn-primary'><i
                    class=\"feather icon-edit\" title='Edit'></i></a>";
                    $action = $action . " | " . "<a href='#large-Modal'
                        class='btn waves-effect waves-light btn-primary openLargeModal' data-toggle='modal'
                        title='Upload Report' data-appointmentId='".$customer->id ."'
                        data-caseId='".$customer->caseId ."'
                        style='color:#FFFFFF;'><i class=\"feather
                            icon-file-plus\"
                            title='Edit'></i></a>";

            if ($customer->invoiceNumber != null) {
                $action = $action . " | " . "<a class='btn waves-effect waves-light btn-inverse' title='Send Invoice'
                    onclick=sendWhatsappMsg('" . urlencode($invoiceMsg) . "','" . str_replace(' ','',$customer->mobileNumber) . "',0) style='color:#FFFFFF;'><i
                        class=\"feather
                               icon-message-circle\"></i></a>";
            }
            if($customer->chiefComplaint!=null)
            {
                $action= $action ." | " . "<a href='/editAppointmentPayment/" . $customer->id . "'
                    class='btn waves-effect waves-light btn-primary'><i class=\"fa fa-inr\"
                        title='Edit Payment Records'></i></a>";
            }
            if($customer->dtStart<Carbon::now()) {
                $action = $action . " | " . "<a id='msg_".$customer->id."' onclick=sendWhatsappMsg('" .
                    urlencode($whatsappMsg) . "','" . str_replace(' ','',$customer->mobileNumber) . "',1)
                    class='btn waves-effect waves-light btn-success' title='Notification' style='color:#FFFFFF;'><i
                        class=\"feather icon-bell\"></i></a>";
             }
            else
            {
                $action = $action . " | " . "<a id='msg_".$customer->id."' onclick=sendWhatsappMsg('" .
                    urlencode($whatsappMsg) . "','" . str_replace(' ','',$customer->mobileNumber) . "',0)
                    class='btn waves-effect waves-light btn-success' title='Notification' style='color:#FFFFFF;'><i
                        class=\"feather icon-bell\"></i></a>";
            }
            $action = $action . " | " . "<a href='/letters/generateLetters/" . $customer->id . "'
                class='btn waves-effect waves-light btn-success' title='Letters'><i class=\"feather
                    icon-printer\"></i></a>";

            return $action;
        })
        ->editColumn('isOnline', function ($row) {
        return $row->isOnline==1 ? 'Yes':'No';
        })
        ->editColumn('courierSent', function ($row) {
            if($row->isOnline==1)
            {
                return $row->courierSent==1 ? 'Yes':'No';
            }
            else
            {
                return '';
            }
        })
            ->editColumn('dtStart', function ($row) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $row->dtStart)->format('d-m-Y');
            })
            ->editColumn('aTime', function ($row) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $row->dtStart)->format('H:i');
            })
            ->escapeColumns([])
            ->make(true);
    }


    public function getOpeningClosingBalance($dtFrom, $dtTo)
    {
        try {
            $allowEdit = false;
            if (Auth::user()->uTimeZone != null) {
                $today = Carbon::now('UTC')
                    ->setTimezone(Auth::user()->uTimeZone)->format('Y-m-d');
            } else {
                $today = Carbon::now('UTC')->format('Y-m-d');
            }
            if ($dtFrom == $dtTo && Carbon::createFromFormat('Y-m-d', $dtFrom)->format('Y-m-d') == $today) {
                $allowEdit = true;
            }

            /* $openingBalance= MyEvent::where('eventStatus','Active')
                ->whereDate('dtStart','<',Carbon::createFromFormat('Y-m-d', $dtFrom))
                ->sum('feeAmount');*/
            $openObj = OpeningBalance::where('openDate', Carbon::createFromFormat('Y-m-d', $dtFrom)->format('Y-m-d'))->first();
            $openingBalance = 0;
            if ($openObj != null) {
                $openingBalance = $openObj->openingBalance;
            }

            $totalFees = MyEvent::whereDate('dtStart', '>=', Carbon::createFromFormat('Y-m-d', $dtFrom))
                ->whereDate('dtStart', '<=', Carbon::createFromFormat('Y-m-d', $dtTo))
                ->sum('feeAmount');

            $balanceAmount = MyEvent::whereDate('dtStart', '>=', Carbon::createFromFormat('Y-m-d', $dtFrom))
                ->whereDate('dtStart', '<=', Carbon::createFromFormat('Y-m-d', $dtTo)) ->sum('balancePayment');

            $paymethod_total = MyEvent::select('paymentMode', DB::raw('SUM(feeAmount) as totalFee'))
                ->where('dtStart', '>=', Carbon::createFromFormat('Y-m-d', $dtFrom))
                ->where('dtStart', '<=', Carbon::createFromFormat('Y-m-d', $dtTo))
                ->where('paymentMode', '!=', '')
                ->groupBy('paymentMode')
                ->get();

            $closingBalance = $openingBalance + ($totalFees-$balanceAmount);
            return response()->json(array("openingBalance" => $openingBalance, "totalFees" => $totalFees,
            "closingBalance" => $closingBalance, "allowEdit" => $allowEdit, "balanceAmount"=>$balanceAmount, "paymethod_total" => $paymethod_total), 200);
        } catch (\Exception $ex) {
            return response()->json(array("error" => $ex->getMessage()), 500);
        }
    }

    public function getFeeStatus($dtFrom, $dtTo,$userId, $courier = null, $paid =null,$customerId=0,$followup=-1,$isonline=-1)
    {

        $query = MyEvent::select(DB::raw("ifnull(SUM(`feeAmount`),0) as fees,ifnull(SUM(`balancePayment`),0) as balance"))

        ->whereDate('dtStart', '>=', Carbon::createFromFormat('Y-m-d', $dtFrom))
        ->whereDate('dtStart', '<=', Carbon::createFromFormat('Y-m-d', $dtTo));

        if($userId>0)
        {
            $query=$query->where('userId',$userId);
        }
            if ($courier != null) {
            if ($courier != -1) {
            $query = $query->where('courierSent', $courier)->where('isOnline',1);
            }
            }
            if ($paid != null) {
            if ($paid == 0) {
            $query = $query->whereNotNull('invoiceNumber');
            } else if ($paid == 1) {
            $query = $query->whereNull('invoiceNumber');
            }
            }
            if($customerId>0)
            {
            $customer=Customer::find($customerId);
            if($customer!=null)
            {
            $query = $query->where('caseId',$customer->caseId)->where('mobileNumber',$customer->mobile);
            }
            }
            if($followup ==0)
            {
            $query=$query->where('folloupBooked','No');
            }
            else if($followup==1)
            {
            $query=$query->where('folloupBooked','Yes');
            }
            if($isonline!=-1)
            {
                $query=$query->where('isOnline',$isonline);
            }
            $StatusData=$query->first();

            if($StatusData->fees==null)
            {
               $StatusData->fees=0;
            }
            if($StatusData->balance==null)
            {
            $StatusData->balance=0;
            }
            return $StatusData;
    }


    public function updateOpeningBalance(Request $request)
    {
        try {
            $this->validate($request, [
                'inpass' => 'required',
                'openingBalance' => 'required',
            ]);

            $user = User::find(Auth::user()->id);
            if ($user == null || !(Hash::check($request->get('inpass'), $user->password))) {
                return response()->json(['error' => 'Password do not match'], 400);
            } else {
                if (Auth::user()->uTimeZone != null) {
                    $today = Carbon::now('UTC')
                        ->setTimezone(Auth::user()->uTimeZone)->format('Y-m-d');
                } else {
                    $today = Carbon::now('UTC')->format('Y-m-d');
                }

                $balance = OpeningBalance::updateOrCreate(
                    ['openDate' => $today],
                    ['openingBalance' => $request->get('openingBalance')]
                );

                return response()->json(['success' => 'Saved']);
            }
        } catch (\Exception $ex) {
        }
    }

    public function sendInvoice($appointmentId)
    {
        try {

            $appointment = MyEvent::find($appointmentId);
            if ($appointment == null) {
                throw new \Exception('Please select valid appointment');
            }

            $msgQue = new MessageQue();
            $msgQue->appointmentId = $appointmentId;
            $msgQue->templateId = 0;
            $msgQue->message = "Hello from HomeoCare HK LTD. Please find your invoice in the below link. " .
            request()->getHttpHost() . "/invoiceView?appointmentId=" . $appointmentId;
            $msgQue->save();
            $errMSg = "successAdded";
        } catch (\Exception $ex) {
            $errMSg = $ex->getMessage();
        }


        return view('Reports.summarySheet', compact('errMSg'));
    }

    function upload(Request $request)
    {
        try {
            $rules = array(
            'file' => 'required',
            'uploadAppointmentId' => 'required|integer',
            'uploadCaseId' => 'required'
            );

            $error = Validator::make($request->all(), $rules);

            if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
            }

            $image_code = '';
            $images = $request->file('file');
            foreach($images as $image)
            {
            $objReport=new PatientReports();

            $new_name = $image->getClientOriginalName()."_".Carbon::now()->format('YmdHis') . '.' .
            $image->getClientOriginalExtension();
            // $image->move(public_path('reports'), $new_name);
            $image->storeAs('public/Reports/',$new_name);
            //$imgName='storage/Reports/'.$new_name;
            $objReport->appointmentId=$request->get('uploadAppointmentId');
            $objReport->caseId=$request->get('uploadCaseId');
            $objReport->reportUrl='storage/Reports/'.$new_name;
            $objReport->save();
            $image_code .= '<div class="col-md-3" style="margin-bottom:24px;"><img src="/images/'.$new_name.'"
                    class="img-thumbnail" /></div>';
            }

            $output = array(
            'success' => 'Reports uploaded successfully',
            'image' => $image_code
            );
        } catch (\Exception $th) {
            throw $th;
        }

        return response()->json($output);
    }

    public function indexCLear(Request $request)
    {
        $pgName='summaryReport';
        try
        {
        Session::put('DtFrom',Carbon::now()->format("d-m-Y"));
        Session::put('DtTO',Carbon::now()->format("d-m-Y"));
        Session::put('PatientId',0);

        Session::put('courier',-1);
        Session::put('paid',-1);
        Session::put('followup',-1);
        Session::put('isonline',-1);

        }
        catch(\Exception $exI)
        {

        }
        return view('Reports.tempPaymentReport',compact('pgName'));
    }

    function index(Request $request)
    {
        $user=Auth::user();
        $appointment=new AppointmentController();
        $appointment->processGServer($user,
        Carbon::now($user->uTimeZone)->subDays(1),Carbon::now($user->uTimeZone)->addMonths(3));
        $appointment=new AppointmentController();
        $appointment->processGServer($user,Carbon::now($user->uTimeZone)->subDays(1),Carbon::now($user->uTimeZone)->addMonths(3));
        $patients=Customer::all();
        $doctors=User::where('takesAppointment',1)->where('status',1)->get();
        return view('Reports.paymentReports',compact('patients','doctors'));
    }

    public function feeReportClear(Request $request)
    {
        $pgName='FeeReport';
        try
        {
        Session::put('DtFrom',Carbon::now()->format("d-m-Y"));
        Session::put('DtTO',Carbon::now()->format("d-m-Y"));
        Session::put('PatientId',0);

        Session::put('courier',-1);
        Session::put('paid',-1);
        Session::put('followup',-1);
        Session::put('isonline',-1);

        }
        catch(\Exception $exI)
        {

        }
        return view('Reports.tempPaymentReport',compact('pgName'));
    }

    function feeReport(Request $request)
    {
        $user=Auth::user();
        $appointment=new AppointmentController();
        $appointment->processGServer($user,
        Carbon::now($user->uTimeZone)->subDays(1),Carbon::now($user->uTimeZone)->addMonths(3));
        $appointment=new AppointmentController();
        $appointment->processGServer($user,Carbon::now($user->uTimeZone)->subDays(1),Carbon::now($user->uTimeZone)->addMonths(3));
        $patients=Customer::all();
        $doctors=User::where('takesAppointment',1)->where('status',1)->get();
        return view('Reports.feesReport',compact('patients','doctors'));
    }
}
