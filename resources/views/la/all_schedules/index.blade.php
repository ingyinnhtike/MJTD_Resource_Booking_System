@extends("la.layouts.app")
@section("contentheader_title", "All Schedules")
@section("contentheader_description", "All Schedules listing")
@section("section", "All Schedules")
@section("sub_section", "Listing")
@section("htmlheader_title", "All Schedules Listing")

@section("headerElems")
@la_access("All_Schedules", "create")
<button class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#AddModal"><i class="fa fa-plus"></i> Add New Schedule</button>
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
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
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
@la_access("All_Schedules", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add All Schedule</h4>
            </div>
            {!! Form::open(['action' => 'LA\All_SchedulesController@store', 'id' => 'all_schedule-add-form']) !!}
            <div class="modal-body">
                <div class="box-body">
                    @la_form($module)
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                {!! Form::submit( 'Submit', ['class'=>'btn btn-sm btn-info']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endla_access
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/mine.css') }}"/>
@endpush
@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
    $("#example1").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/all_schedule_dt_ajax') }}",
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
        @if($show_actions)
        columnDefs: [ { orderable: false, targets: [-1] }],
        @endif
    });
    
    $("#all_schedule-add-form").validate({

    });
});
</script>
@endpush