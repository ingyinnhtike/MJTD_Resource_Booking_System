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
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Car_Request;
use DB;
use Auth;
use Zizaco\Entrust\EntrustFacade as Entrust;
/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_id=$user->id;
        
        $now_str = \Carbon\Carbon::now()->format('Y-m-d');
        
        if(Entrust::hasRole("SUPER_ADMIN") || Entrust::hasRole("RECEPTION"))
        {
            $sql = "SELECT distinct reservations.id as res_id, reservations.* FROM reservations left join reservations_users on reservations_users.reservations_id = reservations.id where reservations.deleted_at is null and date_format(date(reservations.begin_date), '%Y-%m-%d') >= DATE_FORMAT(now(), '%Y-%m-%d') and reservations.status = 'Confirmed' order by reservations.begin_date";
        }else{
            $sql = "SELECT distinct reservations.id as res_id, reservations.* FROM reservations left join reservations_users on reservations_users.reservations_id = reservations.id where reservations.deleted_at is null and date_format(date(reservations.begin_date), '%Y-%m-%d') >= DATE_FORMAT(now(), '%Y-%m-%d') and (reservations.owner_id = $user_id or reservations_users.user_id = $user_id) and reservations.status = 'Confirmed' order by reservations.begin_date";
            
        }
        $query = DB::table(DB::raw("($sql) as catch"));
        $bookinglist = $query->get();
        
        foreach ($bookinglist as $booking) {
            $booking->resource = DB::table('resources')
                                ->where('id', $booking->resource_id)
                                ->whereNull('deleted_at')
                                ->first();
            $booking->reserved_by = DB::table('users')
                                ->where('id', $booking->owner_id)
                                ->whereNull('deleted_at')
                                ->first();
        }
        
        if(Entrust::hasRole("SUPER_ADMIN") || Entrust::hasRole("RECEPTION"))
        {
            $sql = "SELECT distinct reservations.* FROM reservations left join reservations_users on reservations_users.reservations_id = reservations.id where reservations.deleted_at is null order by reservations.begin_date";
            
        }else{
            $sql = "SELECT distinct reservations.* FROM reservations left join reservations_users on reservations_users.reservations_id = reservations.id where reservations.deleted_at is null and (reservations.owner_id = $user_id or reservations_users.user_id = $user_id) order by reservations.begin_date";
        }
        $query = DB::table(DB::raw("($sql) as catch"));
        $reservations = $query->get(); 
        //dd($reservations);
        
        if(Entrust::hasRole("SUPER_ADMIN") || Entrust::hasRole("RECEPTION"))
        {
            $car_booked_lists = Car_Request::whereDate('start_date', '>=', $now_str)->whereNull('deleted_at')->where('status', '=', 'Confirmed')->orderBy('start_date')->get();
        }else{
            $car_booked_lists = Car_Request::whereDate('start_date', '>=', $now_str)->whereNull('deleted_at')->where('status', '=', 'Confirmed')->where('user_id', '=', $user_id)->orderBy('start_date')->get();
        }
        foreach ($car_booked_lists as $car_booked_list) {
            $car_booked_list->reserved_by = DB::table('users')
                                ->where('id', $car_booked_list->user_id)
                                ->whereNull('deleted_at')
                                ->first();
            $car_booked_list->car_number = DB::table('car_setups')
                                ->where('id', $car_booked_list->car_number)
                                ->whereNull('deleted_at')
                                ->first();
        }

        //requested reservations
        if(Entrust::hasRole("SUPER_ADMIN") || Entrust::hasRole("RECEPTION"))
        {
            $sql = "SELECT distinct reservations.id as res_id, reservations.* FROM reservations left join reservations_users on reservations_users.reservations_id = reservations.id where reservations.deleted_at is null and reservations.status = 'Requested' order by reservations.begin_date";
        }
        $query = DB::table(DB::raw("($sql) as catch"));
        $requested_bookinglist = $query->get();
        
        foreach ($requested_bookinglist as $booking) {
            $booking->resource = DB::table('resources')
                                ->where('id', $booking->resource_id)
                                ->whereNull('deleted_at')
                                ->first();
            $booking->reserved_by = DB::table('users')
                                ->where('id', $booking->owner_id)
                                ->whereNull('deleted_at')
                                ->first();
        }
        //requested car bookings
        if(Entrust::hasRole("SUPER_ADMIN") || Entrust::hasRole("RECEPTION"))
        {
            $car_requested_lists = Car_Request::whereNull('deleted_at')->where('status', '=', 'Requested')->orderBy('start_date')->get();
        }else
        {
            $car_requested_lists = Car_Request::whereNull('deleted_at')->where('status', '=', 'Requested')->orderBy('start_date')->where('user_id', '=', $user_id)->get();
        }
        foreach ($car_requested_lists as $car_request_list) {
            $car_request_list->reserved_by = DB::table('users')
                                ->where('id', $car_request_list->user_id)
                                ->whereNull('deleted_at')
                                ->first();
            $car_request_list->car_number = DB::table('car_setups')
                                ->where('id', $car_request_list->car_number)
                                ->whereNull('deleted_at')
                                ->first();
        }

        return view('la.dashboard',compact('car_booked_lists', 'bookinglist', 'reservations', 'requested_bookinglist', 'car_requested_lists'));
    }
}