@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/groups') }}">Group</a> :
@endsection
@section("contentheader_description", $group->$view_col)
@section("section", "Groups")
@section("section_url", url(config('laraadmin.adminRoute') . '/groups'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Groups Edit : ".$group->$view_col)

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
    <div class="box-header">
        
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {!! Form::model($group, ['route' => [config('laraadmin.adminRoute') . '.groups.update', $group->id ], 'method'=>'PUT', 'id' => 'group-edit-form']) !!}
                    @la_form($module)
                    <div class="form-group">
                        <label for="">Users <span style="color:red;">*</span> :</label>
                        <select class="form-control" onchange="addUser()" data-placeholder="Select Operator" rel="select2" name="select_user" id="select_user">
                                <option value="0" disabled selected>Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id}}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">                     
                        <input type='hidden' id="user_list" name='user_list' value=''>
                        <div class="panel panel-green users">                               
                            <div class="panel-body">
                                <table class="table table-striped table-hover" id="user_table" >
                                    <thead>
                                        <tr>
                                            <th> User Name </th>
                                            <th> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($username as $usernames)
                                            <tr class="user_{{$usernames->id}}">
                                                <td>{{$usernames->name}}</td>
                                                <td><button class="btn btn-danger btn-xs" id="btneditdelete" value='{{$usernames->id}}' onclick="deleteUser({{$usernames->id}})" ><i class="fa fa-times"></i> Delete</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>                           
                    </div>
                {!! Form::submit( 'Update', ['class'=>'btn btn-info']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/groups') }}" class="btn btn-default pull-right">Cancel</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let user_row = 1;
let user_list = <?php echo json_encode($user_id_array) ?>;
const table = document.querySelector("#user_table").children[1];
$(function () {
    $("#group-edit-form").validate({
        
    });
    document.getElementById("user_list").value = user_list;
    if(user_list.length == 0)
        document.querySelector(".users").style.display = "none";
});
function addUser()
{
    document.querySelector(".users").style.display = "block";   
    let select_user = document.querySelector("#select_user");
    let user_id = Number(select_user.value);
    let user_name = select_user.options[select_user.selectedIndex].text;

    let op = select_user.options;        

    const row = document.createElement('tr');
    row.className = 'user_'+user_id;
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
            user_row++;
            user_list.push(user_id);                         
            table.appendChild(row);
        }
    }
    document.getElementById("user_list").value = user_list;
}
// Remove
function deleteUser(user_id) 
{
    $(`.user_${user_id}`).remove();
    var user_info = user_id;
    var index = user_list.indexOf(user_info);
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
