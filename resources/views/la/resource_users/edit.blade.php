@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/resource_users') }}">Resource User</a> :
@endsection
@section("contentheader_description", $resource_user->$view_col)
@section("section", "Resource Users")
@section("section_url", url(config('laraadmin.adminRoute') . '/resource_users'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Resource Users Edit : ".$resource_user->$view_col)

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
                {!! Form::model($resource_user, ['route' => [config('laraadmin.adminRoute') . '.resource_users.update', $resource_user->id ], 'method'=>'PUT', 'id' => 'resource_user-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'resource_id')
					@la_input($module, 'user_id')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/resource_users') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#resource_user-edit-form").validate({
        
    });
});
</script>
@endpush
