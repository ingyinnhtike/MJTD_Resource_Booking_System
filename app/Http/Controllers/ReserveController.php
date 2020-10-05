<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SlotZero;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReserveController extends Controller
{
    public function index(Request $request)
    {
        
        $ajaxarray=$request->dates;
        $scheduleid=$request->scheduleid;
        $slotscheduleid=SlotZero::where('schedule_id',$scheduleid)->get();

        $date=[];
        $dateone=[];
        
        foreach($slotscheduleid as $slotscheduleids)
        {
            if($slotscheduleids->created_at !== $slotscheduleids->updated_at)
            {
                $st= Carbon::createFromFormat('Y-m-d', substr($slotscheduleids->created_at, 0, 10));
                $ed = Carbon::createFromFormat('Y-m-d', substr($slotscheduleids->updated_at, 0, 10));
                $dates = [];
                $start=Carbon::parse($st);
                $end=Carbon::parse($ed);
                while ($start->lte($end)) 
                {
                    $dates[] = $start->copy()->format('Y-m-d');
                    $start->addDay();
                }  
                $dateone[$slotscheduleids->id]=$dates;  
            }
            else
            {
                $dateone[$slotscheduleids->id]=$slotscheduleids->created_at;   
            }
        }

        $week = [];

        foreach($dateone as $key => $date_collecion)
        {
            foreach($date_collecion as $dt)
            {
                foreach($ajaxarray as $aja)
                {
                    array_push($week, $aja);
                    // $date=Carbon::parse($dt);
                    // $ajaxdate=Carbon::parse($aja);
                    // if($ajaxdate == $date)
                    // {
                    //     $response = ['id' => $key , 'sdate' =>" $ajaxarray[0]" , 'edate' => "$ajaxarray[6]"];
                    //     return $response;
                    // }
                    // else
                    // {
                    //     $response = ['id' => $aa ,'sdate' =>" $ajaxarray[0]" , 'edate' => "$ajaxarray[6]"];
                        
                    // } 
                } 
            }
        }
        return $week;
    }

    public function next(Request $request)
    {
        $nextajaxarray=$request->nextdates;
        $scheduleid=$request->scheduleid;
        $slotscheduleid=SlotZero::where('schedule_id',$scheduleid)->get();
        
        $nextdate=[];
        $nextdateone=[];
        
        foreach($slotscheduleid as $slotscheduleids)
        {
            if($slotscheduleids->created_at !== $slotscheduleids->updated_at)
            {
                    $nextstart = Carbon::createFromFormat('Y-m-d', substr($slotscheduleids->created_at, 0, 10));
                    $nextend = Carbon::createFromFormat('Y-m-d', substr($slotscheduleids->updated_at, 0, 10));
                    $nextdates = [];
                    while ($nextstart->lte($nextend)) 
                    {
                        $nextdates[] = $nextstart->copy()->format('Y-m-d');
                        $nextstart->addDay();
                    }  
                    $nextdateone[$slotscheduleids->id]=$nextdates;  
            }
            else
            {
                $nextdateone[$slotscheduleids->id]=$slotscheduleids->created_at;
            }
            
        }
        
        $week = [];
        foreach($nextdateone as $key => $nextdate_collecion)
        {
            foreach($nextdate_collecion as $nextdate)
            {
                foreach($nextajaxarray as $nextajaxdate)
                {
                    array_push($week, $nextajaxdate);
                    // if($nextdate == $nextajaxdate)
                    // {
                    //     $response = ['id' => $key , 'ndate' =>" $nextajaxarray[0]" , 'pdate' => "$nextajaxarray[6]"];
                    //     return $response;
                    // }
                    // else
                    // {
                    //     $response = ['id' => $next ,'ndate' =>" $nextajaxarray[0]" , 'pdate' => "$nextajaxarray[6]"];
                        
                    // }
                }
            }
        }
        return $week;
    }

}




