<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
	<ul class="nav navbar-nav">
		<li><a href="{{ url(config('laraadmin.adminRoute')) }}">Dashboard</a></li>
		<li><a href="{{ url(config('laraadmin.adminRoute') . '/calendar') }}">Calendar</a></li>
		<li><a href="{{ url(config('laraadmin.adminRoute') . '/bookinglist') }}">BookingList</a></li>
		@if(Entrust::hasRole("RECEPTION") || Entrust::hasRole("SUPER_ADMIN"))
            <li><a href="{{ url(config('laraadmin.adminRoute') . '/carrequestsapprove') }}">CarRequestedList</a></li>
        @endif
		
		<?php $all_schedule = App\Models\All_Schedule::All(); ?>
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="{{ url(config('laraadmin.adminRoute') . '/reservations') }}"> Reservations <span class="caret"></span></a>
			<ul class="dropdown-menu">
				@foreach($all_schedule as $all_schedules)
				<li><a href="{{route('admin.reservations.show',$all_schedules->id)}}">{{$all_schedules->schedule_name}}</a><li>
				@endforeach
				<li><a href="{{ url(config('laraadmin.adminRoute') . '/car_requests') }}">Car</a><li>
			</ul>
		</li>
		<?php
		$menuItems = Dwij\Laraadmin\Models\Menu::where("parent", 0)->orderBy('hierarchy', 'asc')->get();
		?>
		@foreach ($menuItems as $menu)
			@if($menu->type == "module")
				<?php
				$temp_module_obj = Module::get($menu->name);
				?>
				@la_access($temp_module_obj->id)
					@if(isset($module->id) && $module->name == $menu->name)
						<?php echo LAHelper::print_menu_topnav($menu ,true); ?>
					@else
						<?php echo LAHelper::print_menu_topnav($menu); ?>
					@endif
				@endla_access
			@else
				<?php echo LAHelper::print_menu_topnav($menu); ?>
			@endif
		@endforeach
		@if(Entrust::hasRole("SUPER_ADMIN") || Entrust::hasRole("RECEPTION") )
			<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href=""> Reports <span class="caret"></span></a>
				<ul class="dropdown-menu">
					
					<li><a href="{{ url(config('laraadmin.adminRoute') . '/bookingreports') }}">Detail Booking Report</a><li>
					
					<li><a href="{{ url(config('laraadmin.adminRoute') . '/carrequestedreports') }}">Car Requested List Report</a><li>
				</ul>
			</li>
        @endif
	</ul>

	@if(LAConfigs::getByKey('sidebar_search'))
	<form class="navbar-form navbar-left" role="search">
		<div class="form-group">
			<input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
		</div>
	</form>
	@endif
</div><!-- /.navbar-collapse -->