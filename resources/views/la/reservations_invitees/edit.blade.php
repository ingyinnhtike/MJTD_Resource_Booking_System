@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/reservations_invitees') }}">Reservations invitee</a> :
@endsection
@section("contentheader_description", $reservations_invitee->$view_col)
@section("section", "Reservations invitees")
@section("section_url", url(config('laraadmin.adminRoute') . '/reservations_invitees'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Reservations invitees Edit : ".$reservations_invitee->$view_col)

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
                {!! Form::model($reservations_invitee, ['route' => [config('laraadmin.adminRoute') . '.reservations_invitees.update', $reservations_invitee->id ], 'method'=>'PUT', 'id' => 'reservations_invitee-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'email')
					@la_input($module, 'reservations_id')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/reservations_invitees') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#reservations_invitee-edit-form").validate({
        
    });
});
</script>
@endpush
