@extends("la.layouts.app")

@section("contentheader_title", "Car Requests")
@section("contentheader_description", "Car Requests listing")
@section("section", "Car Requests")
@section("sub_section", "Listing")
@section("htmlheader_title", "Car Requests Listing")

@section("headerElems")
@la_access("Car_Requests", "create")
    
@endla_access
@endsection

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box box-purple">
    <div class="box-body">
    {!! Form::open(['action' => 'CarRequests_approveController@list_filter', 'method' => 'POST']) !!}
        <div class="row form-group">
            <div class="col-md-2">
                <label>Status</label>
                <select class="form-control input-sm" data-placeholder="Select Status" rel="select2" id="status" name="status">
                @foreach($status_lists as $status)
                    <option value="{{$status}}" name="status">{{$status}}</option>
                @endforeach
                </select>
            </div>
            
            <div class="col-sm-2">
                <label>From Date</label>
                <div class="input-group date"><input class="form-control input-sm" placeholder="Enter From Date" data-rule-minlength="0" id="from_date" name="from_date" type="text" value="{{$from_date}}"><span class="input-group-addon input_dt"><span class="fa fa-calendar"></span></span></div>
            </div>
            <div class="col-sm-2">
                <label>To Date</label>
                <div class="input-group date"><input class="form-control input-sm" placeholder="Enter To Date" data-rule-minlength="0" id="to_date" name="to_date" type="text" value="{{$to_date}}"><span class="input-group-addon input_dt"><span class="fa fa-calendar"></span></span></div>
            </div>
            <div class="col-md-1" style="margin-top:25px;">
                {{ Form::button('<i class="fa fa-search"> Search</i>', ['type' => 'submit', 'class' => 'btn btn-info btn-sm'] )  }} 
            </div>
        </div>
        {!! Form::close() !!}
        
    </div>
</div>


<div class="box box-purple">
    <!--<div class="box-header"></div>-->
    <div class="box-body">
        <table id="example1" class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Requested Person</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Destination</th>
            <th>Number of participants</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($requested_list as $requested_lists)
            <tr>
                <td>{{$requested_lists->id}}</td>
                <?php $user = DB::table('users')->where('id', $requested_lists->user_id)->first(); ?>
                <td><a href="{{ url(config('laraadmin.adminRoute') . '/carrequestsapprove/'.$requested_lists->id) }}">@if(isset($user)) {{$user->name}} @endif</a></td>
                <td><a href="{{ url(config('laraadmin.adminRoute') . '/carrequestsapprove/'.$requested_lists->id) }}">{{$requested_lists->start_date}}</a></td>
                <td><a href="{{ url(config('laraadmin.adminRoute') . '/carrequestsapprove/'.$requested_lists->id) }}">{{$requested_lists->end_date}}</a></td>
                <td>{{$requested_lists->start_time}}</td>
                <td>{{$requested_lists->end_time}}</td>
                <td>{{$requested_lists->way}}</td>
                <td>{{$requested_lists->no_of_participant}}</td>
                <td class="status {{$requested_lists->status}}" value="{{$requested_lists->status}}">{{$requested_lists->status}}</td>
                <td>
                @if($requested_lists->status == 'Requested')
                <a class="btn btn-success btn-xs" id="confirm" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$requested_lists->id}}" data-target="#ConfirmModal">Confirm</a>
                <a class="btn btn-primary btn-xs" id="pending" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$requested_lists->id}}" data-target="#PendingModal">Pending</a>
                <a class="btn btn-danger btn-xs" id="reject" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$requested_lists->id}}" data-target="#RejectModal">Reject</a> 
                @endif
                @if($requested_lists->status == 'Confirmed')
                <a class="btn btn-warning btn-xs" id="confirm" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$requested_lists->id}}" data-target="#ConfirmModal">Edit</a>
                <a class="btn btn-danger btn-xs" id="pending" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$requested_lists->id}}" data-target="#CancelModal">Cancel</a>
                @endif
                @if($requested_lists->status == 'Rejected')
                <a class="btn btn-success btn-xs" id="confirm" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$requested_lists->id}}" data-target="#ConfirmModal">Confirm</a>
                <a class="btn btn-primary btn-xs" id="pending" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$requested_lists->id}}" data-target="#PendingModal">Pending</a>
                @endif
                @if($requested_lists->status == 'Pending')
                <a class="btn btn-success btn-xs" id="confirm" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$requested_lists->id}}" data-target="#ConfirmModal">Confirm</a>
                <a class="btn btn-danger btn-xs" id="reject" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$requested_lists->id}}" data-target="#RejectModal">Reject</a> 
                @endif
                </td>  
            </tr>
        @endforeach
        </tbody>
        </table>
    </div>
