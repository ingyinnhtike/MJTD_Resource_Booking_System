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

use App\Models\Reservation_status;

class Reservation_statusesController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Reservation_statuses.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Reservation_statuses');
        
        if(Module::hasAccess($module->id)) {
            return View('la.reservation_statuses.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Reservation_statuses'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new reservation_status.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created reservation_status in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Reservation_statuses", "create")) {
            
            $rules = Module::validateRules("Reservation_statuses", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $insert_id = Module::insert("Reservation_statuses", $request);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.reservation_statuses.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified reservation_status.
     *
     * @param int $id reservation_status ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Reservation_statuses", "view")) {
            
            $reservation_status = Reservation_status::find($id);
            if(isset($reservation_status->id)) {
                $module = Module::get('Reservation_statuses');
                $module->row = $reservation_status;
                
                return view('la.reservation_statuses.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('reservation_status', $reservation_status);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reservation_status"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for editing the specified reservation_status.
     *
     * @param int $id reservation_status ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Reservation_statuses", "edit")) {
            $reservation_status = Reservation_status::find($id);
            if(isset($reservation_status->id)) {
                $module = Module::get('Reservation_statuses');
                
                $module->row = $reservation_status;
                
                return view('la.reservation_statuses.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('reservation_status', $reservation_status);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reservation_status"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified reservation_status in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id reservation_status ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Reservation_statuses", "edit")) {
            
            $rules = Module::validateRules("Reservation_statuses", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Reservation_statuses", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.reservation_statuses.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified reservation_status from storage.
     *
     * @param int $id reservation_status ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Reservation_statuses", "delete")) {
            Reservation_status::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.reservation_statuses.index');
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
        $module = Module::get('Reservation_statuses');
        $listing_cols = Module::getListingColumns('Reservation_statuses');
        
        $values = DB::table('reservation_statuses')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Reservation_statuses');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/reservation_statuses/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Reservation_statuses", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/reservation_statuses/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Reservation_statuses", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.reservation_statuses.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }

    public function confirm(Request $request){
        
        $user=Auth::user();
        $user_id=$user->id;
        $id = $request->input('carrequest_id');
        $remark = $request->input('remark');
        DB:: table('reservations')->where('id', $id)->update(['status' => 'Confirmed']);
        $today= date('Y-m-d');
            $reservation_status = Reservation_status::create([
                'user_id' => $user_id,
                'reservation_status' => "Confrimed",
                'reservations_id' => $id,
                'remark' => $remark
                
            ]);
        return redirect(config('laraadmin.adminRoute') . "/bookinglist");
    }

    

}
