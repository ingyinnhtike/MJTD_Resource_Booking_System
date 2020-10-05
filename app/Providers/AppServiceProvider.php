<?php

namespace App\Providers;

use DB;
use View;
use Module;
use App\SlotOne;
use App\Models\All_Schedule;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    
    public function boot()
    {
        $module = Module::get('Resources');
        View::share(['module' => $module]);

        $resources = DB::table('all_schedules')
            ->select('resources.name', 'all_schedules.schedule_name')
            ->join('resources', 'all_schedules.id', '=', 'resources.schedule')
            ->get();
        View::share(['resources' => $resources]);

        $schedules = DB::table('all_schedules')->select('*')->get();
        View::share(['schedules' => $schedules]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
