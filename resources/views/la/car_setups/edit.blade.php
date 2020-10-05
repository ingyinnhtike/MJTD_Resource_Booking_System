@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/car_setups') }}">Car Setup</a> :
@endsection
@section("contentheader_description", $car_setup->$view_col)
@section("section", "Car Setups")
@section("section_url", url(config('laraadmin.adminRoute') . '/car_setups'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Car Setups Edit : ".$car_setup->$view_col)

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
                {!! Form::model($car_setup, ['route' => [config('laraadmin.adminRoute') . '.car_setups.update', $car_setup->id ], 'method'=>'PUT', 'id' => 'car_setup-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'car_no')
					@la_input($module, 'driver_name')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/car_setups') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#car_setup-edit-form").validate({
        
    });
});
</script>
@endpush
