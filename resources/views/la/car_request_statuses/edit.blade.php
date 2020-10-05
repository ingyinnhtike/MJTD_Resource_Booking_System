@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/car_request_statuses') }}">Car Request Status</a> :
@endsection
@section("contentheader_description", $car_request_status->$view_col)
@section("section", "Car Request Statuses")
@section("section_url", url(config('laraadmin.adminRoute') . '/car_request_statuses'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Car Request Statuses Edit : ".$car_request_status->$view_col)

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

<div class="box">
    <div class="box-header">
        
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {!! Form::model($car_request_status, ['route' => [config('laraadmin.adminRoute') . '.car_request_statuses.update', $car_request_status->id ], 'method'=>'PUT', 'id' => 'car_request_status-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'requestedperson_id')
					@la_input($module, 'status')
					@la_input($module, 'date')
					@la_input($module, 'remark')
					@la_input($module, 'car_requested_id')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/car_request_statuses') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#car_request_status-edit-form").validate({
        
    });
});
</script>
@endpush
