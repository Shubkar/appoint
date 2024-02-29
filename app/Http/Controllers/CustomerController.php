<?php

namespace App\Http\Controllers;

use App\Customer;
use App\MasterData;
use App\MsgTemplates;
use App\MyEvent;
use App\User;
use Carbon\Carbon;
use Exception;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use kcfinder\session;
use Yajra\DataTables\Facades\DataTables;
use Aws\S3\S3Client;
use Validator;

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
        $query=Customer::select(DB::raw("`id`, `userId`, `name`, `caseId`, `mobile`, `created_at`, `email`,`status`, '' as action,'' as bookingUrl"))
            ->where('status',$status)
            ->where('userId',$userId)
            ->where('caseId','!=','NC');

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
                if(!empty($customer->caseId)) {
                    $action=$action." | "."<a href='/directory/".$customer->caseId."'
                        class='btn waves-effect waves-light btn-success' title='Directory'><i class=\"feather icon-folder\"></i></a>";
                }

                $action=$action." | "."<a href='/photo/".$customer->id."'
                        class='btn waves-effect waves-light btn-warning' title='Capture profil photo'><i class=\"feather icon-camera\"></i></a>";

                $action=$action." | "."<a href='#' class='btn waves-effect waves-light btn-info' title='Upload Photo' data-id=".$customer->id." data-toggle='modal' data-target='#upload_profilePicModal'><i class=\"feather icon-camera\"></i></a>";

                $action=$action." | "."<a href='/PatientHistory/".$customer->caseId."'
                        class='btn waves-effect waves-light btn-secondary' title='Patient History'><i class=\"feather icon-user\"></i></a>";
                
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

    function photo($custId) {
        $Customer = Customer::where('id', $custId)->select('name')->first();
        return view('Customer.photo',compact('custId','Customer'));
    }

    function directory($caseId) {
        $directoryName = $caseId.'/';
        /* $s3 = Storage::disk('s3');

        if (!$s3->doesDirectoryExist(config('filesystems.disks.s3.bucket'), $folderPath)) {
            // Create the folder if it doesn't exist
            $s3->putObject([
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $folderPath,
                'Body' => '',
                'ACL' => 'public-read', // You can adjust the ACL as needed
            ]);
        } */

        $s3 = new S3Client([
            'version' => 'latest',
            'region' =>  env('AWS_DEFAULT_REGION'), // Replace with your desired AWS region
            'credentials' => [
                'key'    =>  env('AWS_ACCESS_KEY_ID'),
                'secret' =>  env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $directoryExists = $s3->doesObjectExist(env('AWS_BUCKET'), $directoryName);

        if (!$directoryExists) {
            // Create the directory by uploading an empty object with a trailing slash
            $s3->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key' => $directoryName,
                'Body' => '',
            ]);
        }
        
        $Customer = Customer::where('caseId', $caseId)->select('name')->first();

        return view('Customer.directory',compact('caseId','Customer'));
    }

    function archive() {
        return view('Customer.archive');
    }

    function PatientHistory($custId = 0) {
        try { 
            $Customer = Customer::where('caseId', $custId)->select('id','caseId','name','mobile','email','gender','age','address','ethnicity')->first();
            $Bookings = MyEvent::select(DB::raw("`customerName`,`caseId`,`mobileNumber`,`dtStart`,dtStart as
            aTime,`feeAmount`,`balancePayment`,`paymentMode`,`remarks`,`invoiceNumber`,`chiefComplaint`,`symptoms`,`dignosis`,`medicine`,`courier`,`awbNumber`,`isOnline`,`courierSent`,`folloupBooked`, `users`.`name` as `doctor`"))
            ->join('users', 'users.id', '=', 'my_events.userId')
            ->where('caseId', $custId)
            ->orderBy('my_events.created_at','DESC')
            ->get();
            return view('Customer.history',compact('custId','Bookings','Customer'));
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $ex->getMessage(),
            ], 500);
        }
    }

    function fetch_all_archive_files() {
        try {
            $files = DB::table('patient_files')->join('customers', 'patient_files.caseId', '=', 'customers.caseId')->whereNotNull('patient_files.deleted_at')->select('patient_files.*','customers.name', 'customers.caseId')->distinct('customers.name','customers.caseId')->orderBy('patient_files.created_at','desc')->get();

            foreach($files as $row) {
                $row->filepath = Storage::disk('s3')->temporaryUrl($row->caseId."/".$row->file, now()->addMinutes(30)); // Adjust the expiration time as needed
            }
            return response()->json([
                'success' => 200,
                'data' => $files,
                'message' => 'File uploaded successfully.',
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $ex->getMessage(),
            ], 500);
        }
    }

    function restorepateintFile(Request $request) {
        try { 
            DB::table('patient_files')->where('id', $request->id)->update(['deleted_at' => null]);
            return response()->json([
                'success' => 200,
                'data' => "",
                'message' => 'File Restored successfully.',
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $ex->getMessage(),
            ], 500);
        }
    }

    public function uploadpatientfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'upload_patient_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,csv|max:6048',
                'caseId' => 'required', // Add validation for caseId if needed
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all()
                ], 200);
            }

            $path = $request->file('upload_patient_file')->store($request->caseId.'/', 's3');

            DB::table('patient_files')->insert(['caseId' => $request->caseId, 'title' => $request->title, 'file' => basename($path)]);

            return response()->json([
                'success' => 200,
                'message' => 'File uploaded successfully.',
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $ex->getMessage(),
            ], 500);
        }
    }

    function uploadpatientfile_2(Request $request) {
        try {

            $path = $request->file('upload_patient_file')->store($request->caseId.'/', 's3');

            DB::table('patient_files')->insert(['caseId' => $request->caseId, 'title' => $request->title, 'file' => basename($path)]);

            return response()->json([
                'success' => 200,
                'message' => 'File uploaded successfully.',
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $ex->getMessage(),
            ], 500);
        }
    }

    function webcam_capture(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required',
                'cust_id' => 'required', // Add validation for caseId if needed
            ]);

            echo $validator->errors();

            /* if ($validator->fails()) {
                return response()->json([
                    'success' => 400,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 400);
            } */

            // $path = $request->file('image')->store('profile_photo/', 's3');

            $Customer = Customer::where('id', $request->cust_id)->update(['photo' => $request->image, 'cpatured_photo' => 1]);

            // echo 'Profile Photo uploaded successfully.';

            // return redirect()->route('/customers/editCustomer/{customerId}', ['customerId' => $request->cust_id]);
            return redirect('/customers/editCustomer/'.$request->cust_id);

        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $ex->getMessage(),
            ], 500);
        }
    }

    function UploadProfilePic(Request $request) {
        try{

            if ($request->hasFile('image')) {
                // $base64Image = base64_encode(file_get_contents($image));

                $path = $request->file('image')->store('profile_photo/', 's3');

                $Customer = Customer::where('id', $request->cust_id)->update(['photo' => basename($path), 'cpatured_photo' => 0]);
                // Save the $base64Image in your database or perform other actions
                return response()->json([
                    'success' => "200",
                    'message' => 'Profile Picture Uploaded',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded',
                ], 400);
            }

        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $ex->getMessage(),
            ], 500);
        }
    }

    function fetch_all_files(Request $request) {
        try {
            $files = DB::table('patient_files')->where('caseId', $request->caseId)->whereNULL('deleted_at')->orderBy('patient_files.created_at','desc')->get();

            foreach($files as $row) {
                $row->created_at = date("d-m-Y h:i", strtotime($row->created_at));
                $row->filepath = Storage::disk('s3')->temporaryUrl($request->caseId."/".$row->file, now()->addMinutes(30)); // Adjust the expiration time as needed
            }
            return response()->json([
                'success' => 200,
                'data' => $files,
                'message' => 'File uploaded successfully.',
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $ex->getMessage(),
            ], 500);
        }
    }

    function deletpateintFile(Request $request) {
        try { 
            DB::table('patient_files')->where('id', $request->id)->update(['deleted_at' => Carbon::now()]);
            return response()->json([
                'success' => 200,
                'data' => "",
                'message' => 'File Deleted successfully.',
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $ex->getMessage(),
            ], 500);
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
                if($customer->cpatured_photo == 0 && !empty($customer->photo)) {
                    $customer->photo = Storage::disk('s3')->temporaryUrl("profile_photo/".$customer->photo, now()->addMinutes(30));
                }
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
                    if($request->get('consult') == 1) {
                        $customer->consulted=$request->get('consult');
                    }
                    $customer->save();
                }
                else
                {
                    //update old customer info
                    $customer->caseId=$request->get('caseId');
                    $customer->name=$request->get('customerName');
                    $customer->mobile=$request->get('mobileNumber');
                    $customer->exists=true;
                    if($request->get('consult') == 1) {
                        $customer->consulted=$request->get('consult');
                    }
                    $customer->save();
                }
            }
            else
            {
                $customerCheck->name=$request->get('customerName');
                $customerCheck->exists=true;
                if($request->get('consult') == 1) {
                    $customer->consulted=$request->get('consult');
                }
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
                if($request->get('consult') == 1) {
                    $appointment->consulted=$request->get('consult');
                }
                $appointment->save();
            }


        }
        catch (\Exception $exception) {
        return response()->json(['error'=>$exception->getMessage()],500);
        }
        response()->json(['success'=>'Matched']);
    }
}
 