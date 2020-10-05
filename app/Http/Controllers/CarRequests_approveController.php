<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Car_Request;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Car_Request_Status;
use App\Models\Car_Setup;
use Module;

class CarRequests_approveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requested_list=Car_Request::get();
        $car_number=Car_Setup::get();
        
        $status_lists=array('All', 'Requested', 'Confirmed', 'Rejected', 'Pending');
        $from_date = Carbon::now()->startOfMonth()->toDateString();
        $to_date = Carbon::now()->endOfMonth()->toDateString();
        $input_from_date = Carbon::createFromFormat('Y-m-d', $from_date)->format('d/m/Y');
        $input_to_date = Carbon::createFromFormat('Y-m-d', $to_date)->format('d/m/Y');

        return View('la.CarRequests_approve.requested_list', [
            'requested_list' => $requested_list,
            'status_lists' => $status_lists,
            'from_date' => $input_from_date,
            'to_date' => $input_to_date,
            'car_number' => $car_number
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         
        $car_number = DB::table('car_setups')
            // ->join('car_requests', 'car_setups.id', '=', 'car_requests.car_number')
            // ->select('car_setups.car_no')
            // ->where('car_requests.id', '=', $id)
            ->whereNull('deleted_at')
            ->get();
        //dd($car_number['0']);
        $car_request = Car_Request::find($id);
        
        if(isset($car_request->id)) {
            $module = Module::get('Car_Requests');
            $module->row = $car_request;

            $status_histories = Car_Request_Status::where('car_requested_id', $id)->get();
            
            return view('la.CarRequests_approve.show', [
                'module' => $module,
                'view_col' => $module->view_col,
                'no_header' => true,
                'no_padding' => "no-padding"
            ])->with('car_request', $car_request)
              ->with('status_histories', $status_histories)
              ->with('car_number',$car_number);
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function confirm(Request $request){
        
        $this->validate($request, [
            'car_number' => 'required',
            'car_driver' => 'required',
        ]);

        $user=Auth::user();
        $user_id=$user->id;
        
        $id = $request->input('carrequest_id');
        $car_number = $request->input('car_number');
        $car_driver = $request->input('car_driver');
        $remark = $request->input('remark');
        
        DB:: table('car_requests')->where('id', $id)->update(['status' => 'Confirmed', 'car_number' => $car_number, 'car_driver' => $car_driver]);
        $today= date('Y-m-d');
        
        $car_request_status = Car_Request_Status::create([
            'requestedperson_id' => $user_id,
            'status' => "Confirmed",
            'date' => $today,
            'remark' => $remark,
            'car_requested_id' => $id
            
        ]);
         
        return redirect(config('laraadmin.adminRoute') . "/carrequestsapprove");
    }

    public function pending(Request $request){
        $this->validate($request, [
            'remark' => 'required',
            
        ]);
        $user=Auth::user();
        $user_id=$user->id;
        $id = $request->input('carrequest_id');
        $remark = $request->input('remark');
        $today= date('Y-m-d');
        DB:: table('car_requests')->where('id', $id)->update(['status' => 'Pending']);
        $today= date('Y-m-d');
            $car_request_status = Car_Request_Status::create([
                'requestedperson_id' => $user_id,
                'status' => "Pending",
                'date' => $today,
                'remark' => $remark,
                'car_requested_id' => $id
                
            ]);
        return redirect(config('laraadmin.adminRoute') . "/carrequestsapprove");
    }

    public function reject(Request $request){
        $this->validate($request, [
            'remark' => 'required',
            
        ]);
        $user=Auth::user();
        $user_id=$user->id;
        $id = $request->input('carrequest_id');
        $remark = $request->input('remark');
        $today= date('Y-m-d');
        DB:: table('car_requests')->where('id', $id)->update(['status' => 'Rejected']);
        $today= date('Y-m-d');
            $car_request_status = Car_Request_Status::create([
                'requestedperson_id' => $user_id,
                'status' => "Reject",
                'date' => $today,
                'remark' => $remark,
                'car_requested_id' => $id
                
            ]);
        return redirect(config('laraadmin.adminRoute') . "/carrequestsapprove");
    }

    public function cancel(Request $request){
        $this->validate($request, [
            'remark' => 'required',
            
        ]);
        $user=Auth::user();
        $user_id=$user->id;
        $id = $request->input('carrequest_id');
        $remark = $request->input('remark');
        $today= date('Y-m-d');
        
        $today= date('Y-m-d');
            $car_request_status = Car_Request_Status::create([
                'requestedperson_id' => $user_id,
                'status' => "Canceled",
                'date' => $today,
                'remark' => $remark,
                'car_requested_id' => $id
                
            ]);
        DB:: table('car_requests')->where('id', $id)->delete();
        return redirect(config('laraadmin.adminRoute') . "/carrequestsapprove");
    }


    public function list_filter(Request $request)
    {
        
        $selected_status = "";
        $today = date("Y-m-d");
        $input_from_date = '';
        $input_to_date = '';

        $query = DB::table('car_requests')
            ->select('id','user_id','start_date','end_date','start_time','end_time','no_of_participant','way','status','remark');
        $car_number = DB::table('car_setups')
            ->join('car_requests', 'car_setups.id', '=', 'car_requests.car_number')
            ->select('car_setups.car_no')
            ->wherenull('car_requests.id')
            ->get();   
        $from_date = Carbon::now()->startOfMonth()->toDateString();
        $to_date = Carbon::now()->endOfMonth()->toDateString();
        $input_from_date = Carbon::createFromFormat('Y-m-d', $from_date)->format('d/m/Y');
        $input_to_date = Carbon::createFromFormat('Y-m-d', $to_date)->format('d/m/Y');

        //filter
        if($request->has('status')){
            $selected_status = $request->input('status');
        }
        if($request->has('from_date') && $request->input('from_date') != ''){
            $input_from_date = $request->input('from_date');
            $from_date = Carbon::createFromFormat('d/m/Y', $input_from_date)->format('Y-m-d');
        }
        if($request->has('to_date') && $request->input('to_date') != ''){
            $input_to_date = $request->input('to_date');
            $to_date = Carbon::createFromFormat('d/m/Y', $input_to_date)->format('Y-m-d');
        }
        
        //list of status
        $status_lists = array('All', 'Requested', 'Confirmed', 'Rejected', 'Pending');

        if(isset($selected_status) && $selected_status != "All"){
            $query = $query->where('status', '=', $selected_status);
        }

        if(isset($from_date) && $from_date != ""){
            $query = $query->whereDate('start_date', '>=', $from_date);
        }
        if(isset($to_date) && $to_date != ""){
            $query = $query->whereDate('end_date', '<=', $to_date);
        }
        $requested_list = $query->get();

        return View('la.CarRequests_approve.requested_list', [
            'requested_list' => $requested_list,
            'status_lists' => $status_lists,
            'selected_status' => $selected_status,
            'from_date' => $input_from_date,
            'to_date' => $input_to_date,
            'car_number' => $car_number
        ]);
    }

}
