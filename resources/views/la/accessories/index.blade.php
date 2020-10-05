@extends("la.layouts.app")

@section("contentheader_title", "Accessories")
@section("contentheader_description", "Accessories listing")
@section("section", "Accessories")
@section("sub_section", "Listing")
@section("htmlheader_title", "Accessories Listing")

@section("headerElems")
@la_access("Accessories", "create")
    <button class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#AddModal"><i class="fa fa-plus"> Add New Accessory</i></button>
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
    <!--<div class="box-header"></div>-->
    <div class="box-body">
        <table id="example1" class="table table-striped table-bordered">
        <thead>
        <tr>
            @foreach( $listing_cols as $col )
            <th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
            @endforeach
            @if($show_actions)
            <th>Available Resources</th>
            <th>Actions</th>
            @endif
        </tr>
        </thead>
        <tbody>
            
        </tbody>
        </table>
    </div>
</div>

@la_access("Accessories", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Accessory</h4>
            </div>
            {!! Form::open(['action' => 'LA\AccessoriesController@store', 'id' => 'accessory-add-form']) !!}
            <div class="modal-body">
                <div class="box-body">
                    @la_input($module, 'name')
					@la_input($module, 'available_quantity')
                    <div>
                        <label for="">Resources</label>
                        <select class="form-control" data-placeholder="Select Resources" rel="select2" name="select_resource" id="select_resource" onchange="addResource()">
                                <option value="0" disabled selected>Select Resources</option>
                            @foreach($resources as $resource)
                                <option value="{{ $resource->id }}">{{ $resource->name }}</option>
                            @endforeach
                        </select>        
                    </div>
                    <input type="hidden" name="resource_list" id="resource_list" value="">
                    <div>                      
                       <div class="panel panel-green resources">
                            <div class="panel-heading"></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover" id="resource_table" >
                                    <thead>
                                        <tr>
                                            <th> No. </th>
                                            <th> Resource </th>
                                            <th> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {!! Form::submit( 'Submit', ['class'=>'btn btn-info']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
let resource_row = 1;
let resource = [];
const table = document.querySelector("#resource_table").children[1];
$(function () {
    $("#example1").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/accessory_dt_ajax') }}",
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
        @if($show_actions)
        columnDefs: [ { orderable: false, targets: [-1] }],
        @endif
    });
    $("#accessory-add-form").validate({
        
    });
    document.querySelector(".resources").style.display = "none"; 
    
});
function addResource()
{
    document.querySelector(".resources").style.display = "block";   
    let select_resource = document.querySelector("#select_resource");
    let resource_id = select_resource.value;
    let resource_name = select_resource.options[select_resource.selectedIndex].text;

    let op = select_resource.options;        

    const row = document.createElement('tr');
    row.className = 'resource_'+resource_id;
    row.innerHTML = `<td>${resource_row}</td><td>${resource_name}</td>
                     <td><button type="button" class="btn btn-danger btn-xs" id="btndelete" onclick="delete_resource(${resource_id})" ><i class="fa fa-times"></i> Delete</button></td>`;

    if(resource.includes(resource_id)) {
        alert("Cannot Add");
        return;
    } else {
        if(resource_id == 0) {
            alert("Cannot Add");
            return;
        } else {
        resource_row++;
        resource.push(resource_id);                         
        table.appendChild(row);
        }
    }

    document.getElementById("resource_list").value = resource;
}
// Remove
function delete_resource(resource_id) 
{
    $(`.resource_${resource_id}`).remove();
    var resource_info = String(resource_id);
    var index = resource.indexOf(resource_info);
    if(index > -1) {
        resource.splice(index, 1);
    }
    resource_row--;
    document.getElementById("resource_list").value = resource;
    
    if(resource.length == 0)
        document.querySelector(".resources").style.display = "none";
}
</script>
@endpush
