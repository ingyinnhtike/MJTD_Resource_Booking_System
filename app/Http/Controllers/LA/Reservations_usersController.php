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

use App\Models\Reservations_user;

class Reservations_usersController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Reservations_users.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Reservations_users');
        
        if(Module::hasAccess($module->id)) {
            return View('la.reservations_users.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Reservations_users'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new reservations_user.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created reservations_user in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Reservations_users", "create")) {
            
            $rules = Module::validateRules("Reservations_users", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $insert_id = Module::insert("Reservations_users", $request);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.reservations_users.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified reservations_user.
     *
     * @param int $id reservations_user ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Reservations_users", "view")) {
            
            $reservations_user = Reservations_user::find($id);
            if(isset($reservations_user->id)) {
                $module = Module::get('Reservations_users');
                $module->row = $reservations_user;
                
                return view('la.reservations_users.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('reservations_user', $reservations_user);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reservations_user"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for editing the specified reservations_user.
     *
     * @param int $id reservations_user ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Reservations_users", "edit")) {
            $reservations_user = Reservations_user::find($id);
            if(isset($reservations_user->id)) {
                $module = Module::get('Reservations_users');
                
                $module->row = $reservations_user;
                
                return view('la.reservations_users.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('reservations_user', $reservations_user);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reservations_user"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified reservations_user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id reservations_user ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Reservations_users", "edit")) {
            
            $rules = Module::validateRules("Reservations_users", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Reservations_users", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.reservations_users.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified reservations_user from storage.
     *
     * @param int $id reservations_user ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Reservations_users", "delete")) {
            Reservations_user::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.reservations_users.index');
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
        $module = Module::get('Reservations_users');
        $listing_cols = Module::getListingColumns('Reservations_users');
        
        $values = DB::table('reservations_users')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Reservations_users');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/reservations_users/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Reservations_users", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/reservations_users/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Reservations_users", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.reservations_users.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }

    public function getParticipants(Request $request){
        $id = $request->reservation_id;
        $sql = "select users.id, users.name from reservations_users left join users on reservations_users.user_id = users.id where users.deleted_at is null and reservations_users.deleted_at is null and reservations_users.reservations_id = $id";
        $query = DB::table(DB::raw("($sql) as catch"));
        $users = $query->get();
        
        return response()->json([
            'users' => $users
        ]);
    }
}
