<?php

namespace App\Http\Controllers\LA;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\SlotOne;
use App\SlotZero;

class StoreDataController extends Controller
{
    
    // start for same days 
    public function store(Request $request) {

        if(isset($request)){
            $slots = $request->get('slots');
            $start = $request->get('start');
            $end = $request->get('end');
            $schedule_id = $request->get('schedule_id');

            $start_time = strtotime($start);
            $end_time = strtotime($end);
            $slot = strtotime(date('H:i',$start_time) . '+' . $slots . 'minutes');

            $data = [];

            for ($i=0; $slot <= $end_time; $i++) { 

                $data[$i] = [ 
                    'start' => date('H:i', $start_time),
                    'end' => date('H:i', $slot),
                ];

                $start_time = $slot;
                $slot = strtotime(date('H:i',$start_time). '+' . $slots . 'minutes');
            }

            session()->put('data', $data);

            return response()->json([
                'data' => $data
            ]);
            // return back();
            // return redirect(config('laraadmin.adminRoute') . "/all_schedules/show/$schedule_id");
        }  
    } // end for same days 


    //start for custom days
    public function store_0(Request $request) {

        if(isset($request)){
            // $hide = $request->get('hide');
            $slots_0 = $request->get('slots_0');
            $start_0 = $request->get('start_0');
            $end_0 = $request->get('end_0');

            $start_time_0 = strtotime($start_0);
            $end_time_0 = strtotime($end_0);
            $slot = strtotime(date('H:i',$start_time_0) . '+' . $slots_0 . 'minutes');

            $data_0 = [];

            for ($i=0; $slot <= $end_time_0; $i++) { 

                $data_0[$i] = [ 
                    'start_0' => date('H:i', $start_time_0),
                    'end_0' => date('H:i', $slot),
                ];

                $start_time_0 = $slot;
                $slot = strtotime(date('H:i',$start_time_0). '+' . $slots_0 . 'minutes');
            }
            //dd($data_0);
            session()->put('data_0', $data_0);
            return response()->json([
                'data' => $data_0
            ]);
        }        
    }

    public function store_data_num(Request $request){
        if(isset($request)){
            $slots_0 = $request->get('slots');
            $start_0 = $request->get('start');
            $end_0 = $request->get('end');
            $num = $request->get('num');

            $start_time_0 = strtotime($start_0);
            $end_time_0 = strtotime($end_0);
            $slot = strtotime(date('H:i',$start_time_0) . '+' . $slots_0 . 'minutes');

            $data_0 = [];

            for ($i=0; $slot <= $end_time_0; $i++) { 

                $data_0[$i] = [ 
                    'start' => date('H:i', $start_time_0),
                    'end' => date('H:i', $slot),
                ];

                $start_time_0 = $slot;
                $slot = strtotime(date('H:i',$start_time_0). '+' . $slots_0 . 'minutes');
            }
            session()->put('data_' . $num, $data_0);
            return response()->json([
                'data' => $data_0
            ]);
        }   
    }

    public function store_1(Request $request) {

        if(isset($request)){
            // $hide = $request->get('hide');
            $slots_1 = $request->get('slots_1');
            $start_1 = $request->get('start_1');
            $end_1 = $request->get('end_1');

            $start_time_1 = strtotime($start_1);
            $end_time_1 = strtotime($end_1);
            $slot = strtotime(date('H:i',$start_time_1) . '+' . $slots_1 . 'minutes');

            $data_1 = [];

            for ($i=0; $slot <= $end_time_1; $i++) { 

                $data_1[$i] = [ 
                    'start_1' => date('H:i', $start_time_1),
                    'end_1' => date('H:i', $slot),
                ];

                $start_time_1 = $slot;
                $slot = strtotime(date('H:i',$start_time_1). '+' . $slots_1 . 'minutes');
            }
            //dd($data_1);
            session()->put('data_1', $data_1);
            return redirect()->back();
        }        
    }

    public function store_2(Request $request) {

        if(isset($request)){
            // $hide = $request->get('hide');
            $slots_2 = $request->get('slots_2');
            $start_2 = $request->get('start_2');
            $end_2 = $request->get('end_2');

            $start_time_2 = strtotime($start_2);
            $end_time_2 = strtotime($end_2);
            $slot = strtotime(date('H:i',$start_time_2) . '+' . $slots_2 . 'minutes');

            $data_2 = [];

            for ($i=0; $slot <= $end_time_2; $i++) { 

                $data_2[$i] = [ 
                    'start_2' => date('H:i', $start_time_2),
                    'end_2' => date('H:i', $slot),
                ];

                $start_time_2 = $slot;
                $slot = strtotime(date('H:i',$start_time_2). '+' . $slots_2 . 'minutes');
            }
            // dd($data_1);
            session()->put('data_2', $data_2);
            return redirect()->back();
        }        
    }

