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
use Zizaco\Entrust\EntrustFacade as Entrust;
use App\Models\Car_Request;
use App\Models\Car_Request_Status;

class Car_RequestsController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Car_Requests.
     *
     * @return mixed
     */
    public function index()
    {
        if(Entrust::hasRole("SUPER_ADMIN") ){
            $car_request_list=Car_Request::all();
        }else {
           
            $car_request_list = DB::table('car_requests')->whereNull('deleted_at')->where('user_id', Auth::user()->id)->get();
        }

        $module = Module::get('Car_Requests');
        $user=Auth::user();
        $user_id=$user->id;
        return View('la.car_requests.index', [
            'show_actions' => $this->show_action,
            'listing_cols' => Module::getListingColumns('Car_Requests'),
            'module' => $module,
            'user_id' => $user_id,
            'car_request_list' => $car_request_list
        ]);
    }
    
    /**
     * Show the form for creating a new car_request.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created car_request in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        
        if(Module::hasAccess("Car_Requests", "create")) {
            
            $rules = Module::validateRules("Car_Requests", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $insert_id = Module::insert("Car_Requests", $request);
            $today= date('Y-m-d');
            $car_request_status = Car_Request_Status::create([
                'car_requested_id' => $insert_id,
                'requestedperson_id' => $request['user_id'],
                'status' => "Requested",
                'date' => $today,
                'remark' => " "
                
            ]);

            return redirect()->route(config('laraadmin.adminRoute') . '.car_requests.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified car_request.
     *
     * @param int $id car_request ID
     * @return mixed
     */
    public function show($id)
    {
        
        $car_number = DB::table('car_setups')
            // ->join('car_requests', 'car_setups.id', '=', 'car_requests.car_number')
            // ->select('car_setups.car_no')
            // ->where('car_requests.id', '=', $id)
            ->whereNull('deleted_at')
            ->get();
        
        $car_request = Car_Request::find($id);
        // dd($car_number);
        
        if(isset($car_request->id)) {
            $module = Module::get('Car_Requests');
            $module->row = $car_request;
            $status_histories = Car_Request_Status::where('car_requested_id', $id)->get();

            return view('la.car_requests.show', [
                'module' => $module,
                'view_col' => $module->view_col,
                'no_header' => true,
                'no_padding' => "no-padding"
            ])->with('car_request', $car_request)
              ->with('status_histories', $status_histories)
              ->with('car_number', $car_number);
        } 
    }
    
    /**
     * Show the form for editing the specified car_request.
     *
     * @param int $id car_request ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Car_Requests", "edit")) {
            $car_request = Car_Request::find($id);
            if(isset($car_request->id)) {
                $module = Module::get('Car_Requests');
                
                $module->row = $car_request;
                
                return view('la.car_requests.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('car_request', $car_request);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("car_request"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified car_request in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id car_request ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Car_Requests", "edit")) {
            
            $rules = Module::validateRules("Car_Requests", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Car_Requests", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.car_requests.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified car_request from storage.
     *
     * @param int $id car_request ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Car_Requests", "delete")) {
            Car_Request::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.car_requests.index');
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
        $module = Module::get('Car_Requests');
        $listing_cols = Module::getListingColumns('Car_Requests');
        
        $values = DB::table('car_requests')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Car_Requests');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/car_requests/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Car_Requests", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/car_requests/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Car_Requests", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.car_requests.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
