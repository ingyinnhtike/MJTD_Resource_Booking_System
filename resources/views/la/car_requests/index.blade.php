@extends("la.layouts.app")

@section("contentheader_title", "Car Requests")
@section("contentheader_description", "Car Requests listing")
@section("section", "Car Requests")
@section("sub_section", "Listing")
@section("htmlheader_title", "Car Requests Listing")

@section("headerElems")
@la_access("Car_Requests", "create")
    <button class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Car Request</button>
@endla_access
@endsection

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
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
            <th>ID</th>
            <th>Requested Person</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Destination</th>
            <th>Number of Participants</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
            @foreach( $car_request_list as $car_request_lists )
            <tr>
                <td>{{$car_request_lists->id}}</td>
                <?php $user = DB::table('users')->where('id', $car_request_lists->user_id)->first(); ?>
                <td><a href="{{ url(config('laraadmin.adminRoute') . '/car_requests/'.$car_request_lists->id) }}">@if(isset($user)) {{$user->name}} @endif</a></td>
                <td><a href="{{ url(config('laraadmin.adminRoute') . '/car_requests/'.$car_request_lists->id) }}">{{$car_request_lists->start_date}}</a></td>
                <td><a href="{{ url(config('laraadmin.adminRoute') . '/car_requests/'.$car_request_lists->id) }}">{{$car_request_lists->end_date}}</a></td>
                <td><a href="{{ url(config('laraadmin.adminRoute') . '/car_requests/'.$car_request_lists->id) }}">{{$car_request_lists->start_time}}</a></td>
                <td><a href="{{ url(config('laraadmin.adminRoute') . '/car_requests/'.$car_request_lists->id) }}">{{$car_request_lists->end_time}}</a></td>
                <td><a href="{{ url(config('laraadmin.adminRoute') . '/car_requests/'.$car_request_lists->id) }}">{{$car_request_lists->way}}</a></td>            
                <td>{{$car_request_lists->no_of_participant}}</td>
                <td><a href="{{ url(config('laraadmin.adminRoute') . '/car_requests/'.$car_request_lists->id) }}">{{ $car_request_lists->status }}</a></td>
                <td>
                @if($car_request_lists->status != 'Confirmed')
                    <a href="{{ url(config('laraadmin.adminRoute') . '/car_requests/'.$car_request_lists->id . '/edit') }}" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;">Edit</i></a>
                    <a href="{{ url(config('laraadmin.adminRoute') . '/car_requests/'.$car_request_lists->id . '/cancel') }}" class="btn btn-danger btn-xs" style="display:inline;padding:2px 5px 3px 5px;">Cancel</i></a>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</div>

