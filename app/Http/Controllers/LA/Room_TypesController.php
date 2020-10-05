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
use Illuminate\Support\Facades\Input;
use App\Models\Room_Type;

class Room_TypesController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Room_Types.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Room_Types');
        
        if(Module::hasAccess($module->id)) {
            return View('la.room_types.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Room_Types'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new room_type.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created room_type in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
       
        if(Module::hasAccess("Room_Types", "create")) {
            
            $rules = Module::validateRules("Room_Types", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Room_Types", $request);
            
            $photo=$request->file('image');
            
            $name=$photo->getClientOriginalName(); //$name=p1.jpg
            
            $photo->move(public_path().'/storage/uploads/', $name); //$photo=/storage/images/p1.jpg; 
            
            $data='/storage/uploads/'.$name;
   
            $today = date('Y-m-d H:i:s');
        
            $insertedID = DB::table('room_type_images')->insertGetId([
                "created_at" => $today,
                "filename" => $data,
                "extension" => "",
                "hash" => "",
                "attach_file" => "",
                "room_type_id" => $insert_id
                
            ]);
               
            return redirect()->route(config('laraadmin.adminRoute') . '.room_types.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified room_type.
     *
     * @param int $id room_type ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Room_Types", "view")) {
            
            $room_type = Room_Type::find($id);
            if(isset($room_type->id)) {
                $module = Module::get('Room_Types');
                $module->row = $room_type;
                
                return view('la.room_types.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('room_type', $room_type);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("room_type"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for editing the specified room_type.
     *
     * @param int $id room_type ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Room_Types", "edit")) {
            $room_type = Room_Type::find($id);
            if(isset($room_type->id)) {
                $module = Module::get('Room_Types');
                
                $module->row = $room_type;
                
                return view('la.room_types.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('room_type', $room_type);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("room_type"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified room_type in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id room_type ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Room_Types", "edit")) {
            
            $rules = Module::validateRules("Room_Types", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Room_Types", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.room_types.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified room_type from storage.
     *
     * @param int $id room_type ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Room_Types", "delete")) {
            Room_Type::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.room_types.index');
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
        $module = Module::get('Room_Types');
        $listing_cols = Module::getListingColumns('Room_Types');
        
        $values = DB::table('room_types')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Room_Types');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/room_types/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Room_Types", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/room_types/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Room_Types", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.room_types.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
