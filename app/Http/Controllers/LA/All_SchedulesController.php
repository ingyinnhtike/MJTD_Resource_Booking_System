<?php
/**
 * Controller generated using LaraAdmin
 * Help: http://laraadmin.com
 * LaraAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Dwij IT Solutions
 * Developer Website: http://dwijitsolutions.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\All_Schedule;
use App\Models\User;
use App\Models\Accessory;
use App\Models\Reservation;
use App\SlotZero;
use App\SlotOne;

class All_SchedulesController extends Controller
{
    public $show_action = true;

    public function viewalldays(Request $request)
    {
        var_dump($request); 
    } 
    
    /**
     * Display a listing of the All_Schedules.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('All_Schedules');
        if(Module::hasAccess($module->id)) {
            return View('la.all_schedules.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('All_Schedules'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new all_schedule.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created all_schedule in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("All_Schedules", "create")) {
            
            $rules = Module::validateRules("All_Schedules", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $insert_id = Module::insert("All_Schedules", $request);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.all_schedules.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified all_schedule.
     *
     * @param int $id all_schedule ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("All_Schedules", "view")) {
            $user = User::All();
            $accessorie=Accessory::All();

            $all_schedule = All_Schedule::find($id);

            if($all_schedule->same_layout){
                $datas = SlotOne::where('schedule_id',$id)->latest('created_at')->first();
                if(isset($datas)){
                    if(!session()->exists('data'))
                        session()->put('data', unserialize($datas->time_slot));
                }else{
                    session()->forget('data');
                }
                
            } else{
                $datas = SlotZero::where('schedule_id',$id)->latest('created_at')->first();
                if(isset($datas)){
                    if(!session()->exists('data_0'))
                        session()->put('data_0', unserialize($datas->time_slot_0));
                    if(!session()->exists('data_1'))
                        session()->put('data_1', unserialize($datas->time_slot_1));
                    if(!session()->exists('data_2'))
                        session()->put('data_2', unserialize($datas->time_slot_2));
                    if(!session()->exists('data_3'))
                        session()->put('data_3', unserialize($datas->time_slot_3));
                    if(!session()->exists('data_4'))
                        session()->put('data_4', unserialize($datas->time_slot_4));
                    if(!session()->exists('data_f'))
                        session()->put('data_f', unserialize($datas->time_slot_5));
                    if(!session()->exists('data_6'))
                        session()->put('data_6', unserialize($datas->time_slot_6));
                } else{
                    session()->forget('data_0');
                    session()->forget('data_1');
                    session()->forget('data_2');
                    session()->forget('data_3');
                    session()->forget('data_4');
                    session()->forget('data_f');
                    session()->forget('data_6');
                }
            }

            if(isset($all_schedule->id)) {
                $module = Module::get('All_Schedules');
                $module->row = $all_schedule;
                
                return view('la.all_schedules.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding",
                    ])->with('all_schedule', $all_schedule)
                    ->with('user',$user)
                    ->with('accessorie',$accessorie)
                    ->with('schedule_id', $id);
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
    
    /**
     * Show the form for editing the specified all_schedule.
     *
     * @param int $id all_schedule ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("All_Schedules", "edit")) {
            $all_schedule = All_Schedule::find($id);
            if(isset($all_schedule->id)) {
                $module = Module::get('All_Schedules');
                
                $module->row = $all_schedule;
                
                return view('la.all_schedules.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
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
    
    /**
     * Update the specified all_schedule in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id all_schedule ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("All_Schedules", "edit")) {
            
            $rules = Module::validateRules("All_Schedules", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("All_Schedules", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.all_schedules.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified all_schedule from storage.
     *
     * @param int $id all_schedule ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("All_Schedules", "delete")) {
            All_Schedule::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.all_schedules.index');
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Server side Datatable fetch via Ajax
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function dtajax(Request $request)
    {
        $module = Module::get('All_Schedules');
        $listing_cols = Module::getListingColumns('All_Schedules');
        
        $values = DB::table('all_schedules')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('All_Schedules');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/all_schedules/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("All_Schedules", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/all_schedules/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("All_Schedules", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.all_schedules.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }


    


}
