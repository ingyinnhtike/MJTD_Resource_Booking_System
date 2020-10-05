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

use App\Models\Car_Request_Status;

class Car_Request_StatusesController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Car_Request_Statuses.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Car_Request_Statuses');
        $request_status=Car_Request_Status::all();
        if(Module::hasAccess($module->id)) {
            return View('la.car_request_statuses.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Car_Request_Statuses'),
                'module' => $module,
                'request_status' => $request_status
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new car_request_status.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created car_request_status in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Car_Request_Statuses", "create")) {
            
            $rules = Module::validateRules("Car_Request_Statuses", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $insert_id = Module::insert("Car_Request_Statuses", $request);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.car_request_statuses.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified car_request_status.
     *
     * @param int $id car_request_status ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Car_Request_Statuses", "view")) {
            
            $car_request_status = Car_Request_Status::find($id);
            if(isset($car_request_status->id)) {
                $module = Module::get('Car_Request_Statuses');
                $module->row = $car_request_status;
                
                return view('la.car_request_statuses.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('car_request_status', $car_request_status);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("car_request_status"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for editing the specified car_request_status.
     *
     * @param int $id car_request_status ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Car_Request_Statuses", "edit")) {
            $car_request_status = Car_Request_Status::find($id);
            if(isset($car_request_status->id)) {
                $module = Module::get('Car_Request_Statuses');
                
                $module->row = $car_request_status;
                
                return view('la.car_request_statuses.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('car_request_status', $car_request_status);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("car_request_status"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified car_request_status in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id car_request_status ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Car_Request_Statuses", "edit")) {
            
            $rules = Module::validateRules("Car_Request_Statuses", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Car_Request_Statuses", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.car_request_statuses.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified car_request_status from storage.
     *
     * @param int $id car_request_status ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Car_Request_Statuses", "delete")) {
            Car_Request_Status::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.car_request_statuses.index');
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
        $module = Module::get('Car_Request_Statuses');
        $listing_cols = Module::getListingColumns('Car_Request_Statuses');
        
        $values = DB::table('car_request_statuses')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Car_Request_Statuses');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/car_request_statuses/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Car_Request_Statuses", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/car_request_statuses/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Car_Request_Statuses", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.car_request_statuses.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
