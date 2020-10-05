@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/reservation_statuses') }}">Reservation status</a> :
@endsection
@section("contentheader_description", $reservation_status->$view_col)
@section("section", "Reservation statuses")
@section("section_url", url(config('laraadmin.adminRoute') . '/reservation_statuses'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Reservation statuses Edit : ".$reservation_status->$view_col)

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
                {!! Form::model($reservation_status, ['route' => [config('laraadmin.adminRoute') . '.reservation_statuses.update', $reservation_status->id ], 'method'=>'PUT', 'id' => 'reservation_status-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'reservations_id')
					@la_input($module, 'user_id')
					@la_input($module, 'reservation_status')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/reservation_statuses') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#reservation_status-edit-form").validate({
        
    });
});
</script>
@endpush