</div>



<div class="modal fade in" id="ConfirmModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirmation</h4>
            </div>
            {!! Form::open(['action' => 'CarRequests_approveController@confirm', 'files' => true]) !!}
			<div class="modal-body">
                <div class="box-body">
                    <input type="hidden" class="form-control input-sm" id="carrequest_id" value="" name="carrequest_id">
                    <div class="form-group">
						<label for="name">Car Number :</label>
                    
                        <select class="js-example-basic-multiple form-control" name="car_number">
                                    <option selected disabled>Choose Car</option>
                                    @foreach($car_number as $car_no)
                                        <option value="{{$car_no->id}}">
                                            {{$car_no->car_no}}
                                        </option>
                                    @endforeach
                                </select>
                    
					</div>
                    <div class="form-group">
						<label for="name">Car Driver :</label>
						<input type="text" placeholder="Car Driver" name="car_driver" class="form-control">
					</div>
					<div class="form-group">
						<label for="name">Remark :</label>
						<textarea class="form-control module_label_edit" placeholder="Remark" name="remark"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                {!! Form::submit( 'Confirm', ['class'=>'btn btn-sm btn-success']) !!}
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
            </div>
            {!! Form::close() !!}
		</div>
	</div>
</div>


<div class="modal fade in" id="PendingModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">Pending</h4>
            </div>
            {!! Form::open(['action' => 'CarRequests_approveController@pending', 'files' => true]) !!}
			<div class="modal-body">
                <div class="box-body">
                    <input type="hidden" class="form-control input-sm" id="pcar_id" value="" name="carrequest_id">
					<div class="form-group">
						<label for="name">Remark :</label>
						<textarea class="form-control module_label_edit" placeholder="Remark" name="remark"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                {!! Form::submit( 'Pending', ['class'=>'btn btn-sm btn-info']) !!}
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
            </div>
            {!! Form::close() !!}
		</div>
	</div>
</div>

<div class="modal fade in" id="RejectModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">Reject</h4>
            </div>
            {!! Form::open(['action' => 'CarRequests_approveController@reject', 'files' => true]) !!}
			<div class="modal-body">
                <div class="box-body">
                    <input type="hidden" class="form-control input-sm" id="rcar_id" value="" name="carrequest_id">
					<div class="form-group">
						<label for="name">Remark :</label>
						<textarea class="form-control module_label_edit" placeholder="Remark" name="remark"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                {!! Form::submit( 'Reject', ['class'=>'btn btn-sm btn-danger']) !!}
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
            </div>
            {!! Form::close() !!}
		</div>
	</div>
</div>


<div class="modal fade in" id="CancelModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">Cancel</h4>
            </div>
            {!! Form::open(['action' => 'CarRequests_approveController@cancel', 'files' => true]) !!}
			<div class="modal-body">
                <div class="box-body">
                    <input type="hidden" class="form-control input-sm" id="ccar_id" value="carrequest_id" name="carrequest_id">
					<div class="form-group">
						<label for="name">Remark <span style='color:red;'>*</span>:</label>
						<textarea class="form-control module_label_edit" placeholder="Remark" name="remark"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                {!! Form::submit( 'Reject', ['class'=>'btn btn-sm btn-danger']) !!}
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
            </div>
            {!! Form::close() !!}
		</div>
	</div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>

$("#example1").DataTable({
        
    });

$("#ConfirmModal").on("show.bs.modal", function(e){
        var modal = $(this);
        var link = $(e.relatedTarget);
        var id = link.data('target-id');
        modal.find('#carrequest_id').val(id);
    });
$("#PendingModal").on("show.bs.modal", function(e){
    var modal = $(this);
    var link = $(e.relatedTarget);
    var id = link.data('target-id');
    modal.find('#pcar_id').val(id);
});
$("#RejectModal").on("show.bs.modal", function(e){
    var modal = $(this);
    var link = $(e.relatedTarget);
    var id = link.data('target-id');
    modal.find('#rcar_id').val(id);
});
$("#CancelModal").on("show.bs.modal", function(e){
    var modal = $(this);
    var link = $(e.relatedTarget);
    var id = link.data('target-id');
    modal.find('#ccar_id').val(id);
});
</script>


@endpush
