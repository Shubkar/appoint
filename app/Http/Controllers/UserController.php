<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('Users.index');
    }

    public function getAllUsers($status=1)
    {
        $query=User::select(DB::raw("`id`, `name`, `email`, `mobile`, `userType`, `takesAppointment`, `calendarUrl`,`status`, '' as action"))
            ->where('status',$status);

        return DataTables::of($query)->editColumn('action', function ($user)
        {
            //change over here
            $action="<a href=\"/Users/editUser/".$user->id."\" class='btn waves-effect waves-light btn-primary'
                title='Edit'><i
                    class=\"feather icon-edit\"></i></a>";
                    if($user->status==0)
                    {
                        $action=$action." | "."<a href='#' onclick='deleteUserInfo(".$user->id.",".$user->status.")'
                            class='btn waves-effect waves-light btn-success' title='Activate'><i class=\"feather
                                icon-check-square\"></i></a>";
                    }
                    else
                    {
                        $action=$action." | "."<a href='#' onclick='deleteUserInfo(".$user->id.",".$user->status.")'
                            class='btn waves-effect waves-light btn-danger' title='Delete'><i class=\"feather
                                icon-trash-2\"></i></a>";
                    }


            return $action;
        })
            ->editColumn('calendarUrl', function ($user)
            {
                //change over here
                return "<a target='_blank' href='".$user->calendarUrl."'><i class=\"feather icon-eye\"></i></a>";
            })
            ->editColumn('takesAppointment', function ($user)
            {
                //change over here
                if($user->takesAppointment==1)
                {
                    return "<i class=\"feather icon-thumbs-up\"></i>";
                }
                else
                {
                    return "<i class=\"feather icon-thumbs-down\"></i>";
                }

            })
            ->escapeColumns([])
            ->make(true);
    }

    public function editUser($userId)
    {
        try
        {
            if(Auth::user()->userType!='Admin' && Auth::user()->id!=$userId)
            {
                $errMSg="Please Login as Administrator";
                return view('home',compact('errMSg'));
            }
            if($userId<1)
            {
                $user=new User();
                $user->id=-1;
            }
            else
            {
                $user=User::where('id',$userId)->first();
                $user->calendarUrl=str_replace("&amp;","&",urldecode($user->calendarUrl));
            }
            if($user->status=0)
            {
                $errMSg="Please Select Valid Employee";
                if(Auth::user()->userType=='Admin')
                {
                    return view('Users.index',compact('errMSg'));
                }else{
                    return view('home',compact('errMSg'));
                }
              //  return view('Users.index',compact('errMSg'));
            }
            else
            {
                return view('Users.edit',compact('user'));
            }
        }
        catch (\Exception $ex)
        {
            $errMSg=$ex->getMessage();
           // return view('Users.index',compact('errMSg'));
            if(Auth::user()->userType=='Admin')
            {
                return view('Users.index',compact('errMSg'));
            }else{
                return view('home',compact('errMSg'));
            }
        }
    }

    public function saveUser(Request $request)
    {
        try
        {

            $this->validate($request, [
                'uname' => 'required',
                'email' => 'required',
                'password' => '',
                'mobile' => 'required',
                'userType' => '',
                'takesAppointment' => '',
                'calendarUrl' => 'required',
                'uTimeZone' => 'required',
                'default_Country_Code' => 'required',
                'id' => 'required|integer',
                'headerImage'=>'',
                'footerImage'=>'',
                'stampImage'=>'',
                'currencyCode'=>'required|max:45',
                'calendarID' => 'required',
                'meetingID' => '',
                'modPasscode' => '',
                'participantsCode' => '',
            ]);
            if(Auth::user()->userType!='Admin' && Auth::user()->id!=$request->get('id'))
            {
                $errMSg="Please Login as Administrator";
                return view('home',compact('errMSg'));
            }
            // 'id', 'name', 'email', 'password','mobile','userType',
            //'takesAppointment','calendarUrl','default_Country_Code'
            if($request->get('id')>0)
            {
                $user=User::where('id',$request->get('id'))->first();
                $user->exists=true;
                if($request->get('password')!='')
                {
                    $user->password=Hash::make($request->get('password'));
                }
            }
            else
            {
                $user=new User();
                $user->createdBy=Auth::user()->id;
                $user->status=1;
                $user->password=Hash::make($request->get('password'));
            }
            if($request->exists('userType'))
            {
                $user->userType='Admin';
            }
            else{
                $user->userType='User';
            }
            if(Auth::user()->userType!='Admin')
            {
                $user->userType='User';
            }
            if($request->exists('takesAppointment'))
            {
                $user->takesAppointment=1;
            }
            else{
                $user->takesAppointment=0;
            }

            $user->name=$request->get('uname');
            $user->email=$request->get('email');

            $user->mobile=$request->get('mobile');
            $user->uTimeZone=$request->get('uTimeZone');
            /*$user->userType=$request->get('userType');
            $user->takesAppointment=$request->get('takesAppointment');*/
            $user->calendarID=$request->get('calendarID');
            $user->calendarUrl=$request->get('calendarUrl');
            $user->default_Country_Code=$request->get('default_Country_Code');
            $user->currencyCode=$request->get('currencyCode');
//upload header and footer image
            if ($files = $request->file('headerImage')) {
                $destinationPath = 'public/HeaderImage/'; // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                $user->headerImage='/public/HeaderImage/'.$profileImage;
            }

            if ($files = $request->file('footerImage')) {
                $destinationPath = 'public/FooterImage/'; // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                $user->footerImage='/public/FooterImage/'.$profileImage;
            }

            //
            if ($files = $request->file('stampImage')) {
                $destinationPath = 'public/stampImage/'; // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                $user->stampImage='/public/stampImage/'.$profileImage;
            }

            $user->meetingID=$request->get('meetingID');
            $user->modPasscode=$request->get('modPasscode');
            $user->participantsCode=$request->get('participantsCode');

            $user->save();

            $errMSg="Success";
            if(Auth::user()->userType=='Admin')
            {
                return view('Users.index',compact('errMSg'));
            }else{
                return view('home',compact('errMSg'));
            }

        }
        catch (\Exception $exception)
        {
            $errMSg=$exception->getMessage();

            if(Str::contains($errMSg, 'Integrity constraint violation'))
            {
                $errMSg="Email ID should be unique";
            }
            //return view('Users.index',compact('errMSg'));
            if(Auth::user()->userType=='Admin')
            {
                return view('Users.index',compact('errMSg'));
            }else{
                return view('home',compact('errMSg'));
            }
        }
    }

    public function deleteUser(Request $request)
    {
        if(Auth::user()->userType!='Admin')
        {
            $errMSg="Please Login as Administrator";
            return view('home',compact('errMSg'));
        }
        $this->validate($request, [
            'id' => 'required|integer',
            'status' => 'required|integer'
        ]);
        $user=User::where('id',$request->get('id'))->first();
        if($user->id!=Auth::user()->id)
        {
            $user->status=$request->get('status')==1?0:1;
            $user->exists=true;
            $user->save();
            return response()->json(['success'=>'Data Saved']);
        }
        else{
            return response()->json(['success'=>1]);
        }
    }

    public function checkPassword(Request $request)
    {
        $this->validate($request, [
            'inpass' => 'required',
        ]);

        $user = User::find(Auth::user()->id);
        if ($user == null || !(Hash::check($request->get('inpass'), $user->password)))
        {
            return response()->json(['error'=>'Not Matched'],400);
        }
        else
        {
            return response()->json(['success'=>'Matched']);
        }
    }

    public function getDoctors()
    {
        $employees = User::where('takesAppointment', '1')->get();
        return json_encode($employees);
    }
}
