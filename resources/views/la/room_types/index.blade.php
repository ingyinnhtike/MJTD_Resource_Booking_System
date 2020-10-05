@extends("la.layouts.app")

@section("contentheader_title", "Room Types")
@section("contentheader_description", "Room Types listing")
@section("section", "Room Types")
@section("sub_section", "Listing")
@section("htmlheader_title", "Room Types Listing")

@section("headerElems")
@la_access("Room_Types", "create")
    <button class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Room Type</button>
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
    <!--<div class="box-header"></div>-->
    <div class="box-body">
        <table id="example1" class="table table-bordered">
        <thead>
        <tr class="">
            @foreach( $listing_cols as $col )
            <th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
            @endforeach
            @if($show_actions)
            <th>Actions</th>
            @endif
        </tr>
        </thead>
        <tbody>
            
        </tbody>
        </table>
    </div>
</div>

@la_access("Room_Types", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Room Type</h4>
            </div>
            {!! Form::open(['action' => 'LA\Room_TypesController@store', 'id' => 'room_type-add-form', 'files' => true]) !!}
            <div class="modal-body">
                <div class="box-body">
                    
                    @la_input($module, 'name')
					@la_input($module, 'description')
					<div>
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image">
                    </div>
                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {!! Form::submit( 'Submit', ['class'=>'btn btn-info']) !!}
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
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/room_type_dt_ajax') }}",
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
        @if($show_actions)
        columnDefs: [ { orderable: false, targets: [-1] }],
        @endif
    });
    $("#room_type-add-form").validate({
        
    });


    
});



</script>
@endpush
