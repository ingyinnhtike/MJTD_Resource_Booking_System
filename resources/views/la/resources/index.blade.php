@extends("la.layouts.app")

@section("contentheader_title", "Resources")
@section("contentheader_description", "Resources listing")
@section("section", "Resources")
@section("sub_section", "Listing")
@section("htmlheader_title", "Resources Listing")

@section("headerElems")
@la_access("Resources", "create")
<a class="btn btn-info btn-sm" style="float: right;" href="<?= URL::to('/admin/resources/create') ?>"><i class="fa fa-plus"> Add New Resource</i></a>
@endla_access
@endsection

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
    <div class="box-body">
        <table id="example1" class="table table-bordered">
        <thead>
        <tr>
            @foreach( $listing_cols as $col )
            <th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
            @endforeach
            @if($show_actions)
            <th>Actions</th>
            @endif
        </tr>
        </thead>
        <tbody>
            
        </tbody>
        </table>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
    $("#example1").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/resource_dt_ajax') }}",
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
        @if($show_actions)
        columnDefs: [ { orderable: false, targets: [-1] }],
        @endif
    });
    $("#resource-add-form").validate({
        
    });
});
</script>
@endpush
