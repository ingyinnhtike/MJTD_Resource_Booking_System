@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/all_schedules') }}">All Schedule</a> :
@endsection
@section("contentheader_description", $all_schedule->$view_col)
@section("section", "All Schedules")
@section("section_url", url(config('laraadmin.adminRoute') . '/all_schedules'))
@section("sub_section", "Edit")

@section("htmlheader_title", "All Schedules Edit : ".$all_schedule->$view_col)

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
    <div class="box-header">
        
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {!! Form::model($all_schedule, ['route' => [config('laraadmin.adminRoute') . '.all_schedules.update', $all_schedule->id ], 'method'=>'PUT', 'id' => 'all_schedule-edit-form']) !!}
                    @la_form($module)
                    
                    <div class="form-group col-sm-12">
                        <div class="col-sm-6">
                            {!! Form::submit( 'Update', ['class'=>'btn btn-sm btn-info pull-right']) !!} 
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ url(config('laraadmin.adminRoute') . '/all_schedules') }}" class="btn btn-sm btn-default">Cancel</a>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
    $("#all_schedule-edit-form").validate({
        
    });
});
</script>
@endpush
