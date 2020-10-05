<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Carbon\Carbon;
use Zizaco\Entrust\EntrustFacade as Entrust;
use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Reservation;
use App\Models\Car_Setup;
class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookinglist=Reservation::all();
        $user = Auth::user();
        $resource = DB::table('resources')
            ->select('resources.id','name')
            ->leftJoin('reservations', 'resources.id', '=', 'reservations.resource_id')
            ->get();
            foreach($bookinglist as $key=>$data)
            {
                $newarr=array();
                $newarr['id']=$data->id;
                $newarr['title']=$data->title;
                $newarr['description']=$data->description;
                $newarr['resourcename']=$resource[$key]->name;
                $newarr['begin_date']=$data->begin_date;
                $newarr['begin_time']=$data->begin_time;
                $newarr['end_date']=$data->end_date;
                $newarr['end_time']=$data->end_time;
                $newarr['no_of_participant']=$data->no_of_participant;
                $newarr['username']=$user->name;
                $newarr['no_of_participant']=$data->no_of_participant;
                $results[]=$newarr;
            }
            
            return view('la.Reports.Detailsbookingreport')->with('results',$results);
        
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function bookingreport_filter(Request $request)
    {
        $query = "";
        $today = date("Y-m-d");
        $input_from_date = '';
        $input_to_date = '';
        $resourcename='0';
        $bookinglist=Reservation::get();
        //dd($bookinglist);
        $user = Auth::user();
        $user_id=DB::table('users')
                ->join('reservations', 'users.id', '=', 'reservations.owner_id')
                ->select('users.name')
                ->get();
        // dd($user_id);
        $resources=Resource::all();
        $today = date('Y-m-d h:i:s');
        $hr=date('H:i');
        $id=Auth::user()->id;
        
        if(Entrust::hasRole("SUPER_ADMIN") || Entrust::hasRole("RECEPTION")){
            $sql = "select reservations.id, reservations.title,reservations.description,reservations.owner_id, reservations.begin_date, reservations.end_date,
                reservations.begin_time, reservations.end_time, reservations.no_of_participant,
                resources.name as resourcename,resources.id as resourcesid,users.name as username from reservations join resources on resources.id = reservations.resource_id join users on users.id = reservations.owner_id
                where reservations.deleted_at is null and resources.deleted_at is null";
                $query = DB::table(DB::raw("($sql) as catch"));
        }else {
           
            $sql = "select reservations.id, reservations.title,reservations.description, reservations.owner_id, reservations.begin_date, reservations.end_date,
                reservations.begin_time, reservations.end_time, reservations.no_of_participant,
                resources.name as resourcename, resources.id as resourcesid,users.name as username from reservations join resources on resources.id = reservations.resource_id join users on users.id = reservations.owner_id
                where reservations.deleted_at is null and resources.deleted_at is null and reservations.owner_id = $id";
                $query = DB::table(DB::raw("($sql) as catch"));
                //dd($query);
        }
                
        $from_date = Carbon::now()->startOfMonth()->toDateString();
        $to_date = Carbon::now()->endOfMonth()->toDateString();
        $input_from_date = Carbon::createFromFormat('Y-m-d', $from_date)->format('d/m/Y');
        $input_to_date = Carbon::createFromFormat('Y-m-d', $to_date)->format('d/m/Y');
        
        //filter
        if($request->has('resourcename')){
            $resourcename = $request->input('resourcename');
            //dd($resourcename);
        }
        
        if($request->has('from_date') && $request->input('from_date') != ''){
            $input_from_date = $request->input('from_date');
            $from_date = Carbon::createFromFormat('d/m/Y', $input_from_date)->format('Y-m-d');
        }
        
        if($request->has('to_date') && $request->input('to_date') != ''){
            $input_to_date = $request->input('to_date');
            $to_date = Carbon::createFromFormat('d/m/Y', $input_to_date)->format('Y-m-d');
        }

        if(isset($from_date) && $from_date != ""){
            $query = $query->whereDate('begin_date', '>=', $from_date);
        }
        if(isset($to_date) && $to_date != ""){
            $query = $query->whereDate('end_date', '<=', $to_date);
        }
        if(isset($resourcename) && $resourcename != "0"){
            $query = $query->where('resourcesid', '=', $resourcename);
        }
        $all_bookinglists = $query->get();

        $results = array();
            foreach($all_bookinglists as $key=>$data)
            {
                $newarr=array();
                $newarr['id']=$data->id;
                $newarr['title']=$data->title;
                $newarr['description']=$data->description;
                $newarr['resourcename']=$data->resourcename;
                $newarr['resourceid']=$data->id;
                $newarr['begin_date']=$data->begin_date;
                $newarr['begin_time']=$data->begin_time;
                $newarr['end_date']=$data->end_date;
                $newarr['end_time']=$data->end_time;
                $newarr['no_of_participant']=$data->no_of_participant;
                $newarr['username']=$data->username;
                $results[] = $newarr;
            }
        return View('la.Reports.Detailsbookingreport', [
            'from_date' => $input_from_date,
            'to_date' => $input_to_date,
            'results' => $results,
            'resources' => $resources,
            'today' => $today,
            'hr' => $hr
        ]);
        
    }

    public function carrequestedreport_filter(Request $request)
    {
        
        $query = "";
        $today = date("Y-m-d");
        $input_from_date = '';
        $input_to_date = '';
        $carnumber='0';
        $user = Auth::user();
        $car_lists = Car_Setup::whereNull('deleted_at')->get();
        
        $today = date('Y-m-d h:i:s');
        $hr=date('H:i');
        $id=Auth::user()->id;
        
        if(Entrust::hasRole("SUPER_ADMIN") || Entrust::hasRole("RECEPTION")){
            $sql = "select car_requests.id, car_requests.start_date, car_requests.end_date,
                    car_requests.start_time, car_requests.end_time, car_requests.way,car_requests.no_of_participant,
                    car_requests.remark, car_requests.car_number, car_requests.car_driver, car_requests.status,
                    users.name as username, car_setups.car_no as car_no from car_requests 
                    join users on users.id = car_requests.user_id join car_setups on car_setups.id = car_requests.car_number
                    where car_requests.deleted_at is null and users.deleted_at is null";
                $query = DB::table(DB::raw("($sql) as catch"));
                
        }else{
            $sql = "select car_requests.id, car_requests.start_date, car_requests.end_date,
                    car_requests.start_time, car_requests.end_time, car_requests.way,car_requests.no_of_participant,
                    car_requests.remark, car_requests.car_number, car_requests.car_driver, car_requests.status,
                    users.name as username from car_requests 
                    join users on users.id = car_requests.user_id
                    where car_requests.deleted_at is null and users.deleted_at is null and car_requests.user_id = $id";
                $query = DB::table(DB::raw("($sql) as catch"));
                
        }
                
        $from_date = Carbon::now()->startOfMonth()->toDateString();
        $to_date = Carbon::now()->endOfMonth()->toDateString();
        $input_from_date = Carbon::createFromFormat('Y-m-d', $from_date)->format('d/m/Y');
        $input_to_date = Carbon::createFromFormat('Y-m-d', $to_date)->format('d/m/Y');
        
        //filter
        $carnumber = null;
        if($request->has('car_number')){
            $carnumber = $request->input('car_number');
            
        }
        
        if($request->has('from_date') && $request->input('from_date') != ''){
            $input_from_date = $request->input('from_date');
            $from_date = Carbon::createFromFormat('d/m/Y', $input_from_date)->format('Y-m-d');
        }
        
        if($request->has('to_date') && $request->input('to_date') != ''){
            $input_to_date = $request->input('to_date');
            $to_date = Carbon::createFromFormat('d/m/Y', $input_to_date)->format('Y-m-d');
        }

        if(isset($from_date) && $from_date != ""){
            $query = $query->whereDate('start_date', '>=', $from_date);
        }
        if(isset($to_date) && $to_date != ""){
            $query = $query->whereDate('end_date', '<=', $to_date);
        }
        if(isset($carnumber) && $carnumber != "0"){
            $query = $query->where('car_number', '=', $carnumber);
        }
        $car_requestedlists = $query->get();
        //dd($car_requestedlists);
        

        return View('la.Reports.CarRequestedList_Report', [
            'from_date' => $input_from_date,
            'to_date' => $input_to_date,
            'results' => $car_requestedlists,
            'today' => $today,
            'hr' => $hr,
            'car_lists' => $car_lists,
            'carnumber' => $carnumber
        ]);
        
    }

}
