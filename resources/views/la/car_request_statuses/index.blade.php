@extends("la.layouts.app")

@section("contentheader_title", "Car Request Statuses")
@section("contentheader_description", "Car Request Statuses listing")
@section("section", "Car Request Statuses")
@section("sub_section", "Listing")
@section("htmlheader_title", "Car Request Statuses Listing")

@section("headerElems")
@la_access("Car_Request_Statuses", "create")
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

<div class="box box-success">
    <!--<div class="box-header"></div>-->
    <div class="box-body">
        <table id="example1" class="table table-bordered">
        <thead>
        <tr class="success">
            <th>ID</th>
            <th>Requested Person</th>
            <th>Status</th>
            <th>Date</th>
            <th>Remark</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($request_status as $request_statuses)
        <tr>
            <td>{{$request_statuses->id}}</td>
            <?php $user = DB::table('users')->where('id', $request_statuses->requestedperson_id)->first(); ?>
            <td>@if(isset($user)) {{$user->name}} @endif</td>
            <td>{{$request_statuses->status}}</td>
            <td>{{$request_statuses->date}}</td>
            <td>{{$request_statuses->remark}}</td>
            <td>
                <a href="{{ url(config('laraadmin.adminRoute') . '/create_new_tasks/'.$request_statuses->id . '/edit') }}" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;">Edit</i></a>
                <a href="{{ url(config('laraadmin.adminRoute') . '/create_new_tasks/'.$request_statuses->id . '/cancel') }}" class="btn btn-danger btn-xs" style="display:inline;padding:2px 5px 3px 5px;">Cancel</i></a>
            </td>
        </tr>
        @endforeach
        </tbody>
        </table>
    </div>
</div>

@la_access("Car_Request_Statuses", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Car Request Status</h4>
            </div>
            {!! Form::open(['action' => 'LA\Car_Request_StatusesController@store', 'id' => 'car_request_status-add-form']) !!}
            <div class="modal-body">
                <div class="box-body">
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'requestedperson_id')
					@la_input($module, 'status')
					@la_input($module, 'date')
					@la_input($module, 'remark')
					@la_input($module, 'car_requested_id')
                    --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
    $("#example1").DataTable({
        processing: true,
        @if($show_actions)
        columnDefs: [ { orderable: false, targets: [-1] }],
        @endif
    });
    $("#car_request_status-add-form").validate({
        
    });
});
</script>
@endpush
