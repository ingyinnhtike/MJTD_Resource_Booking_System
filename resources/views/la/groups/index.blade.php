@extends("la.layouts.app")

@section("contentheader_title", "Groups")
@section("contentheader_description", "Groups listing")
@section("section", "Groups")
@section("sub_section", "Listing")
@section("htmlheader_title", "Groups Listing")

@section("headerElems")
@la_access("Groups", "create")
    <button class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#AddModal"><i class="fa fa-plus">Add New Group</i></button>
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
        <table id="example1" class="table table-bordered table-striped table-hover">
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

@la_access("Groups", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Group</h4>
            </div>
            {!! Form::open(['action' => 'LA\GroupsController@store', 'id' => 'group-add-form']) !!}
            <div class="modal-body">
                <div class="box-body">
                    @la_form($module)
                    <div class="form-group">
                        <label for="">Users <span style="color:red;">*</span>:</label>
                        <select class="form-control" onchange="addoperator()" data-placeholder="Select Operator" rel="select2" name="selectoperator" id="selectoperator">
                            <option value="0" disabled selected>Select User</option>
                            @foreach($user as $users)
                            <option value="{{ $users->id }}">{{ $users->name }}</option>
                            @endforeach
                        </select>  
                    </div>
                    <input type="hidden" name="user_list" id="user_list" value="">
                    <div class="form-group">                         
                        <div class="panel panel-green operators">
                            <div class="panel-body">
                                <table class="table table-striped table-hover" id="operatortable" >
                                    <thead>
                                        <tr>
                                            <th> User Name </th>
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

$(function () {
    $("#example1").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/group_dt_ajax') }}",
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
        @if($show_actions)
        columnDefs: [ { orderable: false, targets: [-1] }],
        @endif
    });
    $("#group-add-form").validate({
        
    });
});

let operator_row = 1;
let operator = [];

// Operators

// Add
const table = document.querySelector("#operatortable").children[1];

if(operator.length == 0)
{
    document.querySelector(".operators").style.display = "none";
}

var i = 0;

i++;

function addoperator()
{
    document.querySelector(".operators").style.display = "block";   
    let selectoperator = document.querySelector("#selectoperator");
    let operator_id = selectoperator.value;
    let operator_name = selectoperator.options[selectoperator.selectedIndex].text;
    let i=selectoperator.value;

    let op = selectoperator.options;        

    const row = document.createElement('tr');
    row.className = 'operator_'+operator_id;
    row.innerHTML = `<td><input type='hidden' name='user_id[]' value='${operator_id}'>${operator_name}</td>
                     <td><button class="btn btn-danger btn-xs" id="btndelete" onclick="deleteoperator(${operator_id})" ><i class="fa fa-times"></i> Delete</button></td>`;

    if(operator.includes(operator_id)) {
        alert("Cannot Add");
        return;
    } else {
        if(operator_id == 0) {
            alert("Cannot Add");
            return;
        } else {
            operator_row++;
            let i=0;
            i++;
            operator.push(operator_id);                         
            table.appendChild(row);
        }
    }

    document.getElementById("user_list").value = operator;
}

// Remove
function deleteoperator(operator_id) 
{
    $(`.operator_${operator_id}`).remove();
    var operator_info = String(operator_id);
    var index = operator.indexOf(operator_info);
    console.log(index);
    if(index > -1) {
        operator.splice(index, 1);
    }
    operator_row--;
    console.log(operator);
    document.getElementById("user_list").value = operator;
}

</script>
@endpush