    public function store_3(Request $request) {
        if (isset($request)) {
            // $hide = $request->get('hide');
            $slots_3 = $request->get('slots_3');
            $start_3 = $request->get('start_3');
            $end_3 = $request->get('end_3');

            $start_time_3 = strtotime($start_3);
            $end_time_3 = strtotime($end_3);
            $slot = strtotime(date('H:i', $start_time_3) . '+' . $slots_3 . 'minutes');

            $data_3 = [];

            for ($i=0; $slot <= $end_time_3; $i++) {
                $data_3[$i] = [
                    'start_3' => date('H:i', $start_time_3),
                    'end_3' => date('H:i', $slot),
                ];

                $start_time_3 = $slot;
                $slot = strtotime(date('H:i', $start_time_3). '+' . $slots_3 . 'minutes');
            }
            // dd($data_1);
            session()->put('data_3', $data_3);
            return redirect()->back();
        }
    }
        
    public function store_4(Request $request) {
        if (isset($request)) {
            // $hide = $request->get('hide');
            $slots_4 = $request->get('slots_4');
            $start_4 = $request->get('start_4');
            $end_4 = $request->get('end_4');
    
            $start_time_4 = strtotime($start_4);
            $end_time_4 = strtotime($end_4);
            $slot = strtotime(date('H:i', $start_time_4) . '+' . $slots_4 . 'minutes');
    
            $data_4 = [];
    
            for ($i=0; $slot <= $end_time_4; $i++) {
                $data_4[$i] = [
                    'start_4' => date('H:i', $start_time_4),
                    'end_4' => date('H:i', $slot),
                ];
    
                $start_time_4 = $slot;
                $slot = strtotime(date('H:i', $start_time_4). '+' . $slots_4 . 'minutes');
            }
            // dd($data_1);
            session()->put('data_4', $data_4);
            return redirect()->back();
        }
    }

    public function store_f(Request $request) {
        if (isset($request)) {
            // $hide = $request->get('hide');
            $slots_f = $request->get('slots_f');
            $start_f = $request->get('start_f');
            $end_f = $request->get('end_f');
    
            $start_time_f = strtotime($start_f);
            $end_time_f = strtotime($end_f);
            $slot = strtotime(date('H:i', $start_time_f) . '+' . $slots_f . 'minutes');
    
            $data_f = [];
    
            for ($i=0; $slot <= $end_time_f; $i++) {
                $data_f[$i] = [
                    'start_f' => date('H:i', $start_time_f),
                    'end_f' => date('H:i', $slot),
                ];
    
                $start_time_f = $slot;
                $slot = strtotime(date('H:i', $start_time_f). '+' . $slots_f . 'minutes');
            }
            // dd($data_6);
            session()->put('data_f', $data_f);
            return redirect()->back();
        }
    }

    public function store_6(Request $request) {
        if (isset($request)) {
            // $hide = $request->get('hide');
            $slots_6 = $request->get('slots_6');
            $start_6 = $request->get('start_6');
            $end_6 = $request->get('end_6');
    
            $start_time_6 = strtotime($start_6);
            $end_time_6 = strtotime($end_6);
            $slot = strtotime(date('H:i', $start_time_6) . '+' . $slots_6 . 'minutes');
    
            $data_6 = [];
    
            for ($i=0; $slot <= $end_time_6; $i++) {
                $data_6[$i] = [
                    'start_6' => date('H:i', $start_time_6),
                    'end_6' => date('H:i', $slot),
                ];
    
                $start_time_6 = $slot;
                $slot = strtotime(date('H:i', $start_time_6). '+' . $slots_6 . 'minutes');
            }
            // dd($data_6);
            session()->put('data_6', $data_6);
            return redirect()->back();
        }
    }//end for custom days


    public function save(Request $request) {
        
        $schedule_id = $request->schedule_id;

        $object = new SlotOne();
        $object->time_slot = serialize(session()->get('data'));
        $object->schedule_id = $schedule_id;
        $object->save();
        session()->forget('data');
        
        return back();
    }      

    public function save_0(Request $request) {
        $schedule_id = $request->schedule_id;
        $update = SlotZero::where('schedule_id', $schedule_id)->get();

        if(count($update) !== 0)
        {
            $latestschedule = SlotZero::where('schedule_id', $schedule_id)->latest('created_at')->first();
            $latestschedule->updated_at=date("Y-m-d");
            $latestschedule->save();
        }
        
        $object = new SlotZero();
        $object->time_slot_0 = serialize(session()->get('data_0'));
        $object->time_slot_1 = serialize(session()->get('data_1'));
        $object->time_slot_2 = serialize(session()->get('data_2'));
        $object->time_slot_3 = serialize(session()->get('data_3'));
        $object->time_slot_4 = serialize(session()->get('data_4'));
        $object->time_slot_5 = serialize(session()->get('data_f'));
        $object->time_slot_6 = serialize(session()->get('data_6'));
        $object->schedule_id = $schedule_id;
        $object->save();
        session()->forget('data_0');
        session()->forget('data_1');
        session()->forget('data_2');
        session()->forget('data_3');
        session()->forget('data_4');
        session()->forget('data_f');
        session()->forget('data_6');        
        return back();
    }      
}
