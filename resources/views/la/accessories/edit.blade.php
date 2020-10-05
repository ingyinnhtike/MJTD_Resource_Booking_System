@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/accessories') }}">Accessories</a> :
@endsection
@section("contentheader_description", $accessory->$view_col)
@section("section", "Accessories")
@section("section_url", url(config('laraadmin.adminRoute') . '/accessories'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Accessories Edit : ".$accessory->$view_col)

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

<div class="col-md-7 box box-purple">
    <div class="box-body">
        <div class="row">
            <div class="content">
                <div class="col-md-8 col-md-offset-2">
                    {!! Form::model($accessory, ['route' => [config('laraadmin.adminRoute') . '.accessories.update', $accessory->id ], 'method'=>'PUT', 'id' => 'accessory-edit-form']) !!}
                        @la_form($module)
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
                                                <th> Resource </th>
                                                <th> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($resource_lists as $key=>$resource) 
                                                <tr class="resource_{{ $resource->id }}">
                                                    <td>{{ $resource->name }}</td>
                                                    <td><button class="btn btn-danger btn-xs" id="btndelete" onclick="delete_resource({{ $resource->id }})" ><i class="fa fa-times"></i> Delete</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                        <div class="form-group">
                            <div class="col-sm-6"> 
                            {!! Form::submit( 'Update', ['class'=>'btn btn-info']) !!}
                            </div>
                            <div class="col-sm-6"> 
                                <a href="{{ url(config('laraadmin.adminRoute') . '/accessories') }}" class="btn btn-default pull-right">Cancel</a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
let resource_row = 1;
let resource_list = <?php echo json_encode($resource_id_array) ?>;
const table = document.querySelector("#resource_table").children[1];
$(function () {
    $("#accessory-edit-form").validate({
        
    });
    document.getElementById("resource_list").value = resource_list;
    if(resource_list.length == 0)
        document.querySelector(".resources").style.display = "none";
});
function addResource()
{
    document.querySelector(".resources").style.display = "block";   
    let select_resource = document.querySelector("#select_resource");
    let resource_id = Number(select_resource.value);
    let resource_name = select_resource.options[select_resource.selectedIndex].text;

    let op = select_resource.options;        

    const row = document.createElement('tr');
    row.className = 'resource_'+resource_id;
    row.innerHTML = `<td>${resource_name}</td>
                     <td><button type="button" class="btn btn-danger btn-xs" id="btndelete" onclick="delete_resource(${resource_id})" ><i class="fa fa-times"></i> Delete</button></td>`;

    if(resource_list.includes(resource_id)) {
        alert("Cannot Add");
        return;
    } else {
        if(resource_id == 0) {
            alert("Cannot Add");
            return;
        } else {
            resource_row++;
            resource_list.push(resource_id);                         
            table.appendChild(row);
        }
    }

    document.getElementById("resource_list").value = resource_list;
}
// Remove
function delete_resource(resource_id) 
{
    $(`.resource_${resource_id}`).remove();
    var resource_info = resource_id;
    var index = resource_list.indexOf(resource_info);
    if(index > -1) {
        resource_list.splice(index, 1);
    }
    resource_row--;
    document.getElementById("resource_list").value = resource_list;
    
    if(resource_list.length == 0)
        document.querySelector(".resources").style.display = "none";
}
</script>
@endpush
