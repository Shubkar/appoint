<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\GoogleCalendar\Event;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /* $events = Event::get(null,null,[],"sumantghadage@gmail.com");
        dd($events);
        $dumpId=0;
        $i=0;
        foreach ($events as $ev) {
            if($i==$dumpId)
            {
                dd($ev->id."  ".$ev->name);
            }
            $i++;
            
        } */
        return view('home');
    }

    public function AuthRouteAPI(Request $request){
        return $request->user();
    }

    public function login()
    {
        return redirect()->route('login');
    }
}
