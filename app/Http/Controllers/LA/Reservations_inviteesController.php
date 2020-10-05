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

use App\Models\Reservations_invitee;

class Reservations_inviteesController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Reservations_invitees.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Reservations_invitees');
        
        if(Module::hasAccess($module->id)) {
            return View('la.reservations_invitees.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Reservations_invitees'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new reservations_invitee.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created reservations_invitee in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Reservations_invitees", "create")) {
            
            $rules = Module::validateRules("Reservations_invitees", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $insert_id = Module::insert("Reservations_invitees", $request);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.reservations_invitees.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified reservations_invitee.
     *
     * @param int $id reservations_invitee ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Reservations_invitees", "view")) {
            
            $reservations_invitee = Reservations_invitee::find($id);
            if(isset($reservations_invitee->id)) {
                $module = Module::get('Reservations_invitees');
                $module->row = $reservations_invitee;
                
                return view('la.reservations_invitees.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('reservations_invitee', $reservations_invitee);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reservations_invitee"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for editing the specified reservations_invitee.
     *
     * @param int $id reservations_invitee ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Reservations_invitees", "edit")) {
            $reservations_invitee = Reservations_invitee::find($id);
            if(isset($reservations_invitee->id)) {
                $module = Module::get('Reservations_invitees');
                
                $module->row = $reservations_invitee;
                
                return view('la.reservations_invitees.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('reservations_invitee', $reservations_invitee);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reservations_invitee"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified reservations_invitee in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id reservations_invitee ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Reservations_invitees", "edit")) {
            
            $rules = Module::validateRules("Reservations_invitees", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Reservations_invitees", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.reservations_invitees.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified reservations_invitee from storage.
     *
     * @param int $id reservations_invitee ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Reservations_invitees", "delete")) {
            Reservations_invitee::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.reservations_invitees.index');
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
        $module = Module::get('Reservations_invitees');
        $listing_cols = Module::getListingColumns('Reservations_invitees');
        
        $values = DB::table('reservations_invitees')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Reservations_invitees');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/reservations_invitees/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Reservations_invitees", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/reservations_invitees/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Reservations_invitees", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.reservations_invitees.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }
    public function getInvitees(Request $request){
        $id = $request->reservation_id;
        $invitees = DB::table('reservations_invitees')->select('email')->whereNull('deleted_at')->where('reservations_id', $id)->get();
        return response()->json([
            'invitees' => $invitees
        ]);
    }
}
