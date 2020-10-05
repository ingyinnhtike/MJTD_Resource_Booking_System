@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/resources') }}">Resource</a> :
@endsection
@section("contentheader_description", $resource->$view_col)
@section("section", "Resources")
@section("section_url", url(config('laraadmin.adminRoute') . '/resources'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Resources Edit : ".$resource->$view_col)

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

<div class="box box-purple container contact">
	<div class="box-body">
                
        {!! Form::model($resource, ['route' => [config('laraadmin.adminRoute') . '.resources.update', $resource->id ], 'method'=>'PUT', 'id' => 'resource-edit-form']) !!}
            <div class="col-md-8 col-md-offset-2">
                @la_input($module, 'name')
                @la_input($module, 'schedule')
                @la_input($module, 'image')
                @la_input($module, 'notes')
                @la_input($module, 'status')
                @la_input($module, 'no_of_maximum_people')
                @la_input($module, 'room_types')
                @la_input($module, 'select_accessory')
                <div class='public'>
                    @la_input($module, 'is_public')
                </div>
                <div class="UG">
                    <input type="hidden" name="user_list" id="user_list">
                    <input type="hidden" name="group_list" id="group_list">
                    <div class="form-group  col-sm-6">
                        <label for="">Users <span style="color:red;">*</span>:</label>
                        <select class="form-control" onchange="addUser()" data-placeholder="Select Operator" rel="select2" name="selectuser" id="selectuser">
                                <option value="0" disabled selected>Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>   
                    </div>
                    <div class="form-group  col-sm-6">
                        <label for="">Groups <span style="color: red;">*</span>:</label>
                        <select class="form-control" onchange="addGroup()" data-placeholder="Select Group" rel="select2" name="selectgroup" id="selectgroup">
                                <option value="0" disabled selected>Select Group</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>   
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group col-md-6">                         
                            <div class="panel panel-info users">
                                <div class="panel-heading">Users</div>
                                <div class="panel-body">
                                    <table class="table table-striped table-hover" id="user_table" >
                                        <thead>
                                            <tr>
                                                <th> User Name </th>
                                                <th> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user_lists as $key=>$user) 
                                                <tr class="user_{{ $user->id }}">
                                                    <td>{{ $user->name }}</td>
                                                    <td><button class="btn btn-danger btn-xs" id="btndelete" onclick="deleteUser({{ $user->id }})" ><i class="fa fa-times"></i> Delete</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 

                        <div class="form-group col-md-6">                         
                            <div class="panel panel-info groups">
                                <div class="panel-heading">Groups</div>
                                <div class="panel-body">
                                    <table class="table table-striped table-hover" id="group_table" >
                                        <thead>
                                            <tr>
                                                <th> Group Name </th>
                                                <th> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($group_lists as $key=>$group) 
                                                <tr class="group_{{ $group->id }}">
                                                    <td>{{ $group->name }}</td>
                                                    <td><button class="btn btn-danger btn-xs" id="btndelete" onclick="deleteGroup({{ $group->id }})" ><i class="fa fa-times"></i> Delete</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-12">
                <div class="col-sm-6">
                    {!! Form::submit( 'Update', ['class'=>'btn btn-sm btn-info pull-right']) !!}
                </div>
                <div class="col-sm-6">
                    <a href="{{ url(config('laraadmin.adminRoute') . '/resources') }}" class="btn btn-sm btn-default">Cancel</a>
                </div>
            </div>
        {!! Form::close() !!}

	</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('la-assets/mine.js') }}"></script>
<script>
let group_row = 1;
let user_row = 1;
let is_public = <?php echo $resource->is_public; ?>;
let group_list = <?php echo json_encode($selected_group_list) ?>;
let user_list = <?php echo json_encode($selected_user_list) ?>;
const group_table = document.querySelector("#group_table").children[1];
const user_table = document.querySelector("#user_table").children[1];
$(function () {
    $("#resource-edit-form").validate({
        
    });
    if(is_public)
        $(".UG").hide();
    else
        $(".UG").show();

    $(".public").click(function () {
        $(".UG").toggle();
    });

    document.getElementById("group_list").value = group_list;
    if(group_list.length == 0)
        document.querySelector(".groups").style.display = "none";

    document.getElementById("user_list").value = user_list;
    if(user_list.length == 0)
        document.querySelector(".users").style.display = "none";
});
function addGroup()
{
    document.querySelector(".groups").style.display = "block";   
    let selectgroup = document.querySelector("#selectgroup");
    let group_id = Number(selectgroup.value);
    let group_name = selectgroup.options[selectgroup.selectedIndex].text;

    let op = selectgroup.options;        

    const row = document.createElement('tr');
    row.className = 'group_'+group_id;
    row.innerHTML = `<td>${group_name}</td>
                     <td><button type="button" class="btn btn-danger btn-xs" id="btndelete" onclick="deleteGroup(${group_id})" ><i class="fa fa-times"></i> Delete</button></td>`;

    if(group_list.includes(group_id)) {
        alert("Cannot Add");
        return;
    } else {
        if(group_id == 0) {
            alert("Cannot Add");
            return;
        } else {
            group_row++;
            group_list.push(group_id);                         
            group_table.appendChild(row);
        }
    }

    document.getElementById("group_list").value = group_list;
}
// Remove
function deleteGroup(group_id) 
{
    $(`.group_${group_id}`).remove();
    var index = group_list.indexOf(group_id);
    if(index > -1) {
        group_list.splice(index, 1);
    }
    group_row--;
    document.getElementById("group_list").value = group_list;
    
    if(group_list.length == 0)
        document.querySelector(".groups").style.display = "none";
}
function addUser()
{
    document.querySelector(".users").style.display = "block";   
    let selectuser = document.querySelector("#selectuser");
    let user_id = Number(selectuser.value);
    let user_name = selectuser.options[selectuser.selectedIndex].text;

    let op = selectuser.options;        

    const row = document.createElement('tr');
    row.className = 'group_'+user_id;
    row.innerHTML = `<td>${user_name}</td>
                     <td><button type="button" class="btn btn-danger btn-xs" id="btndelete" onclick="deleteUser(${user_id})" ><i class="fa fa-times"></i> Delete</button></td>`;

    if(user_list.includes(user_id)) {
        alert("Cannot Add");
        return;
    } else {
        if(user_id == 0) {
            alert("Cannot Add");
            return;
        } else {
            group_row++;
            user_list.push(user_id);                         
            user_table.appendChild(row);
        }
    }

    document.getElementById("user_list").value = user_list;
}
function deleteUser(user_id) 
{
    $(`.user_${user_id}`).remove();
    var index = user_list.indexOf(user_id);
    if(index > -1) {
        user_list.splice(index, 1);
    }
    user_row--;
    document.getElementById("user_list").value = user_list;
    
    if(user_list.length == 0)
        document.querySelector(".users").style.display = "none";
}
</script>
@endpush

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/mine.css') }}"/>
@endpush