@la_access("Car_Requests", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Car Request</h4>
            </div>
            {!! Form::open(['action' => 'LA\Car_RequestsController@store', 'id' => 'car_request-add-form']) !!}
            <div class="modal-body">
                <div class="box-body">
                    
                    <input type="hidden" name="status" value="Requested">
                    <input type="hidden" name="user_id" value="{{$user_id}}">
                        <div class="request_status">
                        @la_input($module, 'request_status')
                        </div>
                        <div class="row">
                            <div class='col-sm-6'>
                                <div class="form-group bootstrap-timepicker timepicker">
                                <label for="">Start Date :</label>
                                   <input type="date" id="startdate" class="form-control" name="start_date" onchange="getstartdate(); checkRequestTime();">
                                </div>
                            </div>

                            <div class='col-sm-6'>
                                <div class="form-group bootstrap-timepicker timepicker">
                                <label for="">End Date :</label>
                                <input type="date" id="enddate" class="form-control" name="end_date">  
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class='col-sm-6'>
                                <div class="form-group bootstrap-timepicker timepicker">
                                <label for="">Start Time :</label>
                                    <div class='input-group time' id='timepicker1'>
                                    <input id="start_time" name="start_time" type="text" class="form-control input-small" onchange="checkRequestTime();">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class='col-sm-6'>
                                <div class="form-group bootstrap-timepicker timepicker">
                                <label for="">End Time :</label>
                                    <div class='input-group time' id='timepicker2'>
                                        <input type='text' name="end_time" class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <label class="control-label" id="dmes">Destination :</label>
                    <span id="errormsg" style="color: red; display: none;">
                    If you want to go to Downtown, please make a reservation one day in advance or if you want to go to  Zone and Thanlyin, please request half an hour in advance!
                    </span>                
                        <select class="js-example-basic-multiple form-control" onchange="checkRequestTime(this.value);" id="destination" name="destination">
                            <option selected disabled>Choose Destination</option>
                                <option value="1">Zone</option>
                                <option value="1">Thanlyin</option>
                                <option value="2">Downtown</option>
                        </select>
                    <div class="desvalid" style="display: none;">
                        @la_input($module, 'way')
                        @la_input($module, 'purpose')
                        @la_input($module, 'no_of_participant')
                        @la_input($module, 'participants')
                        @la_input($module, 'remark')
                    </div>
				
                </div>
            </div>
            <div class="modal-footer">
                <div class="desvalid" style="display: none;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit( 'Submit', ['class'=>'btn btn-info']) !!}
                
                </div>
                
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="{{ asset('css/notiflix-2.4.0.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script src="{{ asset('js/notiflix-2.4.0.min.js') }}"></script>
<script>
$(function () {
    $("#example1").DataTable({
        processing: true,
        @if($show_actions)
        columnDefs: [ { orderable: false, targets: [-1] }],
        @endif
    });
    $("#car_request-add-form").validate({
        
    });
});
</script>
<script type="text/javascript">
$('#end_date').val($('#start_date').val());

    $('#timepicker1').datetimepicker({
        format: 'LT'
  });
  
  $('#timepicker2').datetimepicker({
    format: 'LT'
  });

  
</script>
<script>
    function getstartdate() {
    var dategtc = new Date($('#startdate').val());
    console.log(dategtc);
    var day=dategtc.getDay();

    $('#enddate').val($('#startdate').val());
    };


function checkRequestTime(start_time){
    var destination = $("#destination option:selected").val();
    var startDate = $('#startdate').val();
    
    var now = moment(now).format('YYYY-MM-DD');
    
    var deltaMinutes = 30
    var d = new Date();
    var dt = d.setMinutes( d.getMinutes() + 30 );
    var current_time = moment(dt).format('HH:mm');
    console.log(current_time);
    
    var startTime = $('#start_time').val();
    var start_time = moment(startTime, ["h:mm A"]).format("HH:mm");
    //console.log(start_time);
    var req_status = $("input[name='request_status']:checked").val();
    //console.log(req_status);
    Notiflix.Report.Init({
        width: '300px',
        height: '20px',
        svgSize: '50px'
            });
    if((destination == 2 && startDate > now) || (destination == 1 && start_time > current_time) || (destination == 1 && startDate > now) || req_status == 'Urgent' )
    {
        $(".desvalid").css('display', 'block');
        //$("#errormsg").css('display', 'none');
        

    }else{
        $(".desvalid").css('display', 'none');
        //$("#errormsg").css('display', 'block');   
        Notiflix.Report.Warning( 'Car Request Warning', 
        'If you want to go to Downtown, please make a reservation one day in advance or if you want to go to Zone and Thanlyin, please request half an hour in advance!', 'OK' ); 
        //Notiflix.Report.Warning('If you want to go to Downtown, please make a reservation one day in advance or if you want to go to Zone and Thanlyin, please request half an hour in advance!');
           
    }
    
}

$(document).ready(function(){
    $(".request_status").click(function () {
        var req_status = $("input[name='request_status']:checked").val();
        console.log(req_status);
        if(req_status == 'Urgent')
        {
            $(".desvalid").css('display', 'block');
            $("#errormsg").css('display', 'none');
        }else
        {
            $(".desvalid").css('display', 'none');
        }
    });
});

    


</script>






@endpush
