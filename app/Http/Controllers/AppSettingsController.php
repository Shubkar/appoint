<?php

namespace App\Http\Controllers;

use App\AppSettings;
use App\MsgTemplates;
use App\MyEvent;
use Illuminate\Http\Request;

class AppSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        try {

            $this->validate($request, [
                'settingId' => 'required|integer',
                'settingValue' => 'required'
            ]);
            if($request->get('settingId')==1)
            {
                $this->validate($request, [
                    'settingValue' => 'required|integer'
                ]);
                $usedInvoice=MyEvent::max('invoiceNumber');
                if($usedInvoice==null)
                {
                    $usedInvoice=0;
                }
                if($usedInvoice>=$request->get('settingValue'))
                {
                    throw new \Exception('We have already used invoice numbers till '. $usedInvoice . ' Please use invoice number bigger than this');
                }
            }
            $setting = AppSettings::find($request->get('settingId'));

            if ($setting != null) {
                if($setting->id==4)
                {
                    //we save pharmacist no as settingName
                    $setting->settingName = $request->get('settingValue');
                    $setting->settingValue = 0;
                }
                else
                {
                    $setting->settingValue = $request->get('settingValue');
                }
                
                $setting->exists = true;
                $setting->save();
                return response()->json(['success' => 'Data Saved']);
            } else {
                throw new \Exception('Invalid Setting');
            }
        }
        catch (\Exception $exception)
        {
            return response()->json(['error' => $exception->getMessage()],500);
        }

    }
}
