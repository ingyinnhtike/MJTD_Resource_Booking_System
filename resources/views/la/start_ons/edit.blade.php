@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/start_ons') }}">Start On</a> :
@endsection
@section("contentheader_description", $start_on->$view_col)
@section("section", "Start Ons")
@section("section_url", url(config('laraadmin.adminRoute') . '/start_ons'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Start Ons Edit : ".$start_on->$view_col)

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
                {!! Form::model($start_on, ['route' => [config('laraadmin.adminRoute') . '.start_ons.update', $start_on->id ], 'method'=>'PUT', 'id' => 'start_on-edit-form']) !!}
                    @la_form($module)
                    
                    {{--
                    @la_input($module, 'day')
                    --}}
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/start_ons') }}" class="btn btn-default pull-right">Cancel</a>
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
    $("#start_on-edit-form").validate({
        
    });
});
</script>
@endpush
