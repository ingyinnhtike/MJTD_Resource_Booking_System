@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/reservation_accessories') }}">Reservation accessory</a> :
@endsection
@section("contentheader_description", $reservation_accessory->$view_col)
@section("section", "Reservation accessories")
@section("section_url", url(config('laraadmin.adminRoute') . '/reservation_accessories'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Reservation accessories Edit : ".$reservation_accessory->$view_col)

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
                {!! Form::model($reservation_accessory, ['route' => [config('laraadmin.adminRoute') . '.reservation_accessories.update', $reservation_accessory->id ], 'method'=>'PUT', 'id' => 'reservation_accessory-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'accessories_id')
					@la_input($module, 'quantity')
					@la_input($module, 'reservations_id')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/reservation_accessories') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#reservation_accessory-edit-form").validate({
        
    });
});
</script>
@endpush
