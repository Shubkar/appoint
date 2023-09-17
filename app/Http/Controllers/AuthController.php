<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\MsgTemplates;
use App\MyEvent;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
    * Create a new AuthController instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
    * Get a JWT via given credentials.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
    * Get the authenticated User.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
    * Log the user out (Invalidate the token).
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
    * Refresh a token.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
    * Get the token array structure.
    *
    * @param string $token
    *
    * @return \Illuminate\Http\JsonResponse
    */
    protected function respondWithToken($token)
    {
        return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth('api')->factory()->getTTL() * 120,
        'country_code'=>auth('api')->user()->default_Country_Code
        ]);
    }


    public function getDoctors(Request $request)
    {
        try
        {
            return User::select('id','name')->where('takesAppointment','=',1)->where('status','=',1)->get();
        }
        catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getMessageTemplate(Request $request)
    {
        try
        {
            return MsgTemplates::select('id','msg_type','actual_msg')->find(1);
        }
        catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getAppointments(Request $request)
    {
        try {
            $this->validate($request, [
                'userId'=>'integer',
                'caseId' => '',
                'mobileNumber' => '',
                'fromDate' => '',
                'toDate' => '',
            ]);
            MyEvent::whereNull('eventId')->delete();
            $user = auth('api')->user();
            $frmDt = Carbon::now($user->uTimeZone)->addDays(1)->startOfDay();
            $toDt = Carbon::now($user->uTimeZone)->addDays(1)->endOfDay();
            $mobileNumber=$request->get('mobileNumber');
            $caseId=$request->get('caseId');
            /* if($request->get('customerId')>0)
            {
                $customer=Customer::find($request->get('customerId'));
                $mobileNumber=$customer->mobile;
                $caseId=$customer->caseId;
            } */
            if ($request->get('fromDate') != '') {
                $frmDt = Carbon::createFromFormat('d-m-Y h:i A', $request->get('fromDate') . ' 12:00 AM', $user->uTimeZone);
            }
            if ($request->get('toDate') != '') {
                $toDt = Carbon::createFromFormat('d-m-Y h:i A', $request->get('toDate') . ' 11:59 PM', $user->uTimeZone);
            }
            $query = MyEvent::leftJoin('customers', function ($join) {
                $join->on('my_events.caseId', '=', 'customers.caseId')->on('my_events.mobileNumber', '=', 'customers.mobile');
            })

            ->select(DB::raw("`my_events`.`id`,`my_events`.`customerName`,`my_events`.`caseId`,`my_events`.`mobileNumber`,`my_events`.`dtStart`,`my_events`.`invoiceNumber`"));
            if($request->get('userId')>0)
            {
                $query = $query->where('my_events.userId', $request->get('userId'));
            }
             $query = $query->where('dtStart', '>=', $frmDt);
             $query = $query->where('dtStart', '<=', $toDt);
            if($mobileNumber!='')
            {
                $query = $query->where('my_events.mobileNumber','=',$mobileNumber);
            }
            if($caseId!='')
            {
                $query = $query->where('my_events.caseId','=',$caseId);
            }
            //return $query->get();
            return $query->orderBy('dtStart','asc')->get();
        } catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
