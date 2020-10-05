@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/user_groups') }}">User Group</a> :
@endsection
@section("contentheader_description", $user_group->$view_col)
@section("section", "User Groups")
@section("section_url", url(config('laraadmin.adminRoute') . '/user_groups'))
@section("sub_section", "Edit")

@section("htmlheader_title", "User Groups Edit : ".$user_group->$view_col)

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
                {!! Form::model($user_group, ['route' => [config('laraadmin.adminRoute') . '.user_groups.update', $user_group->id ], 'method'=>'PUT', 'id' => 'user_group-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'user_id')
					@la_input($module, 'group_id')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/user_groups') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#user_group-edit-form").validate({
        
    });
});
</script>
@endpush
