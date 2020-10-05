<?php

namespace App\Http\Controllers;

use Module;
use App\Models\All_Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function show($id)
    {
        if(Module::hasAccess("All_Schedules", "view")) {
            
            $all_schedule = All_Schedule::find($id);
            if(isset($all_schedule->id)) {
                $module = Module::get('All_Schedules');
                $module->row = $all_schedule;
                
                return view('la.all_schedules.timeline', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding",
                    ])->with('all_schedule', $all_schedule);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("all_schedule"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
}
