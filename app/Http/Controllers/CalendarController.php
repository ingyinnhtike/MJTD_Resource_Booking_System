<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Calendar;
use DB;
use Auth;
use Zizaco\Entrust\EntrustFacade as Entrust;

class CalendarController extends Controller
{
    public function index()
    {
        if(Entrust::hasRole("SUPER_ADMIN") ){
            $reservations=Reservation::get();
        }else {
            $reservations=DB::table('reservations')->where('owner_id',Auth::user()->id)->get();
            
        }
        
        return view('la.Calendar.index',compact('reservations'));

    }
}
