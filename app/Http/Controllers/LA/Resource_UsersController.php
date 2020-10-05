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

use App\Models\Resource_User;

class Resource_UsersController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Resource_Users.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Resource_Users');
        
        if(Module::hasAccess($module->id)) {
            return View('la.resource_users.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Resource_Users'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new resource_user.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created resource_user in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Resource_Users", "create")) {
            
            $rules = Module::validateRules("Resource_Users", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $insert_id = Module::insert("Resource_Users", $request);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.resource_users.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified resource_user.
     *
     * @param int $id resource_user ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Resource_Users", "view")) {
            
            $resource_user = Resource_User::find($id);
            if(isset($resource_user->id)) {
                $module = Module::get('Resource_Users');
                $module->row = $resource_user;
                
                return view('la.resource_users.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('resource_user', $resource_user);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("resource_user"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for editing the specified resource_user.
     *
     * @param int $id resource_user ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Resource_Users", "edit")) {
            $resource_user = Resource_User::find($id);
            if(isset($resource_user->id)) {
                $module = Module::get('Resource_Users');
                
                $module->row = $resource_user;
                
                return view('la.resource_users.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('resource_user', $resource_user);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("resource_user"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified resource_user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id resource_user ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Resource_Users", "edit")) {
            
            $rules = Module::validateRules("Resource_Users", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Resource_Users", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.resource_users.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified resource_user from storage.
     *
     * @param int $id resource_user ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Resource_Users", "delete")) {
            Resource_User::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.resource_users.index');
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
        $module = Module::get('Resource_Users');
        $listing_cols = Module::getListingColumns('Resource_Users');
        
        $values = DB::table('resource_users')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Resource_Users');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/resource_users/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Resource_Users", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/resource_users/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Resource_Users", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.resource_users.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
