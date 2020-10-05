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

use App\Models\Reservation_accessory;

class Reservation_accessoriesController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Reservation_accessories.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Reservation_accessories');
        
        if(Module::hasAccess($module->id)) {
            return View('la.reservation_accessories.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Reservation_accessories'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new reservation_accessory.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created reservation_accessory in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Reservation_accessories", "create")) {
            
            $rules = Module::validateRules("Reservation_accessories", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $insert_id = Module::insert("Reservation_accessories", $request);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.reservation_accessories.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified reservation_accessory.
     *
     * @param int $id reservation_accessory ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Reservation_accessories", "view")) {
            
            $reservation_accessory = Reservation_accessory::find($id);
            if(isset($reservation_accessory->id)) {
                $module = Module::get('Reservation_accessories');
                $module->row = $reservation_accessory;
                
                return view('la.reservation_accessories.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('reservation_accessory', $reservation_accessory);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reservation_accessory"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for editing the specified reservation_accessory.
     *
     * @param int $id reservation_accessory ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Reservation_accessories", "edit")) {
            $reservation_accessory = Reservation_accessory::find($id);
            if(isset($reservation_accessory->id)) {
                $module = Module::get('Reservation_accessories');
                
                $module->row = $reservation_accessory;
                
                return view('la.reservation_accessories.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('reservation_accessory', $reservation_accessory);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reservation_accessory"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified reservation_accessory in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id reservation_accessory ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Reservation_accessories", "edit")) {
            
            $rules = Module::validateRules("Reservation_accessories", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Reservation_accessories", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.reservation_accessories.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified reservation_accessory from storage.
     *
     * @param int $id reservation_accessory ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Reservation_accessories", "delete")) {
            Reservation_accessory::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.reservation_accessories.index');
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
        $module = Module::get('Reservation_accessories');
        $listing_cols = Module::getListingColumns('Reservation_accessories');
        
        $values = DB::table('reservation_accessories')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Reservation_accessories');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/reservation_accessories/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Reservation_accessories", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/reservation_accessories/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Reservation_accessories", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.reservation_accessories.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }

    public function getAccessories(Request $request){
        $id = $request->reservation_id;
        // $sql = "select accessories.id, accessories.name, quantity, accessories.available_quantity from reservation_accessories left join accessories on accessories.id = reservation_accessories.accessories_id where reservation_accessories.deleted_at is null and accessories.deleted_at is null and reservations_id = $id";
        $sql = "select accessories_id as name, quantity from reservation_accessories where reservation_accessories.deleted_at is null and reservations_id = $id";
        $query = DB::table(DB::raw("($sql) as catch"));
        $accessories = $query->get();
        
        return response()->json([
            'accessories' => $accessories
        ]);
    }
}
