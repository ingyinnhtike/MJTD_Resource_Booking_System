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

use App\Models\Resource;
use App\Models\User;
use App\Models\Group;
use App\Models\Resource_User;
use App\Models\Resource_Group;

class ResourcesController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Resources.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Resources');
        
        if(Module::hasAccess($module->id)) {
            return View('la.resources.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Resources'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $user   = User::get();
        $group   = Group::get();
        
        if(Module::hasAccess("Resources", "create")) {
            $module = Module::get('Resources');
            
            return view('la.resources.create', [
                    'module' => $module,
                    'user' =>$user,
                    'group' =>$group]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Store a newly created resource in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Resources", "create")) {
            
            $rules = Module::validateRules("Resources", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $insert_id = Module::insert("Resources", $request);
            
            
            $operator_list = $request->operator_list;
            if($operator_list == "")
                $user_lists = array();
            else
                $user_lists = explode(',', $operator_list);

            foreach($user_lists as $user)
            {
                $resource_user=Resource_User::create([
                    'user_id' => $user,
                    'resource_id' => $insert_id
                ]);
            }

            $group_list = $request->group_list; 
            if($group_list == "")
                $groups = array();
            else
                $groups = explode(',', $group_list);
            foreach($groups as $group)
            {
                $resource_user=Resource_Group::create([
                    'group_id' => $group,
                    'resource_id' => $insert_id
                ]);
            }
            
            return redirect()->route(config('laraadmin.adminRoute') . '.resources.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param int $id resource ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Resources", "view")) {
            
            $resource = Resource::find($id);
            if(isset($resource->id)) {
                $module = Module::get('Resources');
                $module->row = $resource;
                $group_lists = array();
                $user_lists = array();

                if(!$resource->is_public){
                    $group_lists = DB::table('resource_groups')
                    ->select('groups.id', 'groups.name')
                    ->join('groups','groups.id','=','resource_groups.group_id')
                    ->where('resource_groups.resource_id', $id)->whereNull('groups.deleted_at')->whereNull('resource_groups.deleted_at')->get();

                    $user_lists = DB::table('resource_users')
                    ->select('users.id', 'users.name')
                    ->join('users','users.id','=','resource_users.user_id')
                    ->where('resource_users.resource_id', $id)->whereNull('users.deleted_at')->whereNull('resource_users.deleted_at')->get();
                }
                
                return view('la.resources.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding",
                    'user_lists' => $user_lists,
                    'group_lists' => $group_lists
                ])->with('resource', $resource);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("resource"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id resource ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Resources", "edit")) {
            $resource = Resource::find($id);
            if(isset($resource->id)) {
                $module = Module::get('Resources');
                $users = User::whereNull('deleted_at')->get();
                $groups = Group::whereNull('deleted_at')->get();

                $group_lists = DB::table('resource_groups')
                    ->select('groups.id', 'groups.name')
                    ->join('groups','groups.id','=','resource_groups.group_id')
                    ->where('resource_id', $id)->whereNull('groups.deleted_at')->whereNull('resource_groups.deleted_at')->get();
                $user_lists = DB::table('resource_users')
                    ->select('users.id', 'users.name')
                    ->join('users','users.id','=','resource_users.user_id')
                    ->where('resource_id', $id)->whereNull('users.deleted_at')->whereNull('resource_users.deleted_at')->get();

                $selected_group_list = DB::table('resource_groups')->select('group_id')->where('resource_id', $id)->whereNull('deleted_at')->get();
                $selected_user_list = DB::table('resource_users')->select('user_id')->where('resource_id', $id)->whereNull('deleted_at')->get();

                $user_id_array = array();
                foreach($selected_user_list as $user)
                {
                    array_push($user_id_array, $user->user_id);
                }
                $group_id_array = array();
                foreach($selected_group_list as $group)
                {
                    array_push($group_id_array, $group->group_id);
                }
                
                $module->row = $resource;
                
                return view('la.resources.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'users' => $users,
                    'groups' => $groups,
                    'selected_group_list' => $group_id_array,
                    'selected_user_list' => $user_id_array,
                    'group_lists' => $group_lists,
                    'user_lists' => $user_lists
                ])->with('resource', $resource);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("resource"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id resource ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Resources", "edit")) {
            
            $rules = Module::validateRules("Resources", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Resources", $request, $id);

            $today = date('Y-m-d H:i:s');
            DB:: table('resource_users')->where('resource_id', $id)->update(['deleted_at' => $today]);
            DB:: table('resource_groups')->where('resource_id', $id)->update(['deleted_at' => $today]);

            $user_list = $request->user_list;
            if($user_list == "")
                $user_lists = array();
            else
                $user_lists = explode(',', $user_list);

            foreach($user_lists as $user)
            {
                $resource_user=Resource_User::create([
                    'created_at' => $today,
                    'user_id' => $user,
                    'resource_id' => $insert_id
                ]);
            }

            $group_list = $request->group_list; 
            if($group_list == "")
                $groups = array();
            else
                $groups = explode(',', $group_list);
            foreach($groups as $group)
            {
                $resource_user=Resource_Group::create([
                    'created_at' => $today,
                    'group_id' => $group,
                    'resource_id' => $insert_id
                ]);
            }
            
            return redirect()->route(config('laraadmin.adminRoute') . '.resources.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id resource ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Resources", "delete")) {
            Resource::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.resources.index');
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
        $module = Module::get('Resources');
        $listing_cols = Module::getListingColumns('Resources');
        
        $values = DB::table('resources')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Resources');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/resources/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Resources", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/resources/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Resources", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.resources.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }
    public function getResource(Request $request){
        $id = $request->reservation_id;
        $sql = "select resources.* from resources inner join reservations on resources.id = reservations.resource_id where resources.deleted_at is null and reservations.deleted_at is null and reservations.id = $id";
        $query = DB::table(DB::raw("($sql) as catch"));
        $resource = $query->first();
        
        return response()->json([
            'resource' => $resource
        ]);
    }
}
