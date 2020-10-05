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

use App\Models\Start_On;

class Start_OnsController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Start_Ons.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Start_Ons');
        
        if(Module::hasAccess($module->id)) {
            return View('la.start_ons.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Start_Ons'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new start_on.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created start_on in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Start_Ons", "create")) {
            
            $rules = Module::validateRules("Start_Ons", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $insert_id = Module::insert("Start_Ons", $request);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.start_ons.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified start_on.
     *
     * @param int $id start_on ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Start_Ons", "view")) {
            
            $start_on = Start_On::find($id);
            if(isset($start_on->id)) {
                $module = Module::get('Start_Ons');
                $module->row = $start_on;
                
                return view('la.start_ons.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('start_on', $start_on);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("start_on"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for editing the specified start_on.
     *
     * @param int $id start_on ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Start_Ons", "edit")) {
            $start_on = Start_On::find($id);
            if(isset($start_on->id)) {
                $module = Module::get('Start_Ons');
                
                $module->row = $start_on;
                
                return view('la.start_ons.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('start_on', $start_on);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("start_on"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified start_on in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id start_on ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Start_Ons", "edit")) {
            
            $rules = Module::validateRules("Start_Ons", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Start_Ons", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.start_ons.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified start_on from storage.
     *
     * @param int $id start_on ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Start_Ons", "delete")) {
            Start_On::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.start_ons.index');
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
        $module = Module::get('Start_Ons');
        $listing_cols = Module::getListingColumns('Start_Ons');
        
        $values = DB::table('start_ons')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Start_Ons');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/start_ons/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Start_Ons", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/start_ons/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Start_Ons", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.start_ons.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
