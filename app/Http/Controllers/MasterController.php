<?php

namespace App\Http\Controllers;

use App\MasterData;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
        'id' => 'required|integer',
        'masterValues' => 'required'
        ]);
        $masterData=MasterData::find($request->get('id'));
        $masterData->masterValues=$request->get('masterValues');
        $masterData->exists=true;
        $masterData->save();
        return response()->json(['success'=>'Data Saved']);
    }
}
