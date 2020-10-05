@extends('la.layouts.app')

@section('htmlheader_title')
    Car Request View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
   

    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
        <li class=""><a href="javascript:history.back()" data-toggle="tooltip" data-placement="right" title="Back to Car Requests"><i class="fa fa-chevron-left"></i></a></li>
        <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
       
       
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active fade in" id="tab-info">
            <div class="tab-content">
                <div class="panel infolist">
                    <div class="panel-default panel-heading">
                        <h4>General Info</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group pull-right">
                            @if($car_request->status == 'Requested')
                            <a class="btn btn-success btn-xs" id="confirm" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$car_request->id}}" data-target="#ConfirmModal">Confirm</a>
                            <a class="btn btn-primary btn-xs" id="pending" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$car_request->id}}" data-target="#PendingModal">Pending</a>
                            <a class="btn btn-danger btn-xs" id="reject" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$car_request->id}}" data-target="#RejectModal">Reject</a> 
                            @endif
                            @if($car_request->status == 'Confirmed')
                            <a class="btn btn-warning btn-xs" id="confirm" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$car_request->id}}" data-target="#ConfirmModal">Edit</a>
                            <a class="btn btn-danger btn-xs" id="pending" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$car_request->id}}" data-target="#CancelModal">Cancel</a>
                            @endif
                            @if($car_request->status == 'Rejected')
                            <a class="btn btn-success btn-xs" id="confirm" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$car_request->id}}" data-target="#ConfirmModal">Confirm</a>
                            <a class="btn btn-primary btn-xs" id="pending" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$car_request->id}}" data-target="#PendingModal">Pending</a>
                            @endif
                            @if($car_request->status == 'Pending')
                            <a class="btn btn-success btn-xs" id="confirm" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$car_request->id}}" data-target="#ConfirmModal">Confirm</a>
                            <a class="btn btn-danger btn-xs" id="reject" style="display:inline;padding:2px 5px 3px 5px;" data-toggle="modal" data-target-id="{{$car_request->id}}" data-target="#RejectModal">Reject</a> 
                            @endif
                        </div>
                        <div class="form-group">
                                <label class="col-md-4 col-sm-6 col-xs-6">Requested By :</label>
                                <?php $user = DB::table('users')->wherenull('deleted_at')->where('id', $car_request->user_id)->first(); ?>
                                <div class="col-md-8 col-sm-6 col-xs-6">{{ $user->name }}</div>
                        </div>
                        <div class="form-group">
                                <label class="col-md-4 col-sm-6 col-xs-6">Requested Date :</label>
                                <div class="col-md-8 col-sm-6 col-xs-6">{{ $car_request->created_at }}</div>
                        </div>
						@la_display($module, 'start_date', '', 'write')
						@la_display($module, 'end_date', '', 'write')
						@la_display($module, 'start_time', '', 'write')
						@la_display($module, 'end_time', '', 'write')
						@la_display($module, 'way', '', 'write')
						@la_display($module, 'no_of_participant', '', 'write')
						@la_display($module, 'participants', '', 'write')
                        @la_display($module, 'purpose', '', 'write')
						@la_display($module, 'remark', '', 'write')
                        @if($car_request->status == 'Confirmed')
                        <div class="form-group">
                                <label class="col-md-4 col-sm-6 col-xs-6">Car Driver :</label>
                                <div class="col-md-8 col-sm-6 col-xs-6">{{ $car_request->car_driver }}</div>
                        </div>
                        <div class="form-group">
                                <label class="col-md-4 col-sm-6 col-xs-6">Car Number :</label>
                                @foreach($car_number as $car_no)
                                @if($car_no->id == $car_request->car_number)
                                <div class="col-md-8 col-sm-6 col-xs-6">{{ $car_no->car_no }}</div>
                                @endif
                                @endforeach
                        </div>
                        <div class="form-group">
                                <label class="col-md-4 col-sm-6 col-xs-6">Status :</label>
                                <div class="col-md-8 col-sm-6 col-xs-6">{{ $car_request->status }}</div>
                        </div>
                        @endif
                        <div class="panel-default panel-heading">
                            <h4>History</h4>
                        </div>
                        
                        <table class="table"> 
                            <tr>
                                <th>User</th>
                                <th>Status</th>
                                <th>Effected Date</th>
                                <th>Remark</th>
                            </tr>
                            @foreach($status_histories as $status_history)
                            <tr>
                                <td> <?php $user = DB::table('users')->wherenull('deleted_at')->where('id', $status_history->requestedperson_id)->first(); ?>
                                {{ $user->name }}</td>
                                <td>{{ $status_history->status }}</td>
                                <td>{{ $status_history->created_at }}</td>
                                <td>{{ $status_history->remark }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
       
        
    </div>
    </div>
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


@push('scripts')
<script>

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