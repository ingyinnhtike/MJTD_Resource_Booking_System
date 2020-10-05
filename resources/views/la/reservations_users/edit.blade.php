@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/reservations_users') }}">Reservations user</a> :
@endsection
@section("contentheader_description", $reservations_user->$view_col)
@section("section", "Reservations users")
@section("section_url", url(config('laraadmin.adminRoute') . '/reservations_users'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Reservations users Edit : ".$reservations_user->$view_col)

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
                {!! Form::model($reservations_user, ['route' => [config('laraadmin.adminRoute') . '.reservations_users.update', $reservations_user->id ], 'method'=>'PUT', 'id' => 'reservations_user-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'user_id')
					@la_input($module, 'reservations_id')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/reservations_users') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#reservations_user-edit-form").validate({
        
    });
});
</script>
@endpush
