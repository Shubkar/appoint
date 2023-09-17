<?php

namespace App\Http\Controllers;

use App\Customer;
use App\MasterData;
use App\MsgTemplates;
use App\MyEvent;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use kcfinder\session;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function loadCustomerData($userId)
    {
        session(['selectedUserId' => $userId]);
        $user=User::find($userId);
        session(['selectedCalendarID' => $user->calendarID]);
        $query = Customer::select(DB::raw("`id`, `userId`, `name`, `caseId`, `mobile`, `email`, '' as action,'' as bookingUrl"))
        ->where('status', 1)
        ->where('userId', $userId)
        ->where('caseId','!=','NC');
       return json_encode($query->get());
    }

    public function getAllCustomers($userId,$status=1)
    {
        session(['selectedUserId' => $userId]);
        $query=Customer::select(DB::raw("`id`, `userId`, `name`, `caseId`, `mobile`, `email`,`status`, '' as action,'' as bookingUrl"))
            ->where('status',$status)
            ->where('userId',$userId)
            ->where('caseId','!=','NC');;

        return DataTables::of($query)->editColumn('action', function ($customer)
        {
            //change over here
            $action="<a href='/customers/editCustomer/".$customer->id."'
                class='btn waves-effect waves-light btn-primary' title='Edit'><i class=\"feather icon-edit\"></i></a>";
                if($customer->status==1)
                {
                    $action=$action." | "."<a href='#'
                        onclick='deleteCustomerInfo(".$customer->id.",".$customer->status.")'
                        class='btn waves-effect waves-light btn-danger' title='Inactive'><i class=\"feather
                            icon-trash-2\"></i></a>";
                }
                else
                {
                    $action=$action." | "."<a href='#'
                        onclick='deleteCustomerInfo(".$customer->id.",".$customer->status.")'
                        class='btn waves-effect waves-light btn-success' title='Activate'><i class=\"feather
                            icon-check-square\"></i></a>";
                }


            return $action;
        })
            ->editColumn('bookingUrl', function ($customer)
            {
                //change over here
                return "<a  href='#' onclick='navigateCalendar(this)' data-loadCal='https://www.google.com/calendar/render?action=TEMPLATE&text=".urlencode($customer->name."#".$customer->caseId)."&details=".urlencode($customer->mobile)."&sf=true&output=xml'><i class=\"feather icon-user-plus\"></i></a>";
            })
            ->escapeColumns([])
            ->make(true);
    }



    public function index(Request $request)
    {
        if($request->exists('errMSg'))
        {
        $errMSg=$request->get('errMSg');
         return view('Customer.index',compact('errMSg'));
        }
        else
        {
            return view('Customer.index');
        }

    }



    public function editCustomer($customerId)
    {
        try
        {
            $ethnicities=\trim(MasterData::find(1)->masterValues);
            $ethnicities=str_ireplace(array("\r","\n",'\r','\n'),',', $ethnicities);

            $ethnicities=explode(',',$ethnicities);
            if($customerId<1)
            {
                $customer=new Customer();
                $customer->id=-1;
            }
            else
            {
                $customer=Customer::where('id',$customerId)->first();
            }
            if($customer->status=0)
            {
                $errMSg="Please Select Valid Customer";
                return view('Customer.index',compact('errMSg'));
            }
            else
            {
                return view('Customer.edit',compact('customer','ethnicities'));
            }
        }
        catch (\Exception $ex)
        {
            $errMSg=$ex->getMessage();
            return view('Customer.index',compact('errMSg'));
        }
    }

    public function saveCustomer(Request $request)
    {
        try
        {
            $this->validate($request, [
                'cname' => 'required',
                'caseId' => 'required',
                'mobile' => 'required',
                'email' => '',
                'id' => 'required|integer',
                'gender'=>'',
                'age'=>'',
                'occupation'=>'',
                'refferedBy'=>'',
                'infoSharing'=>'',
                'newsLetter'=>'',
                'address'=>'',
                'ethnicity'=>'',
                'idNumber'=>'',
                'remark1'=>'',
                'remark2'=>'',
                'dateofConsultation'=>'',
            ]);
            $oldCaseId='';
            $oldMobile='';
            if($request->get('id')>0)
            {
                $customer=Customer::where('id',$request->get('id'))->first();
                $customer->exists=true;
                $oldCaseId=$customer->caseId;
                $oldMobile=$customer->mobile;
            }
            else
            {
                $customer=new Customer();
                $customer->userId=Auth::user()->id;
                $customer->status=1;
            }
            $customer->name=$request->get('cname');
            $customer->caseId=$request->get('caseId');
            $customer->mobile=$request->get('mobile');
            $customer->email=$request->get('email');

            $customer->gender=$request->get('gender');
            $customer->age=$request->get('age')==''?null:$request->get('age');
            $customer->occupation=$request->get('occupation');
            $customer->refferedBy=$request->get('refferedBy');
            $customer->infoSharing=$request->get('infoSharing');
            $customer->newsLetter=$request->get('newsLetter');
            $customer->address=$request->get('address');
            $customer->ethnicity=$request->get('ethnicity');
            $customer->idNumber=$request->get('idNumber');
            $customer->remark1=$request->get('remark1');
            $customer->remark2=$request->get('remark2');

            $user=Auth::user();
            $dateTimeString=$request->get('dateofConsultation');
            if($dateTimeString=="")
            {
                $customer->dateofConsultation=null;
            }
            else
            {
                $customer->dateofConsultation=Carbon::createFromFormat('d-m-Y', $dateTimeString, $user->uTimeZone);
            }


            $customer->save();
            if($oldCaseId!='' && $oldMobile!='' && $oldCaseId!='NC')
            {
                //update all appointment's caseId,customername and mobile number
                MyEvent::where('userId',$customer->userId)->where('caseId',$oldCaseId)->where('mobileNumber',$oldMobile)->where('caseId','!=','NC')->update(['customerName'=>$customer->name,'caseId'=>$customer->caseId,'mobileNumber'=>$customer->mobile]);
            }
            $errMSg="Success";
            return view('Customer.index',compact('errMSg'));
        }
        catch (\Exception $exception)
        {
            $errMSg=$exception->getMessage();
            return view('Customer.index',compact('errMSg'));
        }
    }

    public function deleteCustomer(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'status' => 'required|integer'
        ]);
        $customer=Customer::where('id',$request->get('id'))->first();
        $customer->status=$customer->status==1?0:1;
        $customer->exists=true;
        $customer->save();
        return response()->json(['success'=>'Data Saved']);
    }

    public function importCSV(Request $request)
    {
        $docs=User::where('takesAppointment',1)->where('status',1)->get();
        if($request->exists('errMSg'))
        {
            $errMSg=$request->get('errMSg');
            return view('Customer.importCSV',compact('errMSg','docs'));
        }
        return view('Customer.importCSV',compact('docs'));
    }

    public function postCSV(Request $request)
    {
        try
        {
            $this->validate($request, [
            'csv_file' => 'required|file',
            'txtEmployee' => 'required|integer'
            ]);

            $path = $request->file('csv_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            //$csv_data = array_slice($data, 0, 2);
            $i=0;
            DB::beginTransaction();

            foreach($data as $row)
            {
                if(\sizeof($row)==16)
                {
                    if($i>0)
                    {
                        $customer=new Customer();
                      //  $customer->userId=$request->get('txtEmployee');
                        $customer->userId=Auth::user()->id;
                        $customer->name=\trim($row[1]);
                        $customer->caseId=\trim($row[0]);
                        $customer->mobile=\trim($row[2]);
                        $customer->email=\trim($row[3])==""?null:\trim($row[3]);
                        $gender=\trim(strtolower($row[4]));
                        if($gender=='')
                        {
                            $gender='-';
                        }
                        else if($gender=='male' || $gender=='m')
                        {
                            $gender='M';
                        }
                        else
                        {
                            $gender='F';
                        }
                        $customer->gender=$gender;
                        $customer->age=\trim($row[5])==""?null:\trim($row[5]);
                        $customer->occupation=\trim($row[6])==""?null:\trim($row[6]);
                        $customer->refferedBy=\trim($row[7])==""?null:\trim($row[7]);

                        $infoSharing=strtolower(\trim($row[8]));
                        if($infoSharing=='yes' || $infoSharing=='y' || $infoSharing=='1')
                        {
                            $infoSharing='Yes';
                        }
                        else
                        {
                            $infoSharing='No';
                        }
                        $customer->infoSharing=$infoSharing;

                        $newsLetter=strtolower(\trim($row[9]));
                        if($newsLetter=='yes' || $newsLetter=='y' || $newsLetter=='1')
                        {
                        $newsLetter=1;
                        }
                        else
                        {
                        $newsLetter=0;
                        }
                        $customer->newsLetter=$newsLetter;

                        $customer->address=\trim($row[10])==""?null:\trim($row[10]);
                        $customer->ethnicity=\trim($row[11])==""?null:\trim($row[11]);
                        $customer->idNumber=\trim($row[12])==""?null:\trim($row[12]);
                        $customer->remark1=\trim($row[13])==""?null:\trim($row[13]);
                        $customer->remark2=\trim($row[14])==""?null:\trim($row[14]);


                        try
                        {
                            $customer->dateofConsultation=\trim($row[15])==""?null:Carbon::createFromFormat('d-m-Y',
                            \trim($row[15]),
                            Auth::user()->uTimeZone);
                        }
                        catch(\Exception $exIgnore)
                        {
                            $customer->dateofConsultation=null;
                        }
                        $customer->status=1;
                        if($customer->caseId!='NC')
                        {
                            $customer->save();
                        }
                    }
                }
                else
                {
                throw new \Exception('Invalid CSV File');
                }
                $i=$i+1;
            }
            DB::commit();
            return redirect()->route('customerList', ['errMSg' => "Success"]);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            $errMSg=$ex->getMessage();
            if(strpos($errMSg, 'Duplicate') != false){
                 $errMSg='Duplicate record for Mobile number and case ID pair';
            }
            else if(strpos($errMSg, 'SQL:') != false)
            {
                 $errMSg=mb_split('SQL:',$errMSg)[0];
            }
            return redirect()->route('importCSV', ['errMSg' => $errMSg]);
        }
    }

    public function updateCustomer(Request $request)
    {
        try {

            $this->validate($request, [
            'id' => 'required|integer',
            'caseId' => 'required',
            'customerName' => 'required',
            'mobileNumber' => ''
            ]);
            $appointment=MyEvent::find($request->get('id'));
            if($appointment==null)
            {
                throw new \Exception('Invalid Appointment');
            }

            if($appointment->mobileNumber!='')
            {
                $customer=Customer::where('userId',$appointment->userId)->where('mobile',$appointment->mobileNumber)->where('caseId',$appointment->caseId)->first();
                $customerCheck=Customer::where('userId',$appointment->userId)->where('mobile',$request->get('mobileNumber'))->where('caseId',$request->get('caseId'))->first();
            }
            else
            {
                $customer=null;
                $customerCheck=null;
            }

            if($request->get('caseId')=='NC')
            {
                throw new \Exception("Cannot save customer with NC case ID");

            }
            if($customerCheck==null)
            {
                //customer matching with new info is not present
                if($customer==null)
                {
                    //Old customer is also not present so we create new customer
                    $customer=new Customer();
                    $customer->status=1;
                    $customer->email="";
                    $customer->dateofConsultation=$appointment->dtStart;
                    $customer->userId=$appointment->userId;
                    $customer->name=$request->get('customerName');
                    $customer->caseId=$request->get('caseId');
                    $customer->mobile=$request->get('mobileNumber');
                    $customer->save();
                }
                else
                {
                    //update old customer info
                    $customer->caseId=$request->get('caseId');
                    $customer->name=$request->get('customerName');
                    $customer->mobile=$request->get('mobileNumber');
                    $customer->exists=true;
                    $customer->save();
                }
            }
            else
            {
                $customerCheck->name=$request->get('customerName');
                $customerCheck->exists=true;
                $customerCheck->save();
            }
            if($appointment->mobileNumber!='')
            {
                //update appointment info also
                MyEvent::where('userId',
                $appointment->userId)->where('caseId',$appointment->caseId)->where('mobileNumber',$appointment->mobileNumber)->update(['customerName'
                =>
                $request->get('customerName'),'caseId'=>$request->get('caseId'),'mobileNumber'=>$request->get('mobileNumber')]);
            }
            else
            {
                //only udpate that particular appointment
                $appointment->mobileNumber=$request->get('mobileNumber');
                $appointment->exists=true;
                $appointment->save();
            }


        }
        catch (\Exception $exception) {
        return response()->json(['error'=>$exception->getMessage()],500);
        }
        response()->json(['success'=>'Matched']);
    }
}
