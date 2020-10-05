@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/room_types') }}">Room Type</a> :
@endsection
@section("contentheader_description", $room_type->$view_col)
@section("section", "Room Types")
@section("section_url", url(config('laraadmin.adminRoute') . '/room_types'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Room Types Edit : ".$room_type->$view_col)

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
                {!! Form::model($room_type, ['route' => [config('laraadmin.adminRoute') . '.room_types.update', $room_type->id ], 'method'=>'PUT', 'id' => 'room_type-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'name')
					@la_input($module, 'description')
					@la_input($module, 'image')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-info']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/room_types') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#room_type-edit-form").validate({
        
    });
});
</script>
@endpush
