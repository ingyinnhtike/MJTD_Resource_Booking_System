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
use Zizaco\Entrust\EntrustFacade as Entrust;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\User;
use App\Models\Accessory;
use App\Models\Reservation;
use App\Models\Reservations_invitee;
use App\Models\Reservation_accessory;
use App\Models\Reservations_user;
use App\Models\Resource;
use App\Models\All_Schedule;
use App\Models\Reservation_status;
use App\SlotZero;
use Illuminate\Support\Facades\Input;
use Calendar;
use Redirect;


use Carbon\Carbon;
use DateInterval;
use DateTime;
use DatePeriod;

class ReservationsController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Reservations.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Reservations');
        $all_schedule=All_Schedule::All();
        
        if(Module::hasAccess($module->id)) {
            return View('la.reservations.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('All_Schedules'),
                'module' => $module
            ])->with('all_schedule',$all_schedule);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new reservation.
     *
     * @return mixed
     */
    public function create()
    {
       
    }
    
    /**
     * Store a newly created reservation in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    
    public function store(Request $request)
    {
        
        $reservation = Reservation::create([
            'resource_id' => $request['resource'],
            'title' => $request['title'],
            'description' => $request['description'],
            'owner_id' =>$request['owner_id'],
            'begin_date' => $request['begin_date'],
            'begin_time' => $request['begin_time'],
            'end_date' => $request['end_date'],
            'end_time' => $request['end_time'],
            'no_of_participant' => $request['no_of_participant'],
            'room_type_id' => $request['room_type_id'],
            'status' => "Requested"
        ]);

        $reservations_invitees=Reservation_status::create([
            'reservation_status' => "Requested",
            'reservations_id' =>$reservation['id'],
            'user_id' => $request['owner_id']
        ]);
       
        $reservations_invitees=Reservations_invitee::create([
            'email' => $request['invitees'],
            'reservations_id' =>$reservation['id']
        ]);

        if($request->input('user_id')){
            foreach($request->input('user_id') as $user)
            {
                $reservations_user=Reservations_user::create([
                    'user_id' => $user,
                    'reservations_id' =>$reservation['id']
                ]);
            }
        }
        $count = $request->input('count1');
        for($i = 1; $i <= $count; $i++)
        {
            if($request->input('accessories_'.$i) != "")
            {
                $input['accessories_id'] = $request->input('accessories_' . $i);
                $input['quantity'] = $request->input('requested_' . $i);
                $input['reservations_id']=$reservation['id'];
                Reservation_accessory::create($input);
            } 
        }  
           
        return redirect()->route('admin.reservations.show', ['id' => $request->schedule_id]);
    }

    public function getstartendtime(Request $request)
    {
       
        $sid = $request->scheduleidone;
        $day = $request->day;
        $same_layout = $request->same_layout;
       
        if(!$same_layout){
            $for_same_day= DB::table('slot_zeros')
                        ->select('*')
                        ->where('schedule_id',$sid)
                        ->orderBy('created_at', 'desc')
                        ->first();
        
            switch ($day) {
                case "0":
                    $betimes=($for_same_day->time_slot_0);
                    break;
                case "1":
                    $betimes=($for_same_day->time_slot_1);
                    break;
                case "2":
                    $betimes=($for_same_day->time_slot_2);
                    break;
                case "3":
                    $betimes=($for_same_day->time_slot_3);
                    break;
                case "4":
                    $betimes=($for_same_day->time_slot_4);
                    break;
                case "5":
                    $betimes=($for_same_day->time_slot_5);
                    break;
                case "6":
                    $betimes=($for_same_day->time_slot_6);
                    break;
                default:
                    echo"null";
            }
        }else{
            $for_same_day= DB::table('slot_ones')
                        ->select('*')
                        ->where('schedule_id',$sid)
                        ->orderBy('created_at', 'desc')
                        ->first();

            $betimes=($for_same_day->time_slot);
        }
        return response()->json([
            'betimes' => unserialize($betimes),
            'day' => $day
           
        ]);
    }

    public function getdatetime(Request $request)
    {
        $begindate=  $request->input('begindate');
        $btime=  $request->input('begintime');
        $etime=  $request->input('endtime');
        $resource = $request->input('resource');
        $begintimea= trim(str_replace( ['\'', '"', '-' , ':', '<', '>','\\u00a0'], '', $btime));
        $endtimea= trim(str_replace( ['\'', '"', '-' , ':', '<', '>','\\u00a0'], '', $etime));
        $begintime=(int)$begintimea;
        $endtime=(int)$endtimea;
        
        $datetime = DB::table('reservations')
                    ->select('begin_date','begin_time','end_time')
                    ->whereDate('begin_date',$begindate)
                    ->where('resource_id', $resource)
                    ->whereNull('deleted_at')
                    ->get();
       
        $result = "false";
        foreach($datetime as $datetimes)
        {
            $betime= trim(str_replace( ['\'', '"', '-' , ':', '<', '>','\\u00a0'], '', $datetimes->begin_time));
            $entime= trim(str_replace( ['\'', '"', '-' , ':', '<', '>','\\u00a0'], '', $datetimes->end_time));
            $db_begin_time=(int)$betime;
            $db_end_time=(int)$entime;
        
            // if(($db_begin_time <= $begintime && $begintime < $db_end_time) || ($db_begin_time < $endtime && $endtime < $db_end_time) || ($db_begin_time < $endtime && $endtime > $db_end_time) || ($db_begin_time < $begintime && $db_end_time < $endtime))
            if(($begintime > $db_begin_time && $begintime < $db_end_time) || ($endtime > $db_begin_time && $endtime < $db_end_time) || ($db_begin_time > $begintime && $db_begin_time < $endtime) || ($db_end_time > $begintime && $db_end_time < $endtime))
            {
                return  "true";
            }
        }
        return $result;
    }

    public function getimageid(Request $request)
    {
        $id=$request->image_id;
        $img=DB::table('room_types')
                ->join('room_type_images','room_types.id','=','room_type_images.room_type_id')
                ->select('filename','name')
                ->whereNull('room_types.deleted_at')
                ->where('room_types.id',$id)
                ->get();
        
        // return view('la.reservations.show',compact('img'));
        return response()->json([
            'img' => $img
           
        ]);
    }
    /**
     * Display the specified reservation.
     *
     * @param int $id reservation ID
     * @return mixed
     */
    public function show($id,Request $request)
    {
        $image=DB::table('room_types')
                ->join('room_type_images','room_types.id','=','room_type_images.room_type_id')
                ->select('filename','name','room_types.id')
                ->whereNull('room_types.deleted_at')
                ->get();
        
        if(Module::hasAccess("Reservations", "view")) {
            $user = User::All();
            $all_schedule = All_Schedule::find($id);

            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

            $week = []; 
            for ($i=0; $i <7 ; $i++) {
                $week[] = $now->startOfWeek()->addDay($i)->format('Y-m-d');//push the current day and plus the mount of $i 
            }

            $accessorie = Accessory::All();
            $sql = "select resources.* from resources left join all_schedules on all_schedules.id = resources.schedule
                where resources.deleted_at is null and all_schedules.deleted_at is null and all_schedules.id = $id";
            $query = DB::table(DB::raw("($sql) as catch"));
            $resource = $query->get();

            $sql = "select reservations.*, users.name from reservations left join resources on resources.id = reservations.resource_id
                left join all_schedules on all_schedules.id = resources.schedule
                left join users on users.id = reservations.owner_id
                where users.deleted_at is null and reservations.deleted_at is null and resources.deleted_at is null and all_schedules.deleted_at is null and all_schedules.id = $id";
            $query = DB::table(DB::raw("($sql) as catch"));
            $reservation = $query->get();

            if(Entrust::hasRole("SUPER_ADMIN")){
                $data_resources = DB::table('resources')
                    ->select('resources.name','resources.id', 'resources.no_of_maximum_people', 'resources.room_types', 'select_accessory')
                    ->where('schedule', $id)
                    ->where('status', '=', 'Available')
                    ->whereNull('deleted_at')
                    ->get();
            }else{
                $data_resources = array();
                $public_resources = DB::table('resources')
                    ->select('resources.name','resources.id', 'resources.no_of_maximum_people', 'resources.room_types', 'select_accessory')
                    ->where('schedule', $id)
                    ->where('status', '=', 'Available')
                    ->where('is_public', 1)
                    ->whereNull('deleted_at')
                    ->get();
                $private_resouces = DB::table('get_resource_by_userid')
                    ->select('name','id', 'no_of_maximum_people', 'room_types')
                    ->where('schedule', $id)
                    ->where('status', '=', 'Available')
                    ->where('is_public', 0)
                    ->where('user_id', Auth::user()->id)
                    ->whereNull('deleted_at')
                    ->get();

                foreach ($public_resources as $key => $res) {
                    array_push($data_resources, $res);
                }
                foreach ($private_resouces as $key => $res) {
                    array_push($data_resources, $res);
                }

                // dd($data_resources);
            }
            if(isset($all_schedule->id)) {
                $module = Module::get('Reservations');
                $module->row = $all_schedule;
                
                return view('la.reservations.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                    ])->with('all_schedule', $all_schedule)
                    ->with('user',$user)
                    ->with('accessorie',$accessorie)
                    // ->with('resource',$resource)
                    ->with('reservation',$reservation)
                    ->with('scheduleid', $id)
                    ->with('week', $week)
                    ->with('data_resources', $data_resources)
                    ->with('image', $image)
                    ->with('id',$id);
                    
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

    public function next(Request $request)
    {
        $image=DB::table('room_types')
                ->join('room_type_images','room_types.id','=','room_type_images.room_type_id')
                ->select('filename','name','room_types.id')
                ->whereNull('room_types.deleted_at')
                ->get();
        // return response()->json([
        //     'request'=>$request->all()
        // ]);
        if(Module::hasAccess("Reservations", "view")) {
            $id = $request->schedule_id;

            $previous_weeks = json_decode($request->week);

            $user = User::All();
            $all_schedule = All_Schedule::find($id);

            $carbaoDay = Carbon::createFromFormat('Y-m-d', $previous_weeks[6])->addDay(1); //spesific day

            $week = []; 
            for ($i=0; $i <7 ; $i++) {
                $week[] = $carbaoDay->startOfWeek()->addDay($i)->format('Y-m-d');//push the current day and plus the mount of $i 
            }

            $accessorie = Accessory::All();
            $sql = "select resources.* from resources left join all_schedules on all_schedules.id = resources.schedule
                where resources.deleted_at is null and all_schedules.deleted_at is null and all_schedules.id = $id";
            $query = DB::table(DB::raw("($sql) as catch"));
            $resource = $query->get();

            $sql = "select reservations.*, users.name from reservations left join resources on resources.id = reservations.resource_id left join all_schedules on all_schedules.id = resources.schedule left join users on users.id = reservations.owner_id where users.deleted_at is null and reservations.deleted_at is null and resources.deleted_at is null and all_schedules.deleted_at is null and all_schedules.id = $id";
            $query = DB::table(DB::raw("($sql) as catch"));
            $reservation = $query->get();

            if(Entrust::hasRole("SUPER_ADMIN")){
                $data_resources = DB::table('resources')
                    ->select('resources.name','resources.id', 'resources.no_of_maximum_people', 'resources.room_types', 'select_accessory')
                    ->where('schedule', $id)
                    ->where('status', '=', 'Available')
                    ->whereNull('deleted_at')
                    ->get();
            }else{
                $data_resources = array();
                $public_resources = DB::table('resources')
                    ->select('resources.name','resources.id', 'resources.no_of_maximum_people', 'resources.room_types', 'select_accessory')
                    ->where('schedule', $id)
                    ->where('status', '=', 'Available')
                    ->where('is_public', 1)
                    ->whereNull('deleted_at')
                    ->get();
                $private_resouces = DB::table('get_resource_by_userid')
                    ->select('name','id', 'no_of_maximum_people', 'room_types')
                    ->where('schedule', $id)
                    ->where('status', '=', 'Available')
                    ->where('is_public', 0)
                    ->where('user_id', Auth::user()->id)
                    ->whereNull('deleted_at')
                    ->get();

                foreach ($public_resources as $key => $res) {
                    array_push($data_resources, $res);
                }
                foreach ($private_resouces as $key => $res) {
                    array_push($data_resources, $res);
                }
            }
            
            if(isset($all_schedule->id)) {
                $module = Module::get('Reservations');
                $module->row = $all_schedule;
                
                return view('la.reservations.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                    ])->with('all_schedule', $all_schedule)
                    ->with('user',$user)
                    ->with('accessorie',$accessorie)
                    ->with('resource',$resource)
                    ->with('reservation',$reservation)
                    ->with('scheduleid', $id)
                    ->with('week', $week)
                    ->with('data_resources', $data_resources)
                    ->with('image',$image);
                    
            } else {

                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("all_schedule"),
                ]);
            }
        } else {
            return redirect()->route('admin.reservations.show', ['id' => $id]);
        }
    }

    public function previous(Request $request)
    {
        $image=DB::table('room_types')
                ->join('room_type_images','room_types.id','=','room_type_images.room_type_id')
                ->select('filename','name','room_types.id')
                ->whereNull('room_types.deleted_at')
                ->get();
        if(Module::hasAccess("Reservations", "view")) {
            $id = $request->schedule_id;

            $previous_weeks = json_decode($request->week);
            
            $user = User::All();
            $all_schedule = All_Schedule::find($id);

            $carbaoDay = Carbon::createFromFormat('Y-m-d', $previous_weeks[0])->addDay(-1);

            $week = []; 
            for ($i=0; $i <7 ; $i++) {
                $week[] = $carbaoDay->startOfWeek()->addDay($i)->format('Y-m-d');//push the current day and plus the mount of $i 
            }

            $accessorie = Accessory::All();
            $sql = "select resources.* from resources left join all_schedules on all_schedules.id = resources.schedule
                where resources.deleted_at is null and all_schedules.deleted_at is null and all_schedules.id = $id";
            $query = DB::table(DB::raw("($sql) as catch"));
            $resource = $query->get();

            $sql = "select reservations.*, users.name from reservations left join resources on resources.id = reservations.resource_id left join all_schedules on all_schedules.id = resources.schedule left join users on users.id = reservations.owner_id where users.deleted_at is null and reservations.deleted_at is null and resources.deleted_at is null and all_schedules.deleted_at is null and all_schedules.id = $id";
            $query = DB::table(DB::raw("($sql) as catch"));
            $reservation = $query->get();

            if(Entrust::hasRole("SUPER_ADMIN")){
                $data_resources = DB::table('resources')
                    ->select('resources.name','resources.id', 'resources.no_of_maximum_people', 'resources.room_types', 'select_accessory')
                    ->where('schedule', $id)
                    ->where('status', '=', 'Available')
                    ->whereNull('deleted_at')
                    ->get();
            }else{
                $data_resources = array();
                $public_resources = DB::table('resources')
                    ->select('resources.name','resources.id', 'resources.no_of_maximum_people', 'resources.room_types', 'select_accessory')
                    ->where('schedule', $id)
                    ->where('status', '=', 'Available')
                    ->where('is_public', 1)
                    ->whereNull('deleted_at')
                    ->get();
                $private_resouces = DB::table('get_resource_by_userid')
                    ->select('name','id', 'no_of_maximum_people', 'room_types')
                    ->where('schedule', $id)
                    ->where('status', '=', 'Available')
                    ->where('is_public', 0)
                    ->where('user_id', Auth::user()->id)
                    ->whereNull('deleted_at')
                    ->get();

                foreach ($public_resources as $key => $res) {
                    array_push($data_resources, $res);
                }
                foreach ($private_resouces as $key => $res) {
                    array_push($data_resources, $res);
                }
            }
            
            if(isset($all_schedule->id)) {
                $module = Module::get('Reservations');
                $module->row = $all_schedule;
                
                return view('la.reservations.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                    ])->with('all_schedule', $all_schedule)
                    ->with('user',$user)
                    ->with('accessorie',$accessorie)
                    ->with('resource',$resource)
                    ->with('reservation',$reservation)
                    ->with('scheduleid', $id)
                    ->with('week', $week)
                    ->with('data_resources', $data_resources)
                    ->with('image',$image);
                    
            } else {

                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("all_schedule"),
                ]);
            }
        } else {
            return redirect()->route('admin.reservations.show', ['id' => $id]);
        }
    }
    
    /**
     * Show the form for editing the specified reservation.
     *
     * @param int $id reservation ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Reservations", "edit")) {
            $reservation = Reservation::find($id);
            if(isset($reservation->id)) {
                $module = Module::get('Reservations');
                
                $module->row = $reservation;
                
                return view('la.reservations.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('reservation', $reservation);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reservation"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified reservation in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id reservation ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Reservations", "edit")) {
            
            $rules = Module::validateRules("Reservations", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Reservations", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.reservations.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified reservation from storage.
     *
     * @param int $id reservation ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Reservations", "delete")) {
            Reservation::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.reservations.index');
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
        $module = Module::get('Reservations');
        $listing_cols = Module::getListingColumns('Reservations');
        
        $values = DB::table('reservations')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Reservations');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/reservations/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Reservations", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/reservations/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Reservations", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.reservations.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }

    public function cancel(Request $request) {
        $reservation_id = $request->input('reservation_id');
        $schedule_id = $request->input('schedule_id');

        $today = Carbon::now();

        DB:: table('reservations')->where('id', $reservation_id)->update(['status' => 'Cancelled' ]);

        return redirect()->route('admin.reservations.show', ['id' => $schedule_id]);
    }
}
